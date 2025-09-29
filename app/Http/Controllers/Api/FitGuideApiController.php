<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FgSingle;
use App\Models\FgSeries;
use App\Models\Category;
use App\Models\FitLiveSession;
use App\Models\FitCast;
use App\Models\PostLike;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FitGuideApiController extends Controller
{
    /**
     * Get all FitGuides (Singles and Series)
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $singles = FgSingle::published()
                ->with(['category', 'subCategory'])
                ->limit(10)
                ->get();

            $series = FgSeries::published()
                ->with(['category', 'subCategory'])
                ->limit(10)
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'singles' => $singles,
                    'series' => $series
                ],
                'message' => 'FitGuides retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve FitGuides',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show a specific FitGuide by ID (can be single or series)
     */
    public function show(Request $request, $id): JsonResponse
    {
        try {
            // Try to find as single first
            $single = FgSingle::where('id', $id)
                ->where('is_published', true)
                ->with(['category', 'subCategory'])
                ->first();

            if ($single) {
                return response()->json([
                    'success' => true,
                    'data' => $single,
                    'type' => 'single',
                    'message' => 'FitGuide retrieved successfully'
                ]);
            }

            // Try to find as series
            $series = FgSeries::where('id', $id)
                ->where('is_published', true)
                ->with(['category', 'subCategory', 'instructor'])
                ->first();

            if ($series) {
                return response()->json([
                    'success' => true,
                    'data' => $series,
                    'type' => 'series',
                    'message' => 'FitGuide retrieved successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'FitGuide not found'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve FitGuide',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Fit Guide content
     */
    public function getFitGuideById(Request $request, $id): JsonResponse
    {
        try {
            // Get recorded sessions as guides
            $guides =  FgSeries::with(['category', 'subCategory'])
                    ->where('id', $id)
                    ->where('is_published', true)
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->map(function ($session) {
                        return [
                            'id' => $session->id,
                            'title' => $session->title,
                            'category' => $session->category ? $session->category->name : 'Guide',
                            'image' => $session->banner_image,
                            'description' => $session->description,
                            'instructor' => $session->instructor ? $session->instructor->name : 'Instructor',
                            // 'duration' => $session->getFormattedRecordingDuration(),
                            'duration' => '5',
                            'recording_url' => $session->recording_url,
                            'type' => 'fit_guide'
                        ];
                    })
                    ->groupBy(function ($item) {
                        return $item['category']; // Group by category
                    });

                // 🔑 Get current user
                $user = auth()->user();

                // 🔎 Append is_like field for each guide inside each category
                $guides = $guides->map(function ($group) use ($user) {
                    return $group->map(function ($guide) use ($user) {
                        $guide['is_like'] = false;

                        if ($user) {
                            $guide['is_like'] = PostLike::where('post_type', 'fit_guide_video')
                                ->where('post_id', $guide['id'])
                                ->where('user_id', $user->id)
                                ->exists();
                        }

                        return $guide;
                    });
                });

            $SimilarData = FitLiveSession::with(['category', 'instructor'])
                ->where('visibility', 'public')
                ->where('status', 'ended')
                ->whereNotNull('recording_url')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($session) {
                    return [
                        'id' => $session->id,
                        'title' => $session->title,
                        'category' => $session->category ? $session->category->name : 'Guide',
                        'image' => $session->banner_image,
                        'description' => $session->description,
                        'instructor' => $session->instructor ? $session->instructor->name : 'Instructor',
                        'duration' => $session->getFormattedRecordingDuration(),
                        'recording_url' => $session->recording_url,
                        'type' => 'fit_guide'
                    ];
                })
                ->groupBy(function ($item) {
                    return $item['category']; // Group by category
                });

            if ($guides) {
                return response()->json([
                    'success' => true,
                    'data' => $guides,
                    'similar_data' => $SimilarData,
                    'type' => 'series',
                    'message' => 'FitGuide retrieved successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'FitGuide not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve FitGuide',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get fit casts/videos on ID
     */
    public function getFitCastsById(Request $request, $id): JsonResponse
    {
        try {
            $fitCasts = FitCast::with(['category', 'instructor'])
                ->where('id', $id)
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
                        'rating' => $cast->average_rating,
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

            return response()->json([
                'success' => true,
                'data' => $fitCasts,
                'message' => 'Fitcast retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve Fitcast',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
 * Like or unlike a blog (FitLiveSession)
 */
    public function like(Request $request, $sessionId): JsonResponse
    {
        try {
            $request->validate([
                'post_type' => 'required|in:fit_series_video,fit_live_video,fit_guide_video,fit_cast_video,fit_news_video,fit_insight_video'
            ]);

            $user = Auth::user();
            $session = FitCast::find($sessionId);

            if (!$session) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session not found'
                ], 404);
            }

            $existingLike = PostLike::where('post_type', $request->post_type)
                ->where('post_id', $sessionId)
                ->where('user_id', $user->id)
                ->first();

            if ($existingLike) {
                // Remove like
                $existingLike->delete();
                $session->decrement('likes_count'); // optional if you want live count tracking
                $isLiked = false;
                $message = 'Like removed';
            } else {
                // Add new like
                PostLike::create([
                    'post_type' => $request->post_type,
                    'post_id' => $sessionId,
                    'user_id' => $user->id
                ]);
                $session->increment('likes_count'); // optional if you want live count tracking
                $isLiked = true;
                $message = 'Session liked';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'is_liked' => $isLiked,
                    'likes_count' => $session->fresh()->likes_count
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

            $FitLiveSession = FitCast::find($id);

            if (!$FitLiveSession) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to share session',
                    'error'   => 'Session not found'
                ], 404); // Use 404 since resource not found
            }

            // Increment share count
            $FitLiveSession->increment('shares_count');

            return response()->json([
                'success' => true,
                'data' => [
                    'share_url' => url("/fitlive/session/{$FitLiveSession->id}"),
                    'total_shares' => $FitLiveSession->shares_count
                ],
                'message' => 'Session shared successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to share session',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get FitGuide categories
     */
    public function categories(Request $request): JsonResponse
    {
        try {
            $categories = Category::where('type', 'fitguide')
                ->with('subcategories')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $categories,
                'message' => 'FitGuide categories retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show a specific single FitGuide
     */
    public function showSingle_old(Request $request, FgSingle $fgSingle): JsonResponse
    {
        try {
            $fgSingle->load(['category', 'subCategory', 'instructor']);

            return response()->json([
                'success' => true,
                'data' => $fgSingle,
                'message' => 'FitGuide single retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve FitGuide single',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show a specific single FitGuide by ID
     */
    public function showSingle(Request $request, $id): JsonResponse
    {
        try {
            $fgSingle = FgSingle::with(['category', 'subCategory'])
                ->find($id);

            if (!$fgSingle) {
                return response()->json([
                    'success' => false,
                    'message' => 'FitGuide single not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $fgSingle,
                'message' => 'FitGuide single retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve FitGuide single',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Show a specific FitGuide series
     */
    public function showSeries_old(Request $request, FgSeries $fgSeries): JsonResponse
    {
        try {
            $fgSeries->load(['category', 'subCategory', 'instructor']);

            return response()->json([
                'success' => true,
                'data' => $fgSeries,
                'message' => 'FitGuide series retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve FitGuide series',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show a specific FitGuide series by ID
     */
    public function showSeries(Request $request, $id): JsonResponse
    {
        try {
            $fgSeries = \App\Models\FgSeries::with(['category', 'subCategory'])
                ->find($id);

            if (!$fgSeries) {
                return response()->json([
                    'success' => false,
                    'message' => 'FitGuide series not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $fgSeries,
                'message' => 'FitGuide series retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve FitGuide series',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get episodes for a FitGuide series
     */
    public function seriesEpisodes_old(Request $request, FgSeries $fgSeries): JsonResponse
    {
        try {
            $episodes = $fgSeries->episodes()
                ->orderBy('episode_number')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $episodes,
                'message' => 'Series episodes retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve series episodes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get episodes for a FitGuide series by ID
     */
    public function seriesEpisodes(Request $request, $id): JsonResponse
    {
        try {
            // Find the series first
            $fgSeries = \App\Models\FgSeries::find($id);

            if (!$fgSeries) {
                return response()->json([
                    'success' => false,
                    'message' => 'FitGuide series not found'
                ], 404);
            }

            // Then fetch its episodes
            $episodes = $fgSeries->episodes()
                ->orderBy('episode_number')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $episodes,
                'message' => 'Series episodes retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve series episodes',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
