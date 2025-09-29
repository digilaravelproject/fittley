<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DirectMessage;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class DirectMessageController extends Controller
{
    /**
     * Get user's conversations
     */
    public function getConversations(Request $request): JsonResponse
    {
        $request->validate([
            'per_page' => 'nullable|integer|min:1|max:50',
        ]);

        $userId = auth()->id();
        $perPage = $request->per_page ?? 20;

        // $conversations = Conversation::with(['userOne:id,name,avatar','userTwo:id,name,avatar','lastMessage'])->forUser($userId)
        $conversations = Conversation::with(['userOne:id,name,avatar', 'userTwo:id,name,avatar'])->forUser($userId)
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage);

        // Add unread message counts
        $conversations->getCollection()->transform(function ($conversation) use ($userId) {
            $conversation->unread_count = $conversation->getUnreadCount($userId);
            $conversation->other_participant = $conversation->getOtherParticipant($userId);
            $conversation->last_message = $conversation->lastMessage();
            return $conversation;
        });

        return response()->json([
            'success' => true,
            'data' => $conversations,
        ]);
    }

    /**
     * Create or get existing conversation
     */
    public function createConversation(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = auth()->id();
        $otherUserId = $request->user_id;

        // Can't create conversation with yourself
        if ($userId === $otherUserId) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot create conversation with yourself',
            ], 400);
        }

        // Check if conversation already exists
        $existingConversation = Conversation::betweenUsers($userId, $otherUserId)->first();


        if ($existingConversation) {
            $participants = collect([$existingConversation->userOne, $existingConversation->userTwo])
                ->filter()
                ->map(fn($user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'avatar' => $user->avatar,
                ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'conversation' => $existingConversation,
                    'participants' => $participants,
                ]
            ]);
        }

        // Check if users are friends or if non-friend messaging is allowed
        $canMessage = $this->canSendMessage($userId, $otherUserId);
        if (!$canMessage['allowed']) {
            return response()->json([
                'success' => false,
                'message' => $canMessage['reason'],
            ], 403);
        }

        try {
            $conversation = Conversation::create([
                // 'type' => 'direct',
                'user_one_id' => $userId,
                'user_two_id' => $otherUserId,
            ]);

            // Add participants
            $conversation->participants()->attach([$userId, $otherUserId]);

            return response()->json([
                'success' => true,
                'message' => 'Conversation created successfully',
                'data' => $conversation->load(['userOne:id,name,avatar', 'userTwo:id,name,avatar']),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create conversation',
            ], 500);
        }
    }

    /**
     * Get messages in a conversation
     */
    public function getMessages(Request $request, $conversationId): JsonResponse
    {
        // Step 1: Validate request inputs
        $request->validate([
            'per_page' => 'nullable|integer|min:1|max:100',
            'before' => 'nullable|integer',
        ]);
        // Step 2: Fetch conversation with participants
        $conversation = Conversation::with([
            'userOne:id,name,avatar',
            'userTwo:id,name,avatar',
        ])->where('id', $conversationId)->firstOrFail();
        // Collect participants for response
        $participants = collect([$conversation->userOne, $conversation->userTwo])->filter();
        // Step 3: Authorization - check if authenticated user is a participant
        $userId = auth()->id();
        if (!$conversation->hasParticipant($userId)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to access this conversation',
            ], 403);
        }
        // Step 4: Prepare messages query with optional cursor
        $perPage = $request->input('per_page', 50);
        $query = $conversation->messages()
            ->with('sender:id,name,avatar')
            ->orderBy('created_at', 'desc');
        if ($request->filled('before')) {
            $query->where('id', '<', $request->before);
        }
        // Step 5: Fetch messages and sort ascending for UI
        $messages = $query->limit($perPage)->get()->sortBy('created_at')->values();
        // Step 6: Determine if more messages exist for pagination
        $hasMore = $messages->count() === $perPage;
        // Step 7: Return JSON response
        return response()->json([
            'success' => true,
            'data' => [
                'conversation' => $conversation,
                'participants' => $participants,
                'messages' => $messages,
                'has_more' => $hasMore,
            ],
        ]);
    }

    /**
     * Send message in conversation
     */
    public function sendMessage(Request $request, $conversationId): JsonResponse
    {
        try {
            $request->validate([
                'content' => 'required|string|max:1000',
            ]);
        } catch (\Illuminate\Validation\ValidationException $ve) {
            Log::error('Validation failed in sendMessage', ['errors' => $ve->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $ve->errors(),
            ], 422);
        }

        try {
            $conversation = Conversation::findOrFail($conversationId);
            $userId = auth()->id();

            // Check if user is participant
            if (!$conversation->hasParticipant($userId)) {
                Log::warning("Unauthorized sendMessage attempt by user $userId in conversation $conversationId");
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to send message in this conversation',
                ], 403);
            }

            // Check message limits
            $canSend = $this->checkMessageLimits($userId, $conversation);
            if (!$canSend['allowed']) {
                Log::info("Message limit reached for user $userId in conversation $conversationId: " . $canSend['reason']);
                return response()->json([
                    'success' => false,
                    'message' => $canSend['reason'],
                ], 429);
            }

            $receiverId = $conversation->getOtherParticipant($userId)->id;

            $message = DirectMessage::create([
                'sender_id' => $userId,
                'receiver_id' => $receiverId,
                'message' => $request->content,
                'content' => $request->content,
            ]);

            // Update conversation timestamp
            $conversation->touch();

            // Load sender info
            $message->load(['sender:id,name,avatar']);

            Log::info("Message sent successfully by user $userId in conversation $conversationId", ['message_id' => $message->id]);

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully',
                'data' => $message,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Failed to send message', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'conversation_id' => $conversationId,
                'user_id' => auth()->id(),
                'request_content' => $request->content ?? null,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send message',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



    /**
     * Mark conversation as read
     */
    public function markAsRead($conversationId): JsonResponse
    {
        $conversation = Conversation::findOrFail($conversationId);
        $userId = auth()->id();

        // Check if user is participant
        if (!$conversation->hasParticipant($userId)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to access this conversation',
            ], 403);
        }

        // Mark all messages as read
        $conversation->messages()
            ->where('sender_id', '!=', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Conversation marked as read',
        ]);
    }

    /**
     * Delete conversation (for current user only)
     */
    public function deleteConversation($conversationId): JsonResponse
    {
        $conversation = Conversation::findOrFail($conversationId);
        $userId = auth()->id();

        // Check if user is participant
        if (!$conversation->hasParticipant($userId)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to delete this conversation',
            ], 403);
        }

        // Soft delete for the user (add to deleted_for field)
        $deletedFor = $conversation->deleted_for ?? [];
        if (!in_array($userId, $deletedFor)) {
            $deletedFor[] = $userId;
            $conversation->update(['deleted_for' => $deletedFor]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Conversation deleted successfully',
        ]);
    }

    /**
     * Check if user can send message to another user
     */
    private function canSendMessage($senderId, $receiverId): array
    {
        // Check if they are friends
        $user = User::find($senderId);
        $isFriend = $user->isFriendsWith($receiverId);

        if ($isFriend) {
            return ['allowed' => true];
        }

        // Check admin settings for non-friend messaging
        $nonFriendMessagingEnabled = Cache::remember('non_friend_messaging_enabled', 3600, function () {
            return config('community.non_friend_messaging_enabled', false);
        });

        if (!$nonFriendMessagingEnabled) {
            return [
                'allowed' => false,
                'reason' => 'You can only message your friends',
            ];
        }

        return ['allowed' => true];
    }

    /**
     * Check message limits based on admin settings
     */
    private function checkMessageLimits($userId, $conversation): array
    {
        $otherParticipant = $conversation->getOtherParticipant($userId);
        $user = User::find($userId);
        $isFriend = $user->isFriendsWith($otherParticipant->id);

        if ($isFriend) {
            // No limits for friends
            return ['allowed' => true];
        }

        // Get admin settings for non-friend message limits
        $dailyLimit = Cache::remember('non_friend_daily_message_limit', 3600, function () {
            return config('community.non_friend_daily_message_limit', 10);
        });

        if ($dailyLimit === 0) {
            return ['allowed' => true]; // No limit
        }

        // Count messages sent today to non-friends
        $todayCount = DirectMessage::where('sender_id', $userId)
            ->whereDate('created_at', today())
            ->where(function ($query) use ($userId) {
                $query->whereHas('receiver', function ($receiverQuery) use ($userId) {
                    $receiverQuery->whereDoesntHave('friends', function ($friendQuery) use ($userId) {
                        $friendQuery->where('friend_id', $userId)->where('status', 'accepted');
                    });
                });
            })
            ->orWhere(function ($query) use ($userId) {
                $query->whereHas('sender', function ($senderQuery) use ($userId) {
                    $senderQuery->whereDoesntHave('friends', function ($friendQuery) use ($userId) {
                        $friendQuery->where('friend_id', $userId)->where('status', 'accepted');
                    });
                });
            })
            ->count();

        if ($todayCount >= $dailyLimit) {
            return [
                'allowed' => false,
                'reason' => "Daily message limit to non-friends reached ($dailyLimit messages)",
            ];
        }

        return ['allowed' => true];
    }
}
