<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FitNews;
use App\Models\FitCast;
use App\Models\PostLike;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FitNewsApiController extends Controller
{
    /**
     * Get all FitNews articles
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $news = FitNews::published()
                ->with(['category', 'author'])
                ->orderBy('published_at', 'desc')
                ->paginate($request->get('per_page', 15));

            return response()->json([
                'success' => true,
                'data' => $news,
                'message' => 'FitNews articles retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve FitNews articles',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show a specific FitNews article
     */
    public function show(Request $request, FitNews $fitNews): JsonResponse
    {
        try {
            $fitNews->load(['category', 'author']);

            // Increment view count
            $fitNews->increment('views');

            return response()->json([
                'success' => true,
                'data' => $fitNews,
                'message' => 'FitNews article retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve FitNews article',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Fit News content on ID
     */
    public function getFitNewsById(Request $request, $id): JsonResponse
    {
        try {
            $news = FitNews::with(['creator'])
                ->where('id', $id)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($item) {
                    
                    // 🔑 Get current user
                    $user = auth()->user();

                    // Default value
                    $isLiked = false;

                    // Check if logged-in user liked this news
                    if ($user) {
                        $isLiked = PostLike::where('post_type', 'fit_news_video') // ✅ use proper type
                            ->where('post_id', $item->id) // ✅ use $item->id
                            ->where('user_id', $user->id)
                            ->exists();
                    }

                    return [
                        'id' => $item->id,
                        'title' => $item->title,
                        'category' => 'News',
                        'image' => $item->thumbnail,
                        'description' => $item->description,
                        'rating' => $item->average_rating,
                        'creator' => $item->creator ? $item->creator->name : 'News Team',
                        'scheduled_at' => $item->scheduled_at?->format('Y-m-d H:i:s'),
                        'status' => $item->status,
                        'like_count' => $item->likes_count,
                        'share_count' => $item->shares_count,
                        'view_count' => $item->views_count,
                        'recording_url' => $item->recording_url,
                        'recording_duration' => $item->recording_duration,
                        'recording_file_size' => $item->recording_file_size,
                        'viewer_count' => $item->viewer_count,
                        'recording_url' => $item->recording_url,
                        'type' => 'fitnews',
                        'is_like' => $isLiked,
                    ];
                });

            $archiveSession = FitNews::with(['creator'])
                        ->whereNotNull('ended_at')
                        ->orderBy('ended_at', 'desc')->get();

            return response()->json([
                'success' => true,
                'data' => $news,
                'archive_classes' => $archiveSession,
                'message' => 'FitNews article retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve FitNews article',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Join news discussion
     */
    public function join(Request $request, FitNews $fitNews): JsonResponse
    {
        try {
            // Implementation for joining news discussion
            // This could involve subscribing to notifications or joining a chat room
            
            return response()->json([
                'success' => true,
                'message' => 'Successfully joined news discussion'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to join news discussion',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Like a blog
     */
    public function like_old(Request $request, FitNews $FitNews): JsonResponse
    {
        try {
                // Like → increment likes_count
                $FitNews->increment('likes_count');
                $liked = true;

            return response()->json([
                'success' => true,
                'data' => [
                    'liked' => $liked,
                    'total_likes' => $FitNews->likes_count
                ],
                'message' => 'News liked successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to like news',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Like or unlike a blog (FitNews)
     */
    public function like(Request $request, $newsId): JsonResponse
    {
        try {
            $request->validate([
                'post_type' => 'required|in:fit_news_video' // 👈 restrict to blogs if you want
            ]);

            $user = Auth::user();
            $news = FitNews::find($newsId);

            if (!$news) {
                return response()->json([
                    'success' => false,
                    'message' => 'News not found'
                ], 404);
            }

            // Check if user already liked this news
            $existingLike = PostLike::where('post_type', $request->post_type)
                ->where('post_id', $newsId)
                ->where('user_id', $user->id)
                ->first();

            if ($existingLike) {
                // Remove like
                $existingLike->delete();
                $news->decrement('likes_count'); // optional if you want to sync counts
                $isLiked = false;
                $message = 'Like removed';
            } else {
                // Add new like
                PostLike::create([
                    'post_type' => $request->post_type,
                    'post_id' => $newsId,
                    'user_id' => $user->id
                ]);
                $news->increment('likes_count'); // optional if you want to sync counts
                $isLiked = true;
                $message = 'News liked';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'is_liked' => $isLiked,
                    'likes_count' => $news->fresh()->likes_count
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
     * Share a news
     */
    public function share(Request $request, $id): JsonResponse
    {
        try {
            $fitNews = FitNews::find($id);

            if (!$fitNews) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to share news',
                    'error'   => 'News not found'
                ], 404); // Use 404 since resource not found
            }

            // Increment share count
            $fitNews->increment('shares_count');

            return response()->json([
                'success' => true,
                'data' => [
                    'share_url' => url("/fitnews/{$fitNews->id}"),
                    'total_shares' => $fitNews->shares_count
                ],
                'message' => 'News shared successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to share news',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Leave news discussion
     */
    public function leave(Request $request, FitNews $fitNews): JsonResponse
    {
        try {
            // Implementation for leaving news discussion
            
            return response()->json([
                'success' => true,
                'message' => 'Successfully left news discussion'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to leave news discussion',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
