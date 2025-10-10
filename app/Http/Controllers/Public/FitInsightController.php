<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\FiBlog;
use App\Models\FiCategory;
use App\Models\PostComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FitInsightController extends Controller
{
    /**
     * Display a listing of published blogs.
     */
    public function index(Request $request)
    {
        $query = FiBlog::published()->with(['category', 'author']);

        // Search functionality
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('content', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('fi_category_id', $request->category);
        }

        // Sorting
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'popular':
                $query->orderBy('views_count', 'desc');
                break;
            case 'oldest':
                $query->orderBy('published_at', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('published_at', 'desc');
                break;
        }

        $blogs = $query->paginate(12);

        // Get categories for filter
        $categories = FiCategory::where('is_active', true)
            ->withCount(['publishedBlogs'])
            ->having('published_blogs_count', '>', 0)
            ->orderBy('sort_order')
            ->get();

        // Get featured blogs for sidebar (top viewed)
        $featuredBlogs = FiBlog::published()
            ->featured()
            ->with(['category', 'author'])
            ->take(5)
            ->get();

        // Get trending blogs for sidebar (recent with high views)
        $trendingBlogs = FiBlog::published()
            ->trending()
            ->with(['category', 'author'])
            ->take(5)
            ->get();

        return view('public.fitinsight.index', compact(
            'blogs',
            'categories',
            'featuredBlogs',
            'trendingBlogs'
        ));
    }

    /**
     * Display blogs by category.
     */
    public function category(FiCategory $category, Request $request)
    {
        // Base query for blogs in this category
        $query = $category->publishedBlogs()->with(['category', 'author']);

        // Search functionality — search in title or content within the category only
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('content', 'like', "%{$searchTerm}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'popular':
                $query->orderBy('views_count', 'desc');
                break;
            case 'oldest':
                $query->orderBy('published_at', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('published_at', 'desc');
                break;
        }

        $blogs = $query->paginate(12)->withQueryString();

        // Sidebar - latest blogs from this category
        $latestBlogs = $category->publishedBlogs()
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();

        // Sidebar - popular blogs from this category
        $popularBlogs = $category->publishedBlogs()
            ->orderBy('views_count', 'desc')
            ->take(5)
            ->get();

        // Other categories for nav or sidebar if needed
        $categories = FiCategory::where('is_active', true)
            ->withCount(['publishedBlogs'])
            ->having('published_blogs_count', '>', 0)
            ->orderBy('sort_order')
            ->get();

        // Featured blogs if you want to keep using them somewhere
        $featuredBlogs = $category->publishedBlogs()
            ->featured()
            ->take(5)
            ->get();

        return view('public.fitinsight.category', compact(
            'category',
            'blogs',
            'categories',
            'featuredBlogs',
            'latestBlogs',
            'popularBlogs'
        ));
    }


    /**
     * Display the specified blog.
     */
    public function show(FiBlog $blog)
    {
        if (!$blog->isPublished()) {
            abort(404, 'Blog not found');
        }

        $blog->incrementViews();
        $blog->load(['category', 'author']);

        $relatedBlogs = FiBlog::published()
            ->where('fi_category_id', $blog->fi_category_id)
            ->where('id', '!=', $blog->id)
            ->with(['category', 'author'])
            ->take(4)
            ->get();

        $authorBlogs = FiBlog::published()
            ->where('author_id', $blog->author_id)
            ->where('id', '!=', $blog->id)
            ->with(['category', 'author'])
            ->take(3)
            ->get();

        $categories = FiCategory::where('is_active', true)
            ->withCount(['publishedBlogs'])
            ->having('published_blogs_count', '>', 0)
            ->orderBy('sort_order')
            ->get();

        // Fetch popular blogs by views (example)
        $popularBlogs = FiBlog::published()
            ->orderBy('views_count', 'desc')
            ->with(['category', 'author'])
            ->take(5)
            ->get();

        return view('public.fitinsight.show', compact(
            'blog',
            'relatedBlogs',
            'authorBlogs',
            'categories',
            'popularBlogs'  // pass this too
        ));
    }
    
    /**
     * Return comments for a blog (AJAX JSON).
     */
    public function comments(FiBlog $blog)
    {
        if (!$blog->isPublished()) {
            return response()->json(['success' => false, 'message' => 'Blog not found'], 404);
        }
    
        $comments = PostComment::forFitInsight()
            ->active()
            ->where('post_id', $blog->id)
            ->with('user:id,name')
            ->latest()
            ->get();
    
        return response()->json([
            'success' => true,
            'comments' => $comments->map(function ($c) {
                return [
                    'id'      => $c->id,
                    'author'  => optional($c->user)->name ?? 'Guest',
                    'content' => $c->content,
                    'time'    => $c->created_at->diffForHumans(),
                ];
            }),
        ]);
    }
    
    /**
     * Store a new comment for a blog (AJAX JSON).
     */
    public function storeComment(Request $request, FiBlog $blog)
    {
        if (!$blog->isPublished()) {
            return response()->json(['success' => false, 'message' => 'Blog not found'], 404);
        }
    
        $validated = $request->validate([
            'content'   => 'required|string|max:1000',
            'parent_id' => 'nullable|integer', // (optional) for threading
        ]);
    
        $comment = PostComment::create([
            'user_id'   => Auth::id(),          // null for guests
            'post_type' => 'fit_insight_video', // IMPORTANT
            'post_id'   => $blog->id,
            'parent_id' => $validated['parent_id'] ?? null,
            'content'   => $validated['content'],
            'likes_count' => 0,
            'is_active'   => true,
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Comment added successfully!',
            'comment' => [
                'id'      => $comment->id,
                'author'  => Auth::user()->name ?? 'Guest',
                'content' => $comment->content,
                'time'    => $comment->created_at->diffForHumans(),
            ],
        ]);
    }

    public function show_old(FiBlog $blog)
    {
        // Check if blog is published
        if (!$blog->isPublished()) {
            abort(404, 'Blog not found');
        }

        // Increment view count
        $blog->incrementViews();

        // Load relationships
        $blog->load(['category', 'author']);

        // Get related blogs (same category, excluding current)
        $relatedBlogs = FiBlog::published()
            ->where('fi_category_id', $blog->fi_category_id)
            ->where('id', '!=', $blog->id)
            ->with(['category', 'author'])
            ->take(4)
            ->get();

        // Get recent blogs from same author
        $authorBlogs = FiBlog::published()
            ->where('author_id', $blog->author_id)
            ->where('id', '!=', $blog->id)
            ->with(['category', 'author'])
            ->take(3)
            ->get();

        // Get categories for navigation
        $categories = FiCategory::where('is_active', true)
            ->withCount(['publishedBlogs'])
            ->having('published_blogs_count', '>', 0)
            ->orderBy('sort_order')
            ->get();

        return view('public.fitinsight.show', compact(
            'blog',
            'relatedBlogs',
            'authorBlogs',
            'categories'
        ));
    }

    /**
     * Like a blog (AJAX).
     */

    public function like(Request $request, FiBlog $blog)
    {
        if (!$blog->isPublished()) {
            return response()->json(['success' => false, 'message' => 'Blog not found'], 404);
        }
    
        // Keep track of liked blog IDs in session for this user/visitor
        $liked = $request->session()->get('liked_blogs', []); // array of blog IDs
    
        $isCurrentlyLiked = in_array($blog->id, $liked, true);
    
        try {
            if ($isCurrentlyLiked) {
                // UNLIKE
                if ($blog->likes_count > 0) {
                    $blog->decrement('likes_count');
                }
                // remove from session
                $liked = array_values(array_diff($liked, [$blog->id]));
                $request->session()->put('liked_blogs', $liked);
    
                return response()->json([
                    'success'      => true,
                    'is_liked'     => false,
                    'likes_count'  => $blog->fresh()->likes_count,
                    'message'      => 'Blog unliked!',
                ]);
            } else {
                // LIKE
                $blog->increment('likes_count');
                // add to session
                $liked[] = $blog->id;
                $request->session()->put('liked_blogs', array_values(array_unique($liked)));
    
                return response()->json([
                    'success'      => true,
                    'is_liked'     => true,
                    'likes_count'  => $blog->fresh()->likes_count,
                    'message'      => 'Blog liked successfully!',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle like',
            ], 500);
        }
    }

    /**
     * Share a blog (AJAX).
     */
    public function share(FiBlog $blog)
    {
        if (!$blog->isPublished()) {
            return response()->json(['success' => false, 'message' => 'Blog not found'], 404);
        }

        try {
            $blog->incrementShares();

            return response()->json([
                'success' => true,
                'shares_count' => $blog->fresh()->shares_count,
                'message' => 'Share recorded successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to record share'
            ], 500);
        }
    }
}
