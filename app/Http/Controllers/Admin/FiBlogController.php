<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFiBlogRequest;
use App\Models\FiBlog;
use App\Models\FiCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FiBlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = FiBlog::with(['category', 'author']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->search($search);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by author (only for non-admin users)
        if (!auth()->user()->hasRole('admin') && $request->filled('author')) {
            $query->byAuthor($request->author);
        } elseif (!auth()->user()->hasRole('admin')) {
            $query->byAuthor(auth()->id());
        }

        // Filter by featured/trending
        if ($request->filled('featured')) {
            $query->featured();
        }
        if ($request->filled('trending')) {
            $query->trending();
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        
        if (in_array($sortBy, ['title', 'status', 'published_at', 'views_count', 'created_at'])) {
            $query->orderBy($sortBy, $sortDirection);
        } else {
            $query->orderByLatest();
        }

        $blogs = $query->paginate(15);
        
        // Get categories for filter dropdown
        $categories = FiCategory::active()->orderBySort()->get();

        return view('admin.fitinsight.blogs.index', compact('blogs', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = FiCategory::active()->orderBySort()->get();
        return view('admin.fitinsight.blogs.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFiBlogRequest $request)
    {
        try {
            $data = $request->validated();

            // Handle featured image upload
            if ($request->hasFile('featured_image')) {
                $data['featured_image_path'] = $request->file('featured_image')
                    ->store('fitinsight/blogs/featured', 'public');
            }

            // Handle social image upload
            if ($request->hasFile('social_image')) {
                $data['social_image_path'] = $request->file('social_image')
                    ->store('fitinsight/blogs/social', 'public');
            }

            // Set author
            $data['author_id'] = auth()->id();

            // if status is published, set published_at automatically
            if (isset($data['status']) && $data['status'] === 'published') {
                $data['published_at'] = now()->format('Y-m-d H:i:s'); // e.g. 2025-09-18 08:42:50
            }

            $blog = FiBlog::create($data);

            $message = 'Blog created successfully!';
            if ($blog->status === 'published') {
                $message .= ' It is now live on your website.';
            } elseif ($blog->status === 'scheduled') {
                $message .= ' It will be published on ' . $blog->scheduled_at->format('M d, Y \a\t H:i');
            }

            return redirect()
                ->route('admin.fitinsight.blogs.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create blog: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FiBlog $fiBlog)
    {
        // Check if user can view this blog
        if (!auth()->user()->hasRole('admin') && $fiBlog->author_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this blog.');
        }

        $fiBlog->load(['category', 'author']);
        
        return view('admin.fitinsight.blogs.show', compact('fiBlog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FiBlog $fiBlog)
    {
        // Check if user can edit this blog
        if (!auth()->user()->hasRole('admin') && $fiBlog->author_id !== auth()->id()) {
            abort(403, 'Unauthorized access to edit this blog.');
        }

        $categories = FiCategory::active()->orderBySort()->get();
        return view('admin.fitinsight.blogs.edit', compact('fiBlog', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreFiBlogRequest $request, FiBlog $fiBlog)
    {
        // Check if user can update this blog
        if (!auth()->user()->hasRole('admin') && $fiBlog->author_id !== auth()->id()) {
            abort(403, 'Unauthorized access to update this blog.');
        }

        try {
            $data = $request->validated();

            // Handle featured image upload
            if ($request->hasFile('featured_image')) {
                // Delete old image if exists
                if ($fiBlog->featured_image_path) {
                    Storage::disk('public')->delete($fiBlog->featured_image_path);
                }
                
                $data['featured_image_path'] = $request->file('featured_image')
                    ->store('fitinsight/blogs/featured', 'public');
            }

            // Handle social image upload
            if ($request->hasFile('social_image')) {
                // Delete old image if exists
                if ($fiBlog->social_image_path) {
                    Storage::disk('public')->delete($fiBlog->social_image_path);
                }
                
                $data['social_image_path'] = $request->file('social_image')
                    ->store('fitinsight/blogs/social', 'public');
            }

            $fiBlog->update($data);

            $message = 'Blog updated successfully!';
            if ($fiBlog->status === 'published') {
                $message .= ' Changes are now live on your website.';
            } elseif ($fiBlog->status === 'scheduled') {
                $message .= ' It will be published on ' . $fiBlog->scheduled_at->format('M d, Y \a\t H:i');
            }

            return redirect()
                ->route('admin.fitinsight.blogs.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update blog: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FiBlog $fiBlog)
    {
        // Check if user can delete this blog
        if (!auth()->user()->hasRole('admin') && $fiBlog->author_id !== auth()->id()) {
            abort(403, 'Unauthorized access to delete this blog.');
        }

        try {
            // Delete images if they exist
            if ($fiBlog->featured_image_path) {
                Storage::disk('public')->delete($fiBlog->featured_image_path);
            }
            if ($fiBlog->social_image_path) {
                Storage::disk('public')->delete($fiBlog->social_image_path);
            }

            $fiBlog->delete();

            return redirect()
                ->route('admin.fitinsight.blogs.index')
                ->with('success', 'Blog deleted successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete blog: ' . $e->getMessage());
        }
    }

    /**
     * Publish a blog
     */
    public function publish(FiBlog $fiBlog)
    {
        if (!auth()->user()->hasRole('admin') && $fiBlog->author_id !== auth()->id()) {
            abort(403);
        }

        try {
            $fiBlog->update([
                'status' => 'published',
                'published_at' => now(),
                'scheduled_at' => null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Blog published successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to publish blog: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Unpublish a blog (set to draft)
     */
    public function unpublish(FiBlog $fiBlog)
    {
        if (!auth()->user()->hasRole('admin') && $fiBlog->author_id !== auth()->id()) {
            abort(403);
        }

        try {
            $fiBlog->update([
                'status' => 'draft',
                'published_at' => null,
                'scheduled_at' => null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Blog unpublished successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to unpublish blog: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(FiBlog $fiBlog)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        try {
            $fiBlog->update(['is_featured' => !$fiBlog->is_featured]);
            
            $status = $fiBlog->is_featured ? 'featured' : 'unfeatured';
            
            return response()->json([
                'success' => true,
                'message' => "Blog {$status} successfully!",
                'is_featured' => $fiBlog->is_featured
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update featured status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle trending status
     */
    public function toggleTrending(FiBlog $fiBlog)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        try {
            $fiBlog->update(['is_trending' => !$fiBlog->is_trending]);
            
            $status = $fiBlog->is_trending ? 'set as trending' : 'removed from trending';
            
            return response()->json([
                'success' => true,
                'message' => "Blog {$status} successfully!",
                'is_trending' => $fiBlog->is_trending
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update trending status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk actions for blogs
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:publish,unpublish,feature,unfeature,delete',
            'blogs' => 'required|array|min:1',
            'blogs.*' => 'exists:fi_blogs,id'
        ]);

        try {
            $query = FiBlog::whereIn('id', $request->blogs);
            
            // Restrict to user's own blogs if not admin
            if (!auth()->user()->hasRole('admin')) {
                $query->where('author_id', auth()->id());
            }
            
            $blogs = $query->get();
            $count = $blogs->count();

            if ($count === 0) {
                return back()->with('error', 'No blogs found or you do not have permission to perform this action.');
            }

            switch ($request->action) {
                case 'publish':
                    $blogs->each(function ($blog) {
                        $blog->update([
                            'status' => 'published',
                            'published_at' => now(),
                            'scheduled_at' => null
                        ]);
                    });
                    $message = "{$count} blogs published successfully!";
                    break;
                    
                case 'unpublish':
                    $blogs->each(function ($blog) {
                        $blog->update([
                            'status' => 'draft',
                            'published_at' => null,
                            'scheduled_at' => null
                        ]);
                    });
                    $message = "{$count} blogs unpublished successfully!";
                    break;
                    
                case 'feature':
                    if (!auth()->user()->hasRole('admin')) {
                        return back()->with('error', 'Only admins can feature blogs.');
                    }
                    $blogs->each(function ($blog) {
                        $blog->update(['is_featured' => true]);
                    });
                    $message = "{$count} blogs featured successfully!";
                    break;
                    
                case 'unfeature':
                    if (!auth()->user()->hasRole('admin')) {
                        return back()->with('error', 'Only admins can unfeature blogs.');
                    }
                    $blogs->each(function ($blog) {
                        $blog->update(['is_featured' => false]);
                    });
                    $message = "{$count} blogs unfeatured successfully!";
                    break;
                    
                case 'delete':
                    foreach ($blogs as $blog) {
                        // Delete images
                        if ($blog->featured_image_path) {
                            Storage::disk('public')->delete($blog->featured_image_path);
                        }
                        if ($blog->social_image_path) {
                            Storage::disk('public')->delete($blog->social_image_path);
                        }
                        $blog->delete();
                    }
                    $message = "{$count} blogs deleted successfully!";
                    break;
            }

            return back()->with('success', $message);

        } catch (\Exception $e) {
            return back()->with('error', 'Bulk action failed: ' . $e->getMessage());
        }
    }

    /**
     * Upload images for blog content (AJAX)
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120'
        ]);

        try {
            $path = $request->file('image')->store('fitinsight/blogs/content', 'public');
            $url = asset('storage/app/public/' . $path);

            return response()->json([
                'success' => true,
                'url' => $url,
                'path' => $path
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload image: ' . $e->getMessage()
            ], 500);
        }
    }
} 