<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FitSeries;
use App\Models\FitLiveSession;
use App\Models\Category;
use App\Models\FitCast;
use App\Models\FitNews;
use App\Models\FitInsight;
use App\Models\User;
use App\Models\PostLike;
use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\AgoraService;
use Illuminate\Support\Facades\DB;

class HomepageController extends Controller
{
    protected $agoraService;

    public function __construct(AgoraService $agoraService)
    {
        $this->agoraService = $agoraService;
    }
    /**
     * Get all homepage content for mobile application
     */
    public function getHomepageContent(): JsonResponse
    {
        try {
            $data = [
                'fitseries' => $this->getFitSeries(),
                'fitlive' => $this->getFitLive(),
                'fitguide' => $this->getFitGuide(),
                'fitcasts' => $this->getFitCasts(),
                'fitnews' => $this->getFitNews(),
                'fitinsights' => $this->getFitInsights()
            ];

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch homepage content',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all fit series/videos
     */
    public function getFitSeries(): array
    {
        try {
            $fitSeries = FitSeries::with(['category', 'subCategory'])
                ->where('is_published', true)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($series) {
                    return [
                        'id' => $series->id,
                        'title' => $series->title,
                        'description' => $series->description,
                        'thumbnail' => $series->banner_image_url,
                        'trailer_url' => $series->trailer_url,
                        'language' => $series->language,
                        'cost' => $series->cost,
                        'release_date' => $series->release_date?->format('Y-m-d'),
                        'total_episodes' => $series->total_episodes,
                        'feedback' => $series->feedback,
                        'category' => $series->category ? [
                            'id' => $series->category->id,
                            'name' => $series->category->name
                        ] : null,
                        'sub_category' => $series->subCategory ? [
                            'id' => $series->subCategory->id,
                            'name' => $series->subCategory->name
                        ] : null,
                        'created_at' => $series->created_at->format('Y-m-d H:i:s')
                    ];
                });

            return $fitSeries->toArray();
        } catch (\Exception $e) {
            \Log::error('Error in getFitSeries: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get fit live sessions organized by categories
     */
    public function getFitLive(): array
    {
        try {
            $categories = Category::with(['fitLiveSessions' => function ($query) {
                $query->where('visibility', 'public')
                    ->whereIn('status', ['scheduled', 'live'])
                    ->orderBy('scheduled_at', 'asc');
            }])
            ->whereHas('fitLiveSessions', function ($query) {
                $query->where('visibility', 'public');
            })
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'live_sessions' => $category->fitLiveSessions->map(function ($session) {
                        return [
                            'id' => $session->id,
                            'title' => $session->title,
                            'description' => $session->description,
                            'thumbnail' => $session->banner_image,
                            'instructor' => $session->instructor ? [
                                'id' => $session->instructor->id,
                                'name' => $session->instructor->name,
                                'profile_image' => $session->instructor->profile_picture ?? null
                            ] : null,
                            'scheduled_at' => $session->scheduled_at?->format('Y-m-d H:i:s'),
                            'started_at' => $session->started_at?->format('Y-m-d H:i:s'),
                            'ended_at' => $session->ended_at?->format('Y-m-d H:i:s'),
                            'status' => $session->status,
                            'chat_mode' => $session->chat_mode,
                            'visibility' => $session->visibility,
                            'viewer_peak' => $session->viewer_peak ?? 0,
                            'recording_enabled' => $session->recording_enabled,
                            'has_recording' => $session->hasRecording()
                        ];
                    })
                ];
            });

            return $categories->toArray();
        } catch (\Exception $e) {
            \Log::error('Error in getFitLive: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get fit guide sessions organized by categories
     */
    public function getFitGuide(): array
    {
        try {
            // For now, return guide-specific sessions from fitLiveSessions with 'ended' status (recorded guides)
            $categories = Category::with(['fitLiveSessions' => function ($query) {
                $query->where('visibility', 'public')
                    ->where('status', 'ended')
                    ->whereNotNull('recording_url')
                    ->orderBy('created_at', 'desc');
            }])
            ->whereHas('fitLiveSessions', function ($query) {
                $query->where('visibility', 'public')
                    ->where('status', 'ended')
                    ->whereNotNull('recording_url');
            })
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'guide_sessions' => $category->fitLiveSessions->map(function ($session) {
                        return [
                            'id' => $session->id,
                            'title' => $session->title,
                            'description' => $session->description,
                            'thumbnail' => $session->banner_image,
                            'instructor' => $session->instructor ? [
                                'id' => $session->instructor->id,
                                'name' => $session->instructor->name,
                                'profile_image' => $session->instructor->profile_picture ?? null
                            ] : null,
                            'duration' => $session->getFormattedRecordingDuration(),
                            'recording_url' => $session->recording_url,
                            'mp4_path' => $session->mp4_path,
                            'status' => $session->status,
                            'viewer_peak' => $session->viewer_peak ?? 0,
                            'created_at' => $session->created_at->format('Y-m-d H:i:s')
                        ];
                    })
                ];
            });

            return $categories->toArray();
        } catch (\Exception $e) {
            \Log::error('Error in getFitGuide: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get all fit casts/videos
     */
    public function getFitCasts(): array
    {
        try {
            $fitCasts = FitCast::with(['category', 'instructor'])
                ->active()
                ->published()
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($cast) {
                    return [
                        'id' => $cast->id,
                        'title' => $cast->title,
                        'description' => $cast->description,
                        'thumbnail' => $cast->thumbnail,
                        'video_url' => $cast->video_url,
                        'duration' => $cast->duration,
                        'category' => $cast->category ? [
                            'id' => $cast->category->id,
                            'name' => $cast->category->name
                        ] : null,
                        'instructor' => $cast->instructor ? [
                            'id' => $cast->instructor->id,
                            'name' => $cast->instructor->name,
                            'profile_image' => $cast->instructor->profile_picture ?? null
                        ] : null,
                        'views_count' => $cast->views_count ?? 0,
                        'likes_count' => $cast->likes_count ?? 0,
                        'is_featured' => $cast->is_featured ?? false,
                        'published_at' => $cast->published_at?->format('Y-m-d H:i:s'),
                        'created_at' => $cast->created_at->format('Y-m-d H:i:s')
                    ];
                });

            return $fitCasts->toArray();
        } catch (\Exception $e) {
            \Log::error('Error in getFitCasts: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get all fit news (live and recorded)
     */
    public function getFitNews(): array
    {
        try {
            $fitNews = FitNews::with(['creator'])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($news) {
                    return [
                        'id' => $news->id,
                        'title' => $news->title,
                        'description' => $news->description,
                        'thumbnail' => $news->thumbnail,
                        'status' => $news->status,
                        'scheduled_at' => $news->scheduled_at?->format('Y-m-d H:i:s'),
                        'started_at' => $news->started_at?->format('Y-m-d H:i:s'),
                        'ended_at' => $news->ended_at?->format('Y-m-d H:i:s'),
                        'channel_name' => $news->channel_name,
                        'viewer_count' => $news->viewer_count ?? 0,
                        'is_live' => $news->isLive(),
                        'is_scheduled' => $news->isScheduled(),
                        'has_ended' => $news->hasEnded(),
                        'creator' => $news->creator ? [
                            'id' => $news->creator->id,
                            'name' => $news->creator->name,
                            'profile_image' => $news->creator->profile_picture ?? null
                        ] : null,
                        'recording_enabled' => $news->recording_enabled,
                        'recording_url' => $news->recording_url,
                        'has_recording' => $news->hasRecording(),
                        'duration' => $news->getDuration(),
                        'created_at' => $news->created_at->format('Y-m-d H:i:s')
                    ];
                });

            return $fitNews->toArray();
        } catch (\Exception $e) {
            \Log::error('Error in getFitNews: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get all fit insights (blogs)
     */
    public function getFitInsights(): array
    {
        try {
            $fitInsights = FitInsight::with(['author', 'category'])
                ->published()
                ->orderBy('published_at', 'desc')
                ->get()
                ->map(function ($insight) {
                    return [
                        'id' => $insight->id,
                        'title' => $insight->title,
                        'slug' => $insight->slug,
                        'excerpt' => $insight->excerpt,
                        'content' => $insight->content,
                        'featured_image' => $insight->featured_image_url,
                        'category' => $insight->category ? [
                            'id' => $insight->category->id,
                            'name' => $insight->category->name
                        ] : null,
                        'author' => $insight->author ? [
                            'id' => $insight->author->id,
                            'name' => $insight->author->name,
                            'profile_image' => $insight->author->profile_picture ?? null,
                            'bio' => $insight->author->bio ?? null
                        ] : null,
                        'views_count' => $insight->views_count ?? 0,
                        'likes_count' => $insight->likes_count ?? 0,
                        'comments_count' => $insight->comments_count ?? 0,
                        'shares_count' => $insight->shares_count ?? 0,
                        'published_at' => $insight->published_at?->format('Y-m-d H:i:s'),
                        'reading_time' => $insight->reading_time ?? 0,
                        'meta_data' => $insight->meta_data,
                        'created_at' => $insight->created_at->format('Y-m-d H:i:s')
                    ];
                });

            return $fitInsights->toArray();
        } catch (\Exception $e) {
            \Log::error('Error in getFitInsights: ' . $e->getMessage());
            return [];
        }
    }

    /**
 * Get specific fit series by ID
 */
    public function getFitSeriesById($id): JsonResponse
    {
        try {
            $series = FitSeries::with(['category', 'subCategory'])
                ->where('id', $id)
                ->where('is_active', true)
                ->first(); // 👈 returns single model or null

            $similarSeries = FitSeries::with(['category', 'subCategory'])
                ->where('is_active', true)
                ->get(); // 👈 returns single model or null

            if (!$series) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fit series not found'
                ], 404);
            }

            // 🔑 Get current user
            $user = auth()->user();

            // 🔎 Check if user liked this series
            $isLiked = false;
            if ($user) {
                $isLiked = PostLike::where('post_type', 'fit_series_video')
                    ->where('post_id', $series->id)
                    ->where('user_id', $user->id)
                    ->exists();
            }

            // You can now shape the response however you like
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $series->id,
                    'title' => $series->title,
                    'description' => $series->description,
                    // 'thumbnail' => $series->thumbnail_url,
                    // 'video_url' => $series->video_url,
                    'thumbnail' => $series->banner_image_path,
                    'video_url' => $series->trailer_url,
                    'duration' => $series->duration,
                    'difficulty_level' => $series->difficulty_level,
                    'category' => $series->category ? $series->category->name : 'General',
                    'instructor' => $series->instructor,
                    'views_count' => $series->views_count ?? 0,
                    'likes_count' => $series->likes_count ?? 0,
                    'share_count' => $series->shares_count ?? 0,
                    'is_liked' => $isLiked,
                    'type' => 'fitseries',
                    'language' => $series->language,
                    'created_at' => $series->created_at->format('Y-m-d H:i:s')
                ],
                'similar_data' => $similarSeries
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch fit series',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Fit Expert Live sessions by ID (premium live sessions)
     */
    public function getFitExpertLiveById($id): JsonResponse
    {
        try {
            // For FitExpert Live, we'll use sessions with 'expert' in title or specific category
            $expertSessions = FitLiveSession::with(['category', 'instructor'])
                ->where('visibility', 'public')
                ->where('id', $id)
                // ->where(function($query) {
                //     $query->where('title', 'like', '%expert%')
                //           ->orWhere('title', 'like', '%advanced%')
                //           ->orWhere('title', 'like', '%masterclass%');
                // })
                ->whereIn('status', ['scheduled', 'live'])
                ->orderBy('scheduled_at', 'asc')
                ->limit(10)
                ->get()
                ->map(function ($session) {
                    $viewerId = auth()->check() ? auth()->id() : rand(100000, 999999);
                    // $streamingConfig = '';
                    // if($session->status == 'live'){
                        $streamingConfig = [
                                'app_id' => config('agora.app_id'),
                                'channel' => 'fitlive_' . $session->id,
                                'token' => $this->agoraService->generateToken('fitlive_' . $session->id, $viewerId, 'subscriber'),
                                'uid' => $viewerId,
                                'role' => 'subscriber',
                                'configured' => !empty(config('agora.app_id'))
                        ];
                    // }

                    return [
                        'id' => $session->id,
                        'title' => $session->title,
                        'category' => $session->category ? $session->category->name : 'Expert Session',
                        'image' => $session->banner_image ? asset('storage/app/public/' . $session->banner_image) : null,
                        'recording_url' => $session->recording_url,
                        'description' => $session->description,
                        'instructor' => $session->instructor ? $session->instructor->name : 'Expert',
                        'views' => $session->viewer_peak,
                        'scheduled_at' => $session->scheduled_at?->format('Y-m-d H:i:s'),
                        'status' => $session->status,
                        'type' => 'fitexpert_live',
                        'streamingConfig' => $streamingConfig,
                    ];
                });

            // if($expertSessions){
            //     $viewerId = auth()->check() ? auth()->id() : rand(100000, 999999);
            //     $expertSessions = [
            //         'app_id' => config('agora.app_id'),
            //         'channel' => 'fitlive_' . $session->id,
            //         'token' => $this->agoraService->generateToken('fitlive_' . $session->id, $viewerId, 'subscriber'),
            //         'uid' => $viewerId,
            //         'role' => 'subscriber',
            //         'configured' => !empty(config('agora.app_id'))
            //     ];
                
            //     $expertSessions['streamingConfig'] = $streamingConfig;
            // }

            // You can now shape the response however you like
            return response()->json([
                'success' => true,
                'data' => $expertSessions->toArray(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch fit expert',
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

            $request->validate([
                'post_type' => 'required||in:fit_series_video,fit_live_video,fit_guide_video,fit_cast_video,fit_news_video,fit_insight_video'
            ]);

            $user = Auth::user();
            $video = FitSeries::find($videoId);

            if (!$video) {
                return response()->json([
                    'success' => false,
                    'message' => 'Video not found'
                ], 404);
            }

            $existingLike = PostLike::where('post_type', $request->post_type)
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
                    'post_type' => $request->post_type,
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
     * Share a blog
     */
    public function share(Request $request, $id): JsonResponse
    {
        try {

            $FitSeries = FitSeries::find($id);

            if (!$FitSeries) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to share series',
                    'error'   => 'Series not found'
                ], 404); // Use 404 since resource not found
            }

            // Increment share count
            $FitSeries->increment('shares_count');

            return response()->json([
                'success' => true,
                'data' => [
                    'share_url' => url("/fitdoc/single/{$FitSeries->slug}"),
                    'total_shares' => $FitSeries->shares_count
                ],
                'message' => 'Fitseries shared successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to share Fitseries',
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
                'parent_id' => 'nullable|exists:post_comments,id',
                'post_type' => 'required||in:fit_series_video,fit_live_video,fit_guide_video,fit_cast_video,fit_news_video,fit_insight_video'
            ]);

            $user = Auth::user();
            $video = FitSeries::find($videoId);

            if (!$video) {
                return response()->json([
                    'success' => false,
                    'message' => 'Video not found'
                ], 404);
            }

            $comment = PostComment::create([
                'user_id' => $user->id,
                'post_type' => $request->post_type,
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

    /**
     * Get live sessions by category
     */
    public function getLiveSessionsByCategory($categoryId): JsonResponse
    {
        try {
            $category = Category::with(['liveSessions' => function ($query) {
                $query->where('is_active', true)
                    ->orderBy('scheduled_at', 'asc');
            }])->find($categoryId);

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'category' => [
                        'id' => $category->id,
                        'name' => $category->name,
                        'description' => $category->description
                    ],
                    'live_sessions' => $category->liveSessions
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch live sessions',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}