<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CommunityPost;
use App\Models\CommunityCategory;
use App\Models\PostLike;
use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CommunityController extends Controller
{
    /**
     * Get community feed posts
     */
    public function getPosts(Request $request): JsonResponse
    {
        $request->validate([
            'category_id' => 'nullable|exists:community_categories,id',
            'group_id' => 'nullable|exists:community_groups,id',
            'type' => 'nullable|in:all,achievements,challenges,discussions',
            'per_page' => 'nullable|integer|min:1|max:50',
        ]);

        $userId = auth()->id();
        $perPage = $request->per_page ?? 15;

        $query = CommunityPost::with([
            'user:id,name,avatar',
            'category:id,name,color,icon',
            'group:id,name,slug',
            'comments.user:id,name,avatar',
            'comments.replies.user:id,name,avatar'
        ])->active()->forUser($userId);

        // Filter by category
        if ($request->category_id) {
            $query->byCategory($request->category_id);
        }

        // Filter by group
        if ($request->group_id) {
            $query->byGroup($request->group_id);
        }

        // Filter by type
        switch ($request->type) {
            case 'achievements':
                $query->achievements();
                break;
            case 'challenges':
                $query->challenges();
                break;
            case 'discussions':
                $query->where('is_achievement', false)->where('is_challenge', false);
                break;
        }

        $posts = $query->latest()->paginate($perPage);

        // Add user interaction data
        $posts->getCollection()->transform(function ($post) use ($userId) {
            $post->is_liked_by_user = $post->isLikedBy($userId);
            $post->user_can_edit = $post->user_id === $userId;
            return $post;
        });

        return response()->json([
            'success' => true,
            'data' => $posts,
        ]);
    }

    /**
     * Create a new post
     */
    public function createPost(Request $request): JsonResponse
    {
        $request->validate([
            'content' => 'required|string|max:2000',
            'category_id' => 'required|exists:community_categories,id',
            'group_id' => 'nullable|exists:community_groups,id',
            'images.*' => 'nullable|image|max:5120', // 5MB max per image
            'is_achievement' => 'boolean',
            'is_challenge' => 'boolean',
            'visibility' => 'in:public,friends,group',
        ]);

        $userId = auth()->id();
        $images = [];

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('community/posts', 'public');
                $images[] = $path;
            }
        }

        // Determine visibility
        $visibility = $request->visibility ?? 'public';
        if ($request->group_id) {
            $visibility = 'group';
        }

        DB::beginTransaction();
        try {
            $post = CommunityPost::create([
                'user_id' => $userId,
                'community_category_id' => $request->category_id,
                'community_group_id' => $request->group_id,
                'content' => $request->content,
                'images' => $images,
                'is_achievement' => $request->boolean('is_achievement'),
                'is_challenge' => $request->boolean('is_challenge'),
                'visibility' => $visibility,
            ]);

            // Load relationships
            $post->load(['user:id,name,avatar', 'category:id,name,color,icon', 'group:id,name,slug']);

            // Check for badge achievements
            $this->checkPostBadges($userId);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Post created successfully',
                'data' => $post,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Clean up uploaded images if post creation failed
            foreach ($images as $image) {
                Storage::disk('public')->delete($image);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to create post',
            ], 500);
        }
    }

    /**
     * Like/Unlike a post
     */
    public function toggleLike(Request $request, $postId): JsonResponse
    {
        $post = CommunityPost::findOrFail($postId);
        $userId = auth()->id();

        $existingLike = PostLike::where('user_id', $userId)
                                ->where('post_id', $postId)
                                ->where('post_type', 'App\\Models\\CommunityPost')
                                ->first();

        if ($existingLike) {
            // Unlike the post
            $existingLike->delete();
            $post->decrementLikes();
            $liked = false;
        } else {
            // Like the post
            PostLike::create([
                'user_id' => $userId,
                'post_id' => $postId,
                'post_type' => 'App\\Models\\CommunityPost',
            ]);
            $post->incrementLikes();
            $liked = true;
        }

        return response()->json([
            'success' => true,
            'data' => [
                'liked' => $liked,
                'likes_count' => $post->fresh()->likes_count,
            ],
        ]);
    }

    /**
     * Add comment to post
     */
    public function addComment(Request $request, $postId): JsonResponse
    {
        $request->validate([
            'content' => 'required|string|max:500',
            'parent_id' => 'nullable|exists:post_comments,id',
        ]);

        $post = CommunityPost::findOrFail($postId);
        $userId = auth()->id();

        DB::beginTransaction();
        try {
            $comment = PostComment::create([
                'user_id' => $userId,
                'post_type' => 'App\\Models\\CommunityPost',
                'post_id' => $postId,
                'parent_id' => $request->parent_id,
                'content' => $request->content,
            ]);

            // Increment comments count only for parent comments
            if (!$request->parent_id) {
                $post->incrementComments();
            }

            $comment->load(['user:id,name,avatar', 'replies.user:id,name,avatar']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Comment added successfully',
                'data' => $comment,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to add comment',
            ], 500);
        }
    }

    /**
     * Get community categories
     */
    public function getCategories(): JsonResponse
    {
        $categories = CommunityCategory::active()->orderBySort()->get();

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }

    /**
     * Share a post
     */
    public function sharePost($postId): JsonResponse
    {
        $post = CommunityPost::findOrFail($postId);
        $post->incrementShares();

        return response()->json([
            'success' => true,
            'message' => 'Post shared successfully',
            'data' => [
                'shares_count' => $post->fresh()->shares_count,
            ],
        ]);
    }

    /**
     * Delete a post (user can only delete their own posts)
     */
    public function deletePost($postId): JsonResponse
    {
        $post = CommunityPost::findOrFail($postId);
        $userId = auth()->id();

        if ($post->user_id !== $userId && !auth()->user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to delete this post',
            ], 403);
        }

        // Delete associated images
        if ($post->images) {
            foreach ($post->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully',
        ]);
    }

    /**
     * Check and award badges for post-related achievements
     */
    private function checkPostBadges($userId): void
    {
        $badges = \App\Models\Badge::active()->get();
        
        foreach ($badges as $badge) {
            $badge->checkAndAwardToUser($userId);
        }
    }
}