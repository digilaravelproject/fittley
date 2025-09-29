<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FiBlog;
use App\Models\FiCategory;
use App\Models\PostLike;
use App\Models\PostComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FitInsightApiController extends Controller
{
    /**
     * Get all FitInsight blogs
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $blogs = FiBlog::published()
                ->with(['category', 'author'])
                ->orderBy('published_at', 'desc')
                ->paginate($request->get('per_page', 15));

            return response()->json([
                'success' => true,
                'data' => $blogs,
                'message' => 'FitInsight blogs retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve FitInsight blogs',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get FitInsight categories
     */
    public function categories(Request $request): JsonResponse
    {
        try {
            $categories = FiCategory::where('is_active', true)
                ->orderBy('sort_order')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $categories,
                'message' => 'FitInsight categories retrieved successfully'
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
     * Show a specific FitInsight blog
     */
    public function show(Request $request, FiBlog $blog): JsonResponse
    {
        try {
            $blog->load(['category', 'author']);

            // Increment view count
            $blog->increment('views_count');

            return response()->json([
                'success' => true,
                'data' => $blog,
                'message' => 'FitInsight blog retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve FitInsight blog',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Fit Insights content by ID
     */
    public function getFitInsightsById(Request $request, $id): JsonResponse
    {
        try {

            $insights = FiBlog::with(['author', 'category'])
                ->where('id', $id)
                ->published()
                ->orderBy('published_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($insight) {

                    // 🔑 Get current user
                    $user = auth()->user();

                    // Default value
                    $isLiked = false;

                    // Check if logged-in user liked this news
                    if ($user) {
                        $isLiked = PostLike::where('post_type', 'fit_insight_video') // ✅ use proper type
                            ->where('post_id', $insight->id) // ✅ use $item->id
                            ->where('user_id', $user->id)
                            ->exists();
                    }

                    return [
                        'id' => $insight->id,
                        'title' => $insight->title,
                        'category' => $insight->category ? $insight->category->name : 'Insights',
                        'image' => $insight->featured_image_url,
                        'description' => $insight->excerpt,
                        'author' => $insight->author ? $insight->author->name : 'Author',
                        'published_at' => $insight->published_at?->format('Y-m-d H:i:s'),
                        'reading_time' => $insight->reading_time ?? 0,
                        'views_count' => $insight->views_count,
                        'likes_count' => $insight->likes_count,
                        'shares_count' => $insight->shares_count,
                        'type' => 'fit_insights',
                        'is_like' => $isLiked,
                    ];
                });

            $AllComment = '';
            
            // 🔑 Get current user
            $user = auth()->user();

            // Check if logged-in user comment this news
            if ($user) {
                $AllComment = PostComment::where('post_type', 'fit_insight_video')
                    ->where('post_id', $id) // ✅ use $item->id
                    ->where('user_id', $user->id)
                    ->get();
            }

            return response()->json([
                'success' => true,
                'data' => $insights,
                'comments' => $AllComment,
                'message' => 'FitInsight blog retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve FitInsight blog',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Like a blog
     */
    public function like_old(Request $request, FiBlog $FiBlog): JsonResponse
    {
        try {
                // Like → increment likes_count
                $FiBlog->increment('likes_count');
                $liked = true;

            return response()->json([
                'success' => true,
                'data' => [
                    'liked' => $liked,
                    'total_likes' => $FiBlog->likes_count
                ],
                'message' => 'Blog liked successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to like blog',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Like or unlike a blog
     */
    public function like(Request $request, $blogId): JsonResponse
    {
        try {
            $request->validate([
                'post_type' => 'required|in:fit_insight_video' // 👈 restrict only to blog type
            ]);

            $user = Auth::user();
            $blog = FiBlog::find($blogId);

            if (!$blog) {
                return response()->json([
                    'success' => false,
                    'message' => 'Blog not found'
                ], 404);
            }

            $existingLike = PostLike::where('post_type', $request->post_type)
                ->where('post_id', $blogId)
                ->where('user_id', $user->id)
                ->first();

            if ($existingLike) {
                // Unlike
                $existingLike->delete();
                $blog->decrement('likes_count'); // optional if you keep denormalized count
                $isLiked = false;
                $message = 'Like removed';
            } else {
                // Like
                PostLike::create([
                    'post_type' => $request->post_type,
                    'post_id' => $blogId,
                    'user_id' => $user->id
                ]);
                $blog->increment('likes_count'); // optional if you keep denormalized count
                $isLiked = true;
                $message = 'Blog liked';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'is_liked' => $isLiked,
                    'likes_count' => $blog->fresh()->likes_count
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle blog like',
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

            $blog = FiBlog::find($id);

            if (!$blog) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to share blog',
                    'error'   => 'Blog not found'
                ], 404); // Use 404 since resource not found
            }

            $blog->increment('shares_count');
            
            return response()->json([
                'success' => true,
                'data' => [
                    'share_url' => url("/fitinsight/{$blog->id}"),
                    'total_shares' => $blog->shares_count,
                ],
                'message' => 'Blog shared successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to share blog',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
