<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class FriendshipController extends Controller
{
    /**
     * Send friend request
     */
    public function sendFriendRequest(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $senderId = auth()->id();
        $receiverId = $request->user_id;

        // Can't send friend request to yourself
        if ($senderId === $receiverId) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot send friend request to yourself',
            ], 400);
        }

        // Check if friendship already exists
        $existingFriendship = Friendship::betweenUsers($senderId, $receiverId)->first();

        if ($existingFriendship) {
            if ($existingFriendship->status === 'accepted') {
                return response()->json([
                    'success' => false,
                    'message' => 'You are already friends',
                ], 400);
            }

            if ($existingFriendship->status === 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Friend request already sent',
                ], 400);
            }

            if ($existingFriendship->status === 'blocked') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot send friend request',
                ], 400);
            }
        }

        try {
            $friendship = Friendship::sendFriendRequest($senderId, $receiverId);

            return response()->json([
                'success' => true,
                'message' => 'Friend request sent successfully',
                'data' => $friendship,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send friend request',
            ], 500);
        }
    }

    /**
     * Accept friend request
     */
    public function acceptFriendRequest($friendshipId): JsonResponse
    {
        $friendship = Friendship::findOrFail($friendshipId);
        $userId = auth()->id();

        // Only the receiver can accept the request
        if ($friendship->friend_id !== $userId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to accept this friend request',
            ], 403);
        }

        if ($friendship->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Friend request is not pending',
            ], 400);
        }

        $friendship->accept();

        return response()->json([
            'success' => true,
            'message' => 'Friend request accepted',
            'data' => $friendship->fresh(),
        ]);
    }

    /**
     * Decline friend request
     */
    public function declineFriendRequest($friendshipId): JsonResponse
    {
        $friendship = Friendship::findOrFail($friendshipId);
        $userId = auth()->id();

        // Only the receiver can decline the request
        if ($friendship->friend_id !== $userId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to decline this friend request',
            ], 403);
        }

        if ($friendship->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Friend request is not pending',
            ], 400);
        }

        $friendship->decline();

        return response()->json([
            'success' => true,
            'message' => 'Friend request declined',
        ]);
    }

    /**
     * Remove friend
     */
    public function removeFriend($friendshipId): JsonResponse
    {
        $friendship = Friendship::findOrFail($friendshipId);
        $userId = auth()->id();

        // Only the participants can remove the friendship
        if ($friendship->user_id !== $userId && $friendship->friend_id !== $userId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to remove this friendship',
            ], 403);
        }

        $friendship->delete();

        return response()->json([
            'success' => true,
            'message' => 'Friend removed successfully',
        ]);
    }

    /**
     * Block user
     */
    public function blockUser($friendshipId): JsonResponse
    {
        $friendship = Friendship::findOrFail($friendshipId);
        $userId = auth()->id();

        // Only the participants can block
        if ($friendship->user_id !== $userId && $friendship->friend_id !== $userId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to block this user',
            ], 403);
        }

        $friendship->block();

        return response()->json([
            'success' => true,
            'message' => 'User blocked successfully',
        ]);
    }

    /**
     * Get user's friends list
     */
    public function getFriends(Request $request): JsonResponse
    {
        $request->validate([
            'per_page' => 'nullable|integer|min:1|max:50',
        ]);

        $userId = auth()->id();
        $perPage = $request->per_page ?? 20;

        $friends = Friendship::with(['user:id,name,avatar', 'friend:id,name,avatar'])
                            ->where(function ($query) use ($userId) {
                                $query->where('user_id', $userId)->orWhere('friend_id', $userId);
                            })
                            ->accepted()
                            ->latest('accepted_at')
                            ->paginate($perPage);

        // Transform to get the friend user data
        $friends->getCollection()->transform(function ($friendship) use ($userId) {
            $friend = $friendship->user_id === $userId ? $friendship->friend : $friendship->user;
            return [
                'friendship_id' => $friendship->id,
                'friend' => $friend,
                'accepted_at' => $friendship->accepted_at,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $friends,
        ]);
    }

    /**
     * Get pending friend requests (received)
     */
    public function getPendingRequests(Request $request): JsonResponse
    {
        $request->validate([
            'per_page' => 'nullable|integer|min:1|max:50',
        ]);

        $userId = auth()->id();
        $perPage = $request->per_page ?? 20;

        $requests = Friendship::with('user:id,name,avatar')
                            ->where('friend_id', $userId)
                            ->pending()
                            ->latest()
                            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $requests,
        ]);
    }

    /**
     * Get sent friend requests
     */
    public function getSentRequests(Request $request): JsonResponse
    {
        $request->validate([
            'per_page' => 'nullable|integer|min:1|max:50',
        ]);

        $userId = auth()->id();
        $perPage = $request->per_page ?? 20;

        $requests = Friendship::with('friend:id,name,avatar')
                            ->where('user_id', $userId)
                            ->pending()
                            ->latest()
                            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $requests,
        ]);
    }

    /**
     * Search users to add as friends
     */
    public function searchUsers(Request $request): JsonResponse
    {
        $request->validate([
            'query' => 'required|string|min:2',
            'per_page' => 'nullable|integer|min:1|max:50',
        ]);

        $searchQuery = $request->query;
        $userId = auth()->id();
        $perPage = $request->per_page ?? 20;

        // Get current friend IDs to exclude
        $friendIds = Friendship::where(function ($query) use ($userId) {
                                $query->where('user_id', $userId)->orWhere('friend_id', $userId);
                            })
                            ->where('status', '!=', 'declined')
                            ->get()
                            ->map(function ($friendship) use ($userId) {
                                return $friendship->user_id === $userId ? $friendship->friend_id : $friendship->user_id;
                            })
                            ->toArray();

        $users = User::where('id', '!=', $userId)
                    ->whereNotIn('id', $friendIds)
                    ->where(function ($query) use ($searchQuery) {
                        $query->where('name', 'like', "%{$searchQuery}%")
                              ->orWhere('email', 'like', "%{$searchQuery}%");
                    })
                    ->select('id', 'name', 'avatar', 'email')
                    ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $users,
        ]);
    }

    /**
     * Get friendship status with another user
     */
    public function getFriendshipStatus($userId): JsonResponse
    {
        $currentUserId = auth()->id();

        if ($currentUserId == $userId) {
            return response()->json([
                'success' => true,
                'data' => ['status' => 'self'],
            ]);
        }

        $friendship = Friendship::betweenUsers($currentUserId, $userId)->first();

        if (!$friendship) {
            return response()->json([
                'success' => true,
                'data' => ['status' => 'none'],
            ]);
        }

        $response = [
            'status' => $friendship->status,
            'friendship_id' => $friendship->id,
        ];

        if ($friendship->status === 'pending') {
            $response['is_sender'] = $friendship->user_id === $currentUserId;
        }

        return response()->json([
            'success' => true,
            'data' => $response,
        ]);
    }
} 