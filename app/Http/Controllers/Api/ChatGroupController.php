<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\DirectMessage;
use App\Models\Group;
use App\Models\GroupMessage;
use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatGroupController extends Controller
{
    /**
     * Get all conversations (personal chats and groups)
     */
    public function getAllConversations(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $perPage = $request->get('per_page', 20);

            // Get personal conversations
            $personalChats = $this->getPersonalChats($request, $user);
            
            // Get group conversations
            $groupChats = $this->getGroupChats($request, $user);

            // Combine and sort by last activity
            $allConversations = collect()
                ->merge($personalChats)
                ->merge($groupChats)
                ->sortByDesc('last_activity')
                ->values()
                ->take($perPage);

            return response()->json([
                'success' => true,
                'data' => [
                    'conversations' => $allConversations,
                    'total_unread' => $this->getTotalUnreadCount($user)
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch conversations',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get only personal chats
     */
    public function getPersonalChats(Request $request = null, $user = null): JsonResponse|array
    {
        try {
            $user = $user ?? Auth::user();
            $perPage = $request ? $request->get('per_page', 20) : 20;

            $conversations = Conversation::with(['userOne', 'userTwo', 'latestMessage'])
                ->forUser($user->id)
                ->orderBy('last_message_at', 'desc')
                ->limit($perPage)
                ->get()
                ->map(function ($conversation) use ($user) {
                    $otherUser = $conversation->getOtherParticipant($user->id);
                    return [
                        'id' => $conversation->id,
                        'type' => 'personal',
                        'name' => $otherUser ? $otherUser->name : 'Unknown User',
                        'image' => $otherUser ? $otherUser->profile_image_url : null,
                        'other_user' => $otherUser ? [
                            'id' => $otherUser->id,
                            'name' => $otherUser->name,
                            'username' => $otherUser->username,
                            'profile_image' => $otherUser->profile_image_url,
                            'is_online' => $otherUser->is_online ?? false,
                            'last_seen' => $otherUser->last_seen_at ? $otherUser->last_seen_at->format('Y-m-d H:i:s') : null
                        ] : null,
                        'last_message' => $conversation->latestMessage ? [
                            'id' => $conversation->latestMessage->id,
                            'content' => $conversation->latestMessage->content,
                            'sender_id' => $conversation->latestMessage->sender_id,
                            'is_read' => $conversation->latestMessage->is_read,
                            'sent_at' => $conversation->latestMessage->created_at->format('Y-m-d H:i:s'),
                            'time_ago' => $conversation->latestMessage->created_at->diffForHumans()
                        ] : null,
                        'unread_count' => $conversation->getUnreadCount($user->id),
                        'last_activity' => $conversation->last_message_at ? $conversation->last_message_at->format('Y-m-d H:i:s') : $conversation->created_at->format('Y-m-d H:i:s'),
                        'is_accepted' => $conversation->is_accepted,
                        'created_at' => $conversation->created_at->format('Y-m-d H:i:s')
                    ];
                });

            if ($request) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'chats' => $conversations,
                        'total_unread' => $this->getTotalUnreadPersonalCount($user)
                    ]
                ]);
            }

            return $conversations->toArray();
        } catch (\Exception $e) {
            
            if ($request) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to fetch personal chats',
                    'error' => $e->getMessage()
                ], 500);
            }
            return [];
        }
    }

    /**
     * Get only group chats
     */
    public function getGroupChats(Request $request = null, $user = null): JsonResponse|array
    {
        try {
            $user = $user ?? Auth::user();
            $perPage = $request ? $request->get('per_page', 20) : 20;

            $groups = Group::with(['members.user', 'latestMessage.sender'])
                ->whereHas('members', function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->where('status', 'active');
                })
                ->orderBy('last_activity_at', 'desc')
                ->limit($perPage)
                ->get()
                ->map(function ($group) use ($user) {
                    return [
                        'id' => $group->id,
                        'type' => 'group',
                        'name' => $group->name,
                        'description' => $group->description,
                        'image' => $group->image_url,
                        'members_count' => $group->members->where('status', 'active')->count(),
                        'members' => $group->members->where('status', 'active')->take(5)->map(function ($member) {
                            return [
                                'id' => $member->user->id,
                                'name' => $member->user->name,
                                'profile_image' => $member->user->profile_image_url,
                                'role' => $member->role
                            ];
                        }),
                        'last_message' => $group->latestMessage ? [
                            'id' => $group->latestMessage->id,
                            'content' => $group->latestMessage->content,
                            'sender' => [
                                'id' => $group->latestMessage->sender->id,
                                'name' => $group->latestMessage->sender->name,
                                'profile_image' => $group->latestMessage->sender->profile_image_url
                            ],
                            'sent_at' => $group->latestMessage->created_at->format('Y-m-d H:i:s'),
                            'time_ago' => $group->latestMessage->created_at->diffForHumans()
                        ] : null,
                        'unread_count' => $this->getGroupUnreadCount($group->id, $user->id),
                        'last_activity' => $group->last_message_at ? $group->last_message_at->format('Y-m-d H:i:s') : $group->created_at->format('Y-m-d H:i:s'),
                        'is_admin' => $group->members->where('user_id', $user->id)->first()?->role === 'admin',
                        'privacy' => $group->privacy,
                        'created_at' => $group->created_at->format('Y-m-d H:i:s')
                    ];
                });

            if ($request) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'groups' => $groups,
                        'total_unread' => $this->getTotalUnreadGroupCount($user)
                    ]
                ]);
            }

            return $groups->toArray();
        } catch (\Exception $e) {
            if ($request) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to fetch group chats',
                    'error' => $e->getMessage()
                ], 500);
            }
            return [];
        }
    }

    /**
     * Get messages from a personal conversation
     */
    public function getPersonalMessages(Request $request, $conversationId): JsonResponse
    {
        try {
            $user = Auth::user();
            $perPage = $request->get('per_page', 50);
            $before = $request->get('before'); // Message ID for pagination

            $conversation = Conversation::find($conversationId);
            if (!$conversation || !$conversation->hasParticipant($user->id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Conversation not found or access denied'
                ], 404);
            }

            $query = DirectMessage::with(['sender'])
                ->betweenUsers($conversation->user_one_id, $conversation->user_two_id)
                ->orderBy('created_at', 'desc');

            if ($before) {
                $query->where('id', '<', $before);
            }

            $messages = $query->paginate($perPage);

            $formattedMessages = $messages->getCollection()->map(function ($message) use ($user) {
                return [
                    'id' => $message->id,
                    'content' => $message->content,
                    'sender' => [
                        'id' => $message->sender->id,
                        'name' => $message->sender->name,
                        'profile_image' => $message->sender->profile_image_url
                    ],
                    'is_own_message' => $message->sender_id === $user->id,
                    'is_read' => $message->is_read,
                    'message_type' => $message->message_type ?? 'text',
                    'media_url' => $message->media_url,
                    'sent_at' => $message->created_at->format('Y-m-d H:i:s'),
                    'time_ago' => $message->created_at->diffForHumans()
                ];
            });

            // Mark messages as read
            DirectMessage::betweenUsers($conversation->user_one_id, $conversation->user_two_id)
                ->where('sender_id', '!=', $user->id)
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);

            return response()->json([
                'success' => true,
                'data' => [
                    'conversation' => [
                        'id' => $conversation->id,
                        'other_user' => $conversation->getOtherParticipant($user->id)
                    ],
                    'messages' => $formattedMessages,
                    'pagination' => [
                        'current_page' => $messages->currentPage(),
                        'last_page' => $messages->lastPage(),
                        'per_page' => $messages->perPage(),
                        'total' => $messages->total(),
                        'has_more_pages' => $messages->hasMorePages()
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch messages',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get messages from a group conversation
     */
    public function getGroupMessages(Request $request, $groupId): JsonResponse
    {
        try {
            $user = Auth::user();
            $perPage = $request->get('per_page', 50);
            $before = $request->get('before'); // Message ID for pagination

            $group = Group::find($groupId);
            if (!$group || !$this->isGroupMember($group->id, $user->id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Group not found or access denied'
                ], 404);
            }

            $query = GroupMessage::with(['sender'])
                ->where('group_id', $groupId)
                ->orderBy('created_at', 'desc');

            if ($before) {
                $query->where('id', '<', $before);
            }

            $messages = $query->paginate($perPage);

            $formattedMessages = $messages->getCollection()->map(function ($message) use ($user) {
                return [
                    'id' => $message->id,
                    'content' => $message->content,
                    'sender' => [
                        'id' => $message->sender->id,
                        'name' => $message->sender->name,
                        'profile_image' => $message->sender->profile_image_url
                    ],
                    'is_own_message' => $message->sender_id === $user->id,
                    'message_type' => $message->message_type ?? 'text',
                    'media_url' => $message->media_url,
                    'sent_at' => $message->created_at->format('Y-m-d H:i:s'),
                    'time_ago' => $message->created_at->diffForHumans()
                ];
            });

            // Mark messages as read for this user
            $this->markGroupMessagesAsRead($groupId, $user->id);

            return response()->json([
                'success' => true,
                'data' => [
                    'group' => [
                        'id' => $group->id,
                        'name' => $group->name,
                        'image' => $group->image_url,
                        'members_count' => $group->members->where('status', 'active')->count()
                    ],
                    'messages' => $formattedMessages,
                    'pagination' => [
                        'current_page' => $messages->currentPage(),
                        'last_page' => $messages->lastPage(),
                        'per_page' => $messages->perPage(),
                        'total' => $messages->total(),
                        'has_more_pages' => $messages->hasMorePages()
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch group messages',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send a personal message
     */
    public function sendPersonalMessage(Request $request, $conversationId): JsonResponse
    {
        try {
            $request->validate([
                'content' => 'required|string|max:5000',
                'message_type' => 'nullable|in:text,image,video,audio,file'
            ]);

            $user = Auth::user();
            $conversation = Conversation::find($conversationId);

            if (!$conversation || !$conversation->hasParticipant($user->id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Conversation not found or access denied'
                ], 404);
            }

            $message = DirectMessage::create([
                'sender_id' => $user->id,
                'receiver_id' => $conversation->getOtherParticipant($user->id)->id,
                'message' => $request->content,
                'content' => $request->content,
                'message_type' => $request->message_type ?? 'text',
                'is_read' => false
            ]);

            // Update conversation last message time
            $conversation->updateLastMessageTime();

            $message->load(['sender']);

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully',
                'data' => [
                    'id' => $message->id,
                    'content' => $message->content,
                    'sender' => [
                        'id' => $message->sender->id,
                        'name' => $message->sender->name,
                        'profile_image' => $message->sender->profile_image_url
                    ],
                    'sent_at' => $message->created_at->format('Y-m-d H:i:s')
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send a group message
     */
    public function sendGroupMessage(Request $request, $groupId): JsonResponse
    {
        try {
            $request->validate([
                'content' => 'required|string|max:5000',
                'message_type' => 'nullable|in:text,image,video,audio,file'
            ]);

            $user = Auth::user();
            $group = Group::find($groupId);

            if (!$group || !$this->isGroupMember($group->id, $user->id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Group not found or access denied'
                ], 404);
            }

            $message = GroupMessage::create([
                'group_id' => $groupId,
                'sender_id' => $user->id,
                'content' => $request->content,
                'message_type' => $request->message_type ?? 'text'
            ]);

            // Update group last message time
            $group->update(['last_message_at' => now()]);

            $message->load(['sender']);

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully',
                'data' => [
                    'id' => $message->id,
                    'content' => $message->content,
                    'sender' => [
                        'id' => $message->sender->id,
                        'name' => $message->sender->name,
                        'profile_image' => $message->sender->profile_image_url
                    ],
                    'sent_at' => $message->created_at->format('Y-m-d H:i:s')
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send group message',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a new group
     */
    public function createGroup(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
                'privacy' => 'nullable|in:public,private',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'member_ids' => 'nullable|array',
                'member_ids.*' => 'exists:users,id'
            ]);

            $user = Auth::user();

            $group = Group::create([
                'name' => $request->name,
                'description' => $request->description,
                'privacy' => $request->privacy ?? 'private',
                'created_by' => $user->id
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('groups', 'public');
                $group->update(['image_path' => $path]);
            }

            // Add creator as admin
            GroupMember::create([
                'group_id' => $group->id,
                'user_id' => $user->id,
                'role' => 'admin',
                'status' => 'active'
            ]);

            // Add other members
            if ($request->member_ids) {
                foreach ($request->member_ids as $memberId) {
                    if ($memberId !== $user->id) {
                        GroupMember::create([
                            'group_id' => $group->id,
                            'user_id' => $memberId,
                            'role' => 'member',
                            'status' => 'active'
                        ]);
                    }
                }
            }

            $group->load(['members.user']);

            return response()->json([
                'success' => true,
                'message' => 'Group created successfully',
                'data' => [
                    'id' => $group->id,
                    'name' => $group->name,
                    'description' => $group->description,
                    'image' => $group->image_url,
                    'privacy' => $group->privacy,
                    'members_count' => $group->members->count(),
                    'created_at' => $group->created_at->format('Y-m-d H:i:s')
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create group',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get total unread count for user
     */
    private function getTotalUnreadCount($user): int
    {
        return $this->getTotalUnreadPersonalCount($user) + $this->getTotalUnreadGroupCount($user);
    }

    /**
     * Get total unread personal messages count
     */
    private function getTotalUnreadPersonalCount($user): int
    {
        return DirectMessage::where('receiver_id', $user->id)
            ->where('is_read', false)
            ->count();
    }

    /**
     * Get total unread group messages count
     */
    private function getTotalUnreadGroupCount($user): int
    {
        $groupIds = GroupMember::where('user_id', $user->id)
            ->where('status', 'active')
            ->pluck('group_id');

        return GroupMessage::whereIn('group_id', $groupIds)
            ->where('sender_id', '!=', $user->id)
            ->whereDoesntHave('readBy', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->count();
    }

    /**
     * Get unread count for specific group
     */
    private function getGroupUnreadCount($groupId, $userId): int
    {
        return GroupMessage::where('group_id', $groupId)
            ->where('sender_id', '!=', $userId)
            ->whereDoesntHave('readBy', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->count();
    }

    /**
     * Check if user is a group member
     */
    private function isGroupMember($groupId, $userId): bool
    {
        return GroupMember::where('group_id', $groupId)
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->exists();
    }

    /**
     * Mark group messages as read for user
     */
    private function markGroupMessagesAsRead($groupId, $userId): void
    {
        $unreadMessages = GroupMessage::where('group_id', $groupId)
            ->where('sender_id', '!=', $userId)
            ->whereDoesntHave('readBy', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->pluck('id');

        foreach ($unreadMessages as $messageId) {
            \App\Models\GroupMessageRead::firstOrCreate([
                'message_id' => $messageId,
                'user_id' => $userId,
                'read_at' => now()
            ]);
        }
    }
}