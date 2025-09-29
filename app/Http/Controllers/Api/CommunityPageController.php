<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CommunityPost;
use App\Models\User;
use App\Models\PostComment;
use App\Models\PostLike;
use App\Models\UserFollow;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommunityPageController extends Controller
{
    /**
     * Get all community posts with user details and interactions
     */
    public function getAllPosts(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 20);
            $currentUser = Auth::user();

            $posts = CommunityPost::with([
                'user.profile',
                'category',
                'media',
                'likes.user',
                'comments.user'
            ])
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

            $formattedPosts = $posts->getCollection()->map(function ($post) use ($currentUser) {
                return $this->formatPostData($post, $currentUser);
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'posts' => $formattedPosts,
                    'pagination' => [
                        'current_page' => $posts->currentPage(),
                        'last_page' => $posts->lastPage(),
                        'per_page' => $posts->perPage(),
                        'total' => $posts->total(),
                        'has_more_pages' => $posts->hasMorePages()
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch community posts',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get posts by specific user
     */
    public function getUserPosts(Request $request, $userId): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 20);
            $currentUser = Auth::user();

            $user = User::find($userId);
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            $posts = CommunityPost::with([
                'user.profile',
                'category',
                'media',
                'likes.user',
                'comments.user'
            ])
            ->where('user_id', $userId)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

            $formattedPosts = $posts->getCollection()->map(function ($post) use ($currentUser) {
                return $this->formatPostData($post, $currentUser);
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'username' => $user->username,
                        'profile_image' => $user->profile_image_url,
                        'is_following' => $currentUser ? $this->isFollowing($currentUser->id, $user->id) : false
                    ],
                    'posts' => $formattedPosts,
                    'pagination' => [
                        'current_page' => $posts->currentPage(),
                        'last_page' => $posts->lastPage(),
                        'per_page' => $posts->perPage(),
                        'total' => $posts->total(),
                        'has_more_pages' => $posts->hasMorePages()
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch user posts',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a new community post
     */
    public function createPost(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'content' => 'required|string|max:5000',
                'category_id' => 'nullable|exists:categories,id',
                'media.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:50000',
                'privacy' => 'nullable|in:public,friends,private'
            ]);

            $user = Auth::user();

            $post = CommunityPost::create([
                'user_id' => $user->id,
                'content' => $request->content,
                'category_id' => $request->category_id,
                'privacy' => $request->privacy ?? 'public',
                'is_active' => true
            ]);

            // Handle media uploads
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    $path = $file->store('community/posts', 'public');
                    $post->media()->create([
                        'file_path' => $path,
                        'file_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                        'original_name' => $file->getClientOriginalName()
                    ]);
                }
            }

            $post->load(['user.profile', 'category', 'media']);

            return response()->json([
                'success' => true,
                'message' => 'Post created successfully',
                'data' => $this->formatPostData($post, $user)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create post',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Like or unlike a post
     */
    public function toggleLike(Request $request, $postId): JsonResponse
    {
        try {
            $user = Auth::user();
            $post = CommunityPost::find($postId);

            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Post not found'
                ], 404);
            }

            $existingLike = PostLike::where('post_id', $postId)
                ->where('user_id', $user->id)
                ->first();

            if ($existingLike) {
                $existingLike->delete();
                $isLiked = false;
                $message = 'Post unliked successfully';
            } else {
                PostLike::create([
                    'post_id' => $postId,
                    'user_id' => $user->id
                ]);
                $isLiked = true;
                $message = 'Post liked successfully';
            }

            $likesCount = PostLike::where('post_id', $postId)->count();

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'is_liked' => $isLiked,
                    'likes_count' => $likesCount
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle like',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add comment to a post
     */
    public function addComment(Request $request, $postId): JsonResponse
    {
        try {
            $request->validate([
                'content' => 'required|string|max:1000',
                'parent_id' => 'nullable|exists:post_comments,id'
            ]);

            $user = Auth::user();
            $post = CommunityPost::find($postId);

            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Post not found'
                ], 404);
            }

            $comment = PostComment::create([
                'post_id' => $postId,
                'user_id' => $user->id,
                'content' => $request->content,
                'parent_id' => $request->parent_id
            ]);

            $comment->load(['user.profile', 'replies.user.profile']);

            return response()->json([
                'success' => true,
                'message' => 'Comment added successfully',
                'data' => $this->formatCommentData($comment, $user)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add comment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Follow or unfollow a user
     */
    public function toggleFollow(Request $request, $userId): JsonResponse
    {
        try {
            $currentUser = Auth::user();
            $targetUser = User::find($userId);

            if (!$targetUser) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            if ($currentUser->id === $targetUser->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot follow yourself'
                ], 400);
            }

            $existingFollow = UserFollow::where('follower_id', $currentUser->id)
                ->where('following_id', $userId)
                ->first();

            if ($existingFollow) {
                $existingFollow->delete();
                $isFollowing = false;
                $message = 'User unfollowed successfully';
            } else {
                UserFollow::create([
                    'follower_id' => $currentUser->id,
                    'following_id' => $userId
                ]);
                $isFollowing = true;
                $message = 'User followed successfully';
            }

            $followersCount = UserFollow::where('following_id', $userId)->count();
            $followingCount = UserFollow::where('follower_id', $userId)->count();

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'is_following' => $isFollowing,
                    'followers_count' => $followersCount,
                    'following_count' => $followingCount
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle follow',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Share a post
     */
    public function sharePost(Request $request, $postId): JsonResponse
    {
        try {
            $post = CommunityPost::find($postId);

            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Post not found'
                ], 404);
            }

            // Increment share count
            $post->increment('shares_count');

            return response()->json([
                'success' => true,
                'message' => 'Post shared successfully',
                'data' => [
                    'shares_count' => $post->shares_count,
                    'share_url' => url("/community/posts/{$post->id}")
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to share post',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Format post data for API response
     */
    private function formatPostData($post, $currentUser): array
    {
        return [
            'id' => $post->id,
            'content' => $post->content,
            'user' => [
                'id' => $post->user->id,
                'name' => $post->user->name,
                'username' => $post->user->username,
                'profile_image' => $post->user->profile_image_url,
                'is_following' => $currentUser ? $this->isFollowing($currentUser->id, $post->user->id) : false,
                'is_verified' => $post->user->is_verified ?? false
            ],
            'category' => $post->category ? [
                'id' => $post->category->id,
                'name' => $post->category->name,
                'color' => $post->category->color
            ] : null,
            'media' => $post->media->map(function ($media) {
                return [
                    'id' => $media->id,
                    'url' => Storage::url($media->file_path),
                    'type' => $media->file_type,
                    'thumbnail' => $media->thumbnail_url
                ];
            }),
            'likes_count' => $post->likes->count(),
            'comments_count' => $post->comments->count(),
            'shares_count' => $post->shares_count ?? 0,
            'is_liked' => $currentUser ? $post->likes->contains('user_id', $currentUser->id) : false,
            'created_at' => $post->created_at->format('Y-m-d H:i:s'),
            'time_ago' => $post->created_at->diffForHumans(),
            'privacy' => $post->privacy
        ];
    }

    /**
     * Format comment data for API response
     */
    private function formatCommentData($comment, $currentUser): array
    {
        return [
            'id' => $comment->id,
            'content' => $comment->content,
            'user' => [
                'id' => $comment->user->id,
                'name' => $comment->user->name,
                'username' => $comment->user->username,
                'profile_image' => $comment->user->profile_image_url
            ],
            'replies' => $comment->replies->map(function ($reply) use ($currentUser) {
                return $this->formatCommentData($reply, $currentUser);
            }),
            'created_at' => $comment->created_at->format('Y-m-d H:i:s'),
            'time_ago' => $comment->created_at->diffForHumans()
        ];
    }

    /**
     * Check if current user is following target user
     */
    private function isFollowing($currentUserId, $targetUserId): bool
    {
        return UserFollow::where('follower_id', $currentUserId)
            ->where('following_id', $targetUserId)
            ->exists();
    }
}