<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FitFlixVideo;
use App\Models\PostLike;
use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MobileFitFlixController extends Controller
{
    /**
     * Get FitFlix videos with mobile-specific format
     * As per tc1.md: Title, User details, Liked count, Comment count, Share count with link, Video link, Like/Comment actions
     */
    public function getFitFlixVideos(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'category_id' => 'nullable|exists:categories,id',
                'limit' => 'nullable|integer|min:1|max:50'
            ]);

            $user = Auth::user();
            $limit = $request->get('limit', 20);
            $categoryId = $request->get('category_id');

            $query = FitFlixVideo::with([
                'uploader.badges',
                'category',
                'likes.user',
                'comments.user'
            ])
            ->where('is_active', true)
            ->where('is_published', true);

            if ($categoryId) {
                $query->where('category_id', $categoryId);
            }

            $videos = $query->orderBy('sequence_order', 'asc')
                          ->orderBy('created_at', 'desc')
                          ->limit($limit)
                          ->get();

            $formattedVideos = $videos->map(function ($video) use ($user) {
                return [
                    'id' => $video->id,
                    'title' => $video->title,
                    'user_details' => [
                        'id' => $video->uploader ? $video->uploader->id : null,
                        'name' => $video->uploader ? $video->uploader->name : 'Admin',
                        'profile_picture' => $video->uploader ? $video->uploader->profile_picture : null,
                        'badge' => $video->uploader ? $this->getUserTopBadge($video->uploader) : null,
                        'is_verified' => $video->uploader ? $video->uploader->hasRole('verified') : false
                    ],
                    'liked_count' => $video->likes_count ?? 0,
                    'comment_count' => $video->comments()->whereNull('parent_id')->count(),
                    'share_count' => $video->shares_count ?? 0,
                    'share_count_with_link' => [
                        'count' => $video->shares_count ?? 0,
                        'share_link' => $this->generateShareLink($video)
                    ],
                    'video_link' => $video->video_url,
                    'thumbnail' => $video->thumbnail_url,
                    'description' => $video->description,
                    'duration' => $video->duration,
                    'views_count' => $video->views_count ?? 0,
                    'category' => $video->category ? [
                        'id' => $video->category->id,
                        'name' => $video->category->name,
                        'slug' => $video->category->slug
                    ] : null,
                    'is_liked_by_user' => $user ? $this->isVideoLikedByUser($video, $user) : false,
                    'like_action' => [
                        'endpoint' => "/api/v1/fitflix/videos/{$video->id}/like",
                        'method' => 'POST'
                    ],
                    'comment_action' => [
                        'endpoint' => "/api/v1/fitflix/videos/{$video->id}/comment",
                        'method' => 'POST'
                    ],
                    'share_action' => [
                        'endpoint' => "/api/v1/fitflix/videos/{$video->id}/share",
                        'method' => 'POST'
                    ],
                    'tags' => $video->tags ? explode(',', $video->tags) : [],
                    'sequence_order' => $video->sequence_order,
                    'created_at' => $video->created_at->format('Y-m-d H:i:s'),
                    'uploaded_at' => $video->created_at->diffForHumans()
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'FitFlix videos retrieved successfully',
                'data' => $formattedVideos,
                'total' => $formattedVideos->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch FitFlix videos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific FitFlix video with enhanced details
     */
    public function getFitFlixVideo($videoId): JsonResponse
    {
        try {
            $user = Auth::user();

            $video = FitFlixVideo::with([
                'uploader.badges',
                'category',
                'likes.user',
                'comments.user'
            ])
            ->where('id', $videoId)
            ->where('is_active', true)
            ->where('is_published', true)
            ->first();

            if (!$video) {
                return response()->json([
                    'success' => false,
                    'message' => 'Video not found'
                ], 404);
            }

            // Increment view count
            if ($user) {
                $video->increment('views_count');
            }

            $videoData = [
                'id' => $video->id,
                'title' => $video->title,
                'user_details' => [
                    'id' => $video->uploader ? $video->uploader->id : null,
                    'name' => $video->uploader ? $video->uploader->name : 'Admin',
                    'profile_picture' => $video->uploader ? $video->uploader->profile_picture : null,
                    'badge' => $video->uploader ? $this->getUserTopBadge($video->uploader) : null,
                    'is_verified' => $video->uploader ? $video->uploader->hasRole('verified') : false,
                    'followers_count' => $video->uploader ? $video->uploader->followers()->count() : 0
                ],
                'liked_count' => $video->likes_count ?? 0,
                'comment_count' => $video->comments()->whereNull('parent_id')->count(),
                'share_count' => $video->shares_count ?? 0,
                'share_count_with_link' => [
                    'count' => $video->shares_count ?? 0,
                    'share_link' => $this->generateShareLink($video)
                ],
                'video_link' => $video->video_url,
                'thumbnail' => $video->thumbnail_url,
                'description' => $video->description,
                'duration' => $video->duration,
                'views_count' => $video->views_count ?? 0,
                'category' => $video->category ? [
                    'id' => $video->category->id,
                    'name' => $video->category->name,
                    'slug' => $video->category->slug
                ] : null,
                'is_liked_by_user' => $user ? $this->isVideoLikedByUser($video, $user) : false,
                'like_action' => [
                    'endpoint' => "/api/v1/fitflix/videos/{$video->id}/like",
                    'method' => 'POST'
                ],
                'comment_action' => [
                    'endpoint' => "/api/v1/fitflix/videos/{$video->id}/comment",
                    'method' => 'POST'
                ],
                'share_action' => [
                    'endpoint' => "/api/v1/fitflix/videos/{$video->id}/share",
                    'method' => 'POST'
                ],
                'tags' => $video->tags ? explode(',', $video->tags) : [],
                'sequence_order' => $video->sequence_order,
                'created_at' => $video->created_at->format('Y-m-d H:i:s'),
                'uploaded_at' => $video->created_at->diffForHumans(),
                'related_videos' => $this->getRelatedVideos($video, 5)
            ];

            return response()->json([
                'success' => true,
                'message' => 'Video retrieved successfully',
                'data' => $videoData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch video',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Share a FitFlix video
     */
    public function shareVideo($videoId): JsonResponse
    {
        try {
            $video = FitFlixVideo::findOrFail($videoId);
            
            // Increment share count
            $video->increment('shares_count');

            return response()->json([
                'success' => true,
                'message' => 'Video shared successfully',
                'data' => [
                    'video_id' => $videoId,
                    'share_link' => $this->generateShareLink($video),
                    'shares_count' => $video->fresh()->shares_count
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to share video',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Like/Unlike a FitFlix video
     */
    public function toggleLike($videoId): JsonResponse
    {
        try {
            $user = Auth::user();
            $video = FitFlixVideo::findOrFail($videoId);

            $existingLike = PostLike::where('post_type', 'fit_flix_video')
                ->where('post_id', $videoId)
                ->where('user_id', $user->id)
                ->first();

            if ($existingLike) {
                // Remove like
                $existingLike->delete();
                $video->decrement('likes_count');
                $isLiked = false;
                $message = 'Like removed';
            } else {
                // Add like
                PostLike::create([
                    'post_type' => 'fit_flix_video',
                    'post_id' => $videoId,
                    'user_id' => $user->id
                ]);
                $video->increment('likes_count');
                $isLiked = true;
                $message = 'Video liked';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'video_id' => $videoId,
                    'is_liked' => $isLiked,
                    'likes_count' => $video->fresh()->likes_count
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
     * Add comment to a FitFlix video
     */
    public function addComment(Request $request, $videoId): JsonResponse
    {
        try {
            $request->validate([
                'comment' => 'required|string|max:1000',
                'parent_id' => 'nullable|exists:post_comments,id'
            ]);

            $user = Auth::user();
            $video = FitFlixVideo::findOrFail($videoId);

            $comment = PostComment::create([
                'user_id' => $user->id,
                'post_type' => 'fit_flix_video',
                'post_id' => $videoId,
                'content' => $request->comment,
                'parent_id' => $request->parent_id
            ]);

            $comment->load(['user.badges']);

            return response()->json([
                'success' => true,
                'message' => 'Comment added successfully',
                'data' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'user_details' => [
                        'id' => $comment->user->id,
                        'name' => $comment->user->name,
                        'profile_picture' => $comment->user->profile_picture,
                        'badge' => $this->getUserTopBadge($comment->user)
                    ],
                    'created_at' => $comment->created_at->format('Y-m-d H:i:s'),
                    'time_ago' => $comment->created_at->diffForHumans(),
                    'likes_count' => $comment->likes_count ?? 0,
                    'replies_count' => 0
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

    // Helper methods
    
    private function getUserTopBadge($user): ?array
    {
        if (!$user) return null;
        
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

    private function isVideoLikedByUser($video, $user): bool
    {
        return PostLike::where('post_type', 'fit_flix_video')
            ->where('post_id', $video->id)
            ->where('user_id', $user->id)
            ->exists();
    }

    private function generateShareLink($video): string
    {
        return url("/fitflix/videos/{$video->id}");
    }

    private function getRelatedVideos($video, $limit = 5): array
    {
        $relatedVideos = FitFlixVideo::where('id', '!=', $video->id)
            ->where('is_active', true)
            ->where('is_published', true)
            ->where('category_id', $video->category_id)
            ->orderBy('views_count', 'desc')
            ->limit($limit)
            ->get();

        return $relatedVideos->map(function ($relatedVideo) {
            return [
                'id' => $relatedVideo->id,
                'title' => $relatedVideo->title,
                'thumbnail' => $relatedVideo->thumbnail_url,
                'duration' => $relatedVideo->duration,
                'views_count' => $relatedVideo->views_count ?? 0,
                'uploader_name' => $relatedVideo->uploader ? $relatedVideo->uploader->name : 'Admin'
            ];
        })->toArray();
    }
}
