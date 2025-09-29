<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\FiBlog;
use App\Models\FiCategory;
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
        $query = $category->publishedBlogs()->with(['category', 'author']);

        // Search functionality
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
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

        // Get other categories for navigation
        $categories = FiCategory::where('is_active', true)
            ->withCount(['publishedBlogs'])
            ->having('published_blogs_count', '>', 0)
            ->orderBy('sort_order')
            ->get();

        // Get featured blogs from this category
        $featuredBlogs = $category->publishedBlogs()
            ->featured()
            ->with(['category', 'author'])
            ->take(5)
            ->get();

        return view('public.fitinsight.category', compact(
            'category',
            'blogs', 
            'categories', 
            'featuredBlogs'
        ));
    }

    /**
     * Display the specified blog.
     */
    public function show(FiBlog $blog)
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
    public function like(FiBlog $blog)
    {
        if (!$blog->isPublished()) {
            return response()->json(['success' => false, 'message' => 'Blog not found'], 404);
        }

        try {
            $blog->incrementLikes();

            return response()->json([
                'success' => true,
                'likes_count' => $blog->fresh()->likes_count,
                'message' => 'Blog liked successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to like blog'
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