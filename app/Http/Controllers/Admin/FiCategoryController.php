<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFiCategoryRequest;
use App\Models\FiCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FiCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = FiCategory::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'sort_order');
        $sortDirection = $request->get('sort_direction', 'asc');
        
        if (in_array($sortBy, ['name', 'sort_order', 'created_at', 'blogs_count'])) {
            if ($sortBy === 'blogs_count') {
                $query->withCount('blogs')->orderBy('blogs_count', $sortDirection);
            } else {
                $query->orderBy($sortBy, $sortDirection);
            }
        } else {
            $query->orderBySort();
        }

        $categories = $query->withCount(['blogs', 'publishedBlogs'])->paginate(15);

        return view('admin.fitinsight.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.fitinsight.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFiCategoryRequest $request)
    {
        try {
            $data = $request->validated();

            // Handle banner image upload
            if ($request->hasFile('banner_image')) {
                $data['banner_image_path'] = $request->file('banner_image')
                    ->store('fitinsight/categories/banners', 'public');
            }

            $category = FiCategory::create($data);

            return redirect()
                ->route('admin.fitinsight.categories.index')
                ->with('success', 'Category created successfully!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create category: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FiCategory $fiCategory)
    {
        $fiCategory->loadCount(['blogs', 'publishedBlogs']);

        $category = $fiCategory;
        
        // Get recent blogs in this category
        $recentBlogs = $fiCategory->blogs()
            ->with('author')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.fitinsight.categories.show', compact('category', 'recentBlogs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FiCategory $fiCategory)
    {
        $category = $fiCategory;
        return view('admin.fitinsight.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreFiCategoryRequest $request, FiCategory $fiCategory)
    {
        try {
            $data = $request->validated();

            // Handle banner image upload
            if ($request->hasFile('banner_image')) {
                // Delete old image if exists
                if ($fiCategory->banner_image_path) {
                    Storage::disk('public')->delete($fiCategory->banner_image_path);
                }
                
                $data['banner_image_path'] = $request->file('banner_image')
                    ->store('fitinsight/categories/banners', 'public');
            }

            $fiCategory->update($data);

            return redirect()
                ->route('admin.fitinsight.categories.index')
                ->with('success', 'Category updated successfully!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update category: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FiCategory $fiCategory)
    {
        try {
            // Check if category can be deleted
            if (!$fiCategory->canBeDeleted()) {
                return back()->with('error', 'Cannot delete category that contains blogs. Please move or delete the blogs first.');
            }

            // Delete banner image if exists
            if ($fiCategory->banner_image_path) {
                Storage::disk('public')->delete($fiCategory->banner_image_path);
            }

            $fiCategory->delete();

            return redirect()
                ->route('admin.fitinsight.categories.index')
                ->with('success', 'Category deleted successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete category: ' . $e->getMessage());
        }
    }

    /**
     * Toggle category status (active/inactive)
     */
    public function toggleStatus(FiCategory $fiCategory)
    {
        try {
            $fiCategory->update(['is_active' => !$fiCategory->is_active]);
            
            $status = $fiCategory->is_active ? 'activated' : 'deactivated';
            
            return response()->json([
                'success' => true,
                'message' => "Category {$status} successfully!",
                'status' => $fiCategory->is_active
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update category status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk actions for categories
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:fi_categories,id'
        ]);

        try {
            $categories = FiCategory::whereIn('id', $request->categories);
            $count = $categories->count();

            switch ($request->action) {
                case 'activate':
                    $categories->update(['is_active' => true]);
                    $message = "{$count} categories activated successfully!";
                    break;
                    
                case 'deactivate':
                    $categories->update(['is_active' => false]);
                    $message = "{$count} categories deactivated successfully!";
                    break;
                    
                case 'delete':
                    // Check if any category has blogs
                    $categoriesWithBlogs = $categories->withCount('blogs')
                        ->having('blogs_count', '>', 0)
                        ->count();
                    
                    if ($categoriesWithBlogs > 0) {
                        return back()->with('error', 'Cannot delete categories that contain blogs.');
                    }
                    
                    // Delete banner images
                    $categoriesToDelete = $categories->get();
                    foreach ($categoriesToDelete as $category) {
                        if ($category->banner_image_path) {
                            Storage::disk('public')->delete($category->banner_image_path);
                        }
                    }
                    
                    $categories->delete();
                    $message = "{$count} categories deleted successfully!";
                    break;
            }

            return back()->with('success', $message);

        } catch (\Exception $e) {
            return back()->with('error', 'Bulk action failed: ' . $e->getMessage());
        }
    }
}
