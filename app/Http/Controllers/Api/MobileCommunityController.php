<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CommunityPost;
use App\Models\CommunityCategory;
use App\Models\PostComment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MobileCommunityController extends Controller
{
    /**
     * Get community posts with enhanced mobile structure
     * As per tc1.md: Posts Parameters - User name, Badge, Post time, Follow status, 
     * Title, Description, Liked Status, Comment Status, Share post link, Post User details
     */
    public function getCommunityPosts(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            
            $request->validate([
                'category_id' => 'nullable|exists:community_categories,id',
                'limit' => 'nullable|integer|min:1|max:50'
            ]);

            $limit = $request->get('limit', 20);
            $categoryId = $request->get('category_id');

            $query = CommunityPost::with([
                'user.badges',
                // 'user.followers', 
                'category',
                'comments.user',
                'likes.user'
            ])
            ->active()
            ->public()
            ->latest();

            if ($categoryId) {
                $query->where('community_category_id', $categoryId);
            }

            $posts = $query->limit($limit)->get();

            $formattedPosts = $posts->map(function ($post) use ($user) {
                return [
                    'id' => $post->id,
                    'user_name' => $post->user->name,
                    'avatar' => $post->user->avatar,
                    'badge' => $this->getUserTopBadge($post->user),
                    'post_time' => $post->created_at->format('Y-m-d H:i:s'),
                    'post_time_human' => $post->created_at->diffForHumans(),
                    'follow_status' => $this->getFollowStatus($user, $post->user),
                    'title' => $this->extractTitle($post->content), // Extract title from content
                    'description' => $post->content,
                    'liked_status' => $post->isLikedBy($user->id ?? null),
                    'comment_status' => $post->comments_count > 0,
                    'share_post_link' => $this->generateShareLink($post),
                    'timestamp' =>  $post->user->created_at,
                    'post_user_details' => [
                        'id' => $post->user->id,
                        'name' => $post->user->name,
                        'profile_picture' => $post->user->profile_picture,
                        'badge' => $this->getUserTopBadge($post->user),
                        'is_verified' => $post->user->hasRole('verified')
                        // 'followers_count' => $post->user->followers()->count()
                    ],
                    'likes_count' => $post->likes_count,
                    'comments_count' => $post->comments_count,
                    'shares_count' => $post->shares_count,
                    'images' => $post->images ?? [],
                    'category' => $post->category ? [
                        'id' => $post->category->id,
                        'name' => $post->category->name,
                        'color' => $post->category->color ?? '#000000'
                    ] : null,
                    'is_achievement' => $post->is_achievement,
                    'is_challenge' => $post->is_challenge,
                    'can_edit' => $user && $post->user_id === $user->id,
                    'can_delete' => $user && ($post->user_id === $user->id || $user->hasRole('admin'))
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Community posts retrieved successfully',
                'data' => $formattedPosts,
                'total' => $formattedPosts->count()
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
     * Get post comments with enhanced mobile structure
     * As per tc1.md: Post Comments Parameters - Comment title, Username, Timestamp, Delete comment, Post Comments
     */
    public function getPostComments(Request $request, $postId): JsonResponse
    {
        try {
            $user = Auth::user();
            
            $post = CommunityPost::findOrFail($postId);
            
            $comments = PostComment::with(['user.badges', 'replies.user.badges'])
                ->where('post_type', 'App\\Models\\CommunityPost')
                ->where('post_id', $postId)
                ->whereNull('parent_id') // Only parent comments
                ->active()
                ->latest()
                ->get();

            $formattedComments = $comments->map(function ($comment) use ($user) {
                return [
                    'id' => $comment->id,
                    'comment_title' => $this->extractTitle($comment->content),
                    'content' => $comment->content,
                    'username' => $comment->user->name,
                    'user_details' => [
                        'id' => $comment->user->id,
                        'name' => $comment->user->name,
                        'profile_picture' => $comment->user->profile_picture,
                        'badge' => $this->getUserTopBadge($comment->user)
                    ],
                    'timestamp' => $comment->created_at->format('Y-m-d H:i:s'),
                    'timestamp_human' => $comment->created_at->diffForHumans(),
                    'can_delete' => $user && ($comment->user_id === $user->id || $user->hasRole('admin')),
                    'likes_count' => $comment->likes_count,
                    'replies_count' => $comment->replies()->count(),
                    'replies' => $comment->replies->map(function ($reply) use ($user) {
                        return [
                            'id' => $reply->id,
                            'content' => $reply->content,
                            'username' => $reply->user->name,
                            'user_details' => [
                                'id' => $reply->user->id,
                                'name' => $reply->user->name,
                                'profile_picture' => $reply->user->profile_picture,
                                'badge' => $this->getUserTopBadge($reply->user)
                            ],
                            'timestamp' => $reply->created_at->format('Y-m-d H:i:s'),
                            'timestamp_human' => $reply->created_at->diffForHumans(),
                            'can_delete' => $user && ($reply->user_id === $user->id || $user->hasRole('admin')),
                            'likes_count' => $reply->likes_count
                        ];
                    })
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Post comments retrieved successfully',
                'data' => [
                    'post_id' => $postId,
                    'comments' => $formattedComments,
                    'total_comments' => $post->comments_count
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch post comments',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add comment to post
     */
    public function addPostComment(Request $request, $postId): JsonResponse
    {
        try {
            $user = Auth::user();
            
            $request->validate([
                'content' => 'required|string|max:500',
                'parent_id' => 'nullable|exists:post_comments,id'
            ]);

            $post = CommunityPost::findOrFail($postId);

            $comment = PostComment::create([
                'user_id' => $user->id,
                'post_type' => 'App\\Models\\CommunityPost',
                'post_id' => $postId,
                'parent_id' => $request->parent_id,
                'content' => $request->content,
            ]);

            // Increment comments count only for parent comments
            if (!$request->parent_id) {
                $post->incrementComments();
            }

            $comment->load(['user.badges']);

            return response()->json([
                'success' => true,
                'message' => 'Comment added successfully',
                'data' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'username' => $comment->user->name,
                    'user_details' => [
                        'id' => $comment->user->id,
                        'name' => $comment->user->name,
                        'profile_picture' => $comment->user->profile_picture,
                        'badge' => $this->getUserTopBadge($comment->user)
                    ],
                    'timestamp' => $comment->created_at->format('Y-m-d H:i:s'),
                    'timestamp_human' => $comment->created_at->diffForHumans(),
                    'can_delete' => true,
                    'likes_count' => $comment->likes_count
                ]
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
     * Delete a comment
     */
    public function deleteComment($commentId): JsonResponse
    {
        try {
            $user = Auth::user();
            $comment = PostComment::findOrFail($commentId);

            if ($comment->user_id !== $user->id && !$user->hasRole('admin')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to delete this comment'
                ], 403);
            }

            // Get the post to decrement comment count
            $post = CommunityPost::find($comment->post_id);
            
            // If it's a parent comment, decrement the post's comment count
            if (!$comment->parent_id && $post) {
                $post->decrementComments();
            }

            $comment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Comment deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete comment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Helper methods
    
    private function getUserTopBadge(User $user): ?array
    {
        $topBadge = $user->badges()
            ->wherePivot('is_visible', true)
            ->orderByPivot('earned_at', 'desc')
            ->first();

        if (!$topBadge) {
            return null;
        }

        return [
            'id' => $topBadge->id,
            'name' => $topBadge->name,
            'icon' => $topBadge->icon,
            'color' => $topBadge->color ?? '#FFD700'
        ];
    }

    private function getFollowStatus($currentUser, $targetUser): string
    {
        if (!$currentUser || $currentUser->id === $targetUser->id) {
            return 'self';
        }

        // Check if current user follows the target user using the existing friends relationship
        $isFollowing = $currentUser->friends()->where('users.id', $targetUser->id)->exists() ||
                      $currentUser->friendsOfMine()->where('users.id', $targetUser->id)->exists();
        
        return $isFollowing ? 'following' : 'not_following';
    }

    private function extractTitle($content): string
    {
        // Extract first line or first 50 characters as title
        $firstLine = explode("\n", $content)[0];
        return strlen($firstLine) > 50 ? substr($firstLine, 0, 47) . '...' : $firstLine;
    }

    private function generateShareLink($post): string
    {
        return url("/community/posts/{$post->id}");
    }
}
