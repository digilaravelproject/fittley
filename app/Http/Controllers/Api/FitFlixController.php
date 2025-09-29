<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FitFlixVideo;
use App\Models\PostLike;
use App\Models\PostComment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FitFlixController extends Controller
{
    /**
     * Get all FitFlix videos in sequence
     */
    public function getAllVideos(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $perPage = $request->get('per_page', 20);
            $category = $request->get('category');
            $search = $request->get('search');

            $query = FitFlixVideo::with([
                'uploader',
                'category',
                'likes.user',
                'comments.user',
            ])
            ->where('is_active', true)
            ->where('is_published', true);

            // Filter by category if provided
            if ($category) {
                $query->whereHas('category', function ($q) use ($category) {
                    $q->where('slug', $category)->orWhere('id', $category);
                });
            }

            // Search functionality
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('description', 'LIKE', "%{$search}%")
                      ->orWhere('tags', 'LIKE', "%{$search}%");
                });
            }

            // Order by upload sequence (admin defined order)
            $videos = $query->orderBy('sequence_order', 'asc')
                          ->orderBy('created_at', 'desc')
                          ->paginate($perPage);

            $formattedVideos = $videos->getCollection()->map(function ($video) use ($user) {
                return $this->formatVideoData($video, $user);
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'videos' => $formattedVideos,
                    'pagination' => [
                        'current_page' => $videos->currentPage(),
                        'last_page' => $videos->lastPage(),
                        'per_page' => $videos->perPage(),
                        'total' => $videos->total(),
                        'has_more_pages' => $videos->hasMorePages()
                    ]
                ]
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
     * Get specific video by ID
     */
    public function getVideo($videoId): JsonResponse
    {
        try {
            $user = Auth::user();

            $video = FitFlixVideo::with([
                'uploader',
                'category',
                'likes.user',
                'comments.user.profile'
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

            // Record video view
            if ($user) {
                $this->recordVideoView($video->id, $user->id);
            }

            // Get related videos
            $relatedVideos = $this->getRelatedVideos($video, 5);

            return response()->json([
                'success' => true,
                'data' => [
                    'video' => $this->formatVideoData($video, $user, true),
                    'related_videos' => $relatedVideos
                ]
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
     * Get next video in sequence
     */
    public function getNextVideo($currentVideoId): JsonResponse
    {
        try {
            $currentVideo = FitFlixVideo::find($currentVideoId);
            
            if (!$currentVideo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current video not found'
                ], 404);
            }

            $nextVideo = FitFlixVideo::where('sequence_order', '>', $currentVideo->sequence_order)
                ->where('is_active', true)
                ->where('is_published', true)
                ->orderBy('sequence_order', 'asc')
                ->first();

            // If no next video in sequence, get the first video
            if (!$nextVideo) {
                $nextVideo = FitFlixVideo::where('is_active', true)
                    ->where('is_published', true)
                    ->orderBy('sequence_order', 'asc')
                    ->first();
            }

            if (!$nextVideo) {
                return response()->json([
                    'success' => false,
                    'message' => 'No next video available'
                ], 404);
            }

            $user = Auth::user();
            return response()->json([
                'success' => true,
                'data' => [
                    'video' => $this->formatVideoData($nextVideo, $user)
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch next video',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Like or unlike a video
     */
    public function toggleLike(Request $request, $videoId): JsonResponse
    {
        try {
            $user = Auth::user();
            $video = FitFlixVideo::find($videoId);

            if (!$video) {
                return response()->json([
                    'success' => false,
                    'message' => 'Video not found'
                ], 404);
            }

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
                // Add new like
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
     * Add comment to a video
     */
    public function addComment(Request $request, $videoId): JsonResponse
    {
        try {
            $request->validate([
                'content' => 'required|string|max:1000',
                'parent_id' => 'nullable|exists:post_comments,id'
            ]);

            $user = Auth::user();
            $video = FitFlixVideo::find($videoId);

            if (!$video) {
                return response()->json([
                    'success' => false,
                    'message' => 'Video not found'
                ], 404);
            }

            $comment = PostComment::create([
                'user_id' => $user->id,
                'post_type' => 'fit_flix_video',
                'post_id' => $videoId,
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
     * Get comments for a video
     */
    public function getComments(Request $request, $videoId): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 20);
            $sortBy = $request->get('sort_by', 'newest'); // newest, oldest, popular

            $video = FitFlixVideo::find($videoId);
            if (!$video) {
                return response()->json([
                    'success' => false,
                    'message' => 'Video not found'
                ], 404);
            }

            $query = PostComment::with(['user.profile', 'replies.user.profile'])
                ->where('post_type', 'fit_flix_video')
                ->where('post_id', $videoId)
                ->whereNull('parent_id'); // Only top-level comments

            switch ($sortBy) {
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'popular':
                    $query->orderBy('likes_count', 'desc')
                          ->orderBy('created_at', 'desc');
                    break;
                default: // newest
                    $query->orderBy('created_at', 'desc');
                    break;
            }

            $comments = $query->paginate($perPage);
            $user = Auth::user();

            $formattedComments = $comments->getCollection()->map(function ($comment) use ($user) {
                return $this->formatCommentData($comment, $user);
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'comments' => $formattedComments,
                    'pagination' => [
                        'current_page' => $comments->currentPage(),
                        'last_page' => $comments->lastPage(),
                        'per_page' => $comments->perPage(),
                        'total' => $comments->total(),
                        'has_more_pages' => $comments->hasMorePages()
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch comments',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get video categories
     */
    public function getCategories(): JsonResponse
    {
        try {
            $categories = \App\Models\Category::where('type', 'fitflix')
                ->where('is_active', true)
                ->withCount(['fitFlixVideos' => function ($query) {
                    $query->where('is_active', true)->where('is_published', true);
                }])
                ->orderBy('name', 'asc')
                ->get()
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'slug' => $category->slug,
                        'description' => $category->description,
                        'image' => $category->image_url,
                        'videos_count' => $category->fit_flix_videos_count
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => [
                    'categories' => $categories
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Record video view
     */
    private function recordVideoView($videoId, $userId): void
    {
        // For now, simply increment the views_count on first call per request.
        // If unique-per-user tracking is needed later, introduce a polymorphic PostView model.
        FitFlixVideo::where('id', $videoId)->increment('views_count');
    }

    /**
     * Get related videos
     */
    private function getRelatedVideos($video, $limit = 5): array
    {
        $relatedVideos = FitFlixVideo::where('id', '!=', $video->id)
            ->where('is_active', true)
            ->where('is_published', true)
            ->where(function ($query) use ($video) {
                $query->where('category_id', $video->category_id)
                      ->orWhere('tags', 'LIKE', '%' . $video->tags . '%');
            })
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
                'uploader' => $relatedVideo->uploader ? $relatedVideo->uploader->name : 'Admin'
            ];
        })->toArray();
    }

    /**
     * Get video like/dislike counts
     */


    /**
     * Format video data for API response
     */
    private function formatVideoData($video, $user, $includeComments = false): array
    {
        $userLike = null;
        if ($user) {
            $userLike = PostLike::where('post_type', 'fit_flix_video')
                ->where('post_id', $video->id)
                ->where('user_id', $user->id)
                ->exists();
        }

        $data = [
            'id' => $video->id,
            'title' => $video->title,
            'description' => $video->description,
            'thumbnail' => $video->thumbnail_url,
            'video_url' => $video->video_url,
            'shares_count' => $video->shares_count,
            'duration' => $video->duration,
            'sequence_order' => $video->sequence_order,
            'uploader' => [
                'id' => $video->uploader ? $video->uploader->id : null,
                'name' => $video->uploader ? $video->uploader->name : 'Admin',
                'profile_image' => $video->uploader ? $video->uploader->profile_image_url : null
            ],
            'category' => $video->category ? [
                'id' => $video->category->id,
                'name' => $video->category->name,
                'slug' => $video->category->slug
            ] : null,
            'views_count' => $video->views_count ?? 0,
            'likes_count' => $video->likes_count,
            'comments_count' => $video->comments->count(),
            'is_liked' => (bool) $userLike,
            'tags' => $video->tags ? explode(',', $video->tags) : [],
            'created_at' => $video->created_at->format('Y-m-d H:i:s'),
            'uploaded_at' => $video->created_at->format('M d, Y')
        ];

        if ($includeComments) {
            $data['recent_comments'] = $video->comments
                ->where('parent_id', null)
                // ->take(3)
                ->map(function ($comment) use ($user) {
                    return $this->formatCommentData($comment, $user);
                });
        }

        return $data;
    }

    /**
     * Format comment data for API response
     */
    private function formatCommentData($comment, $user): array
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
            'replies_count' => $comment->replies->count(),
            'replies' => $comment->replies->map(function ($reply) use ($user) {
                return $this->formatCommentData($reply, $user);
            }),
            'likes_count' => $comment->likes_count ?? 0,
            'created_at' => $comment->created_at->format('Y-m-d H:i:s'),
            'time_ago' => $comment->created_at->diffForHumans()
        ];
    }
}