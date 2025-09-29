<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunityCategory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class CommunityCategoryController extends Controller
{
    /**
     * Display listing of categories
     */
    public function index()
    {
        $categories = CommunityCategory::withCount(['posts', 'groups'])
            ->orderBy('order')
            ->paginate(20);

        return view('admin.community.categories.index', compact('categories'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.community.categories.create');
    }

    /**
     * Store new category
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:community_categories',
            'description' => 'nullable|string|max:500',
            'color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
            'icon' => 'required|string|max:50',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        try {
            $category = CommunityCategory::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'color' => $request->color,
                'icon' => $request->icon,
                'is_active' => $request->boolean('is_active', true),
                'order' => $request->order ?? CommunityCategory::max('order') + 1,
            ]);

            return redirect()->route('admin.community.categories.index')
                ->with('success', 'Category created successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating category: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display category details
     */
    public function show(CommunityCategory $category)
    {
        $category->load(['posts' => function($query) {
            $query->latest()->take(10);
        }, 'groups' => function($query) {
            $query->latest()->take(10);
        }]);

        $stats = [
            'total_posts' => $category->posts()->count(),
            'total_groups' => $category->groups()->count(),
            'posts_this_month' => $category->posts()
                ->where('created_at', '>=', now()->startOfMonth())
                ->count(),
            'active_groups' => $category->groups()
                ->where('is_active', true)
                ->count(),
        ];

        return view('admin.community.categories.show', compact('category', 'stats'));
    }

    /**
     * Show edit form
     */
    public function edit(CommunityCategory $category)
    {
        return view('admin.community.categories.edit', compact('category'));
    }

    /**
     * Update category
     */
    public function update(Request $request, CommunityCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:community_categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
            'color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
            'icon' => 'required|string|max:50',
            'is_active' => 'required|string',
            'order' => 'nullable|integer|min:0',
        ]);

        if($request->is_active == 'on'){
            $request->is_active = 1;
        } else {
            $request->is_active = 0;
        }

        try {
            $category->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'color' => $request->color,
                'icon' => $request->icon,
                'is_active' => $request->boolean('is_active', true),
                'order' => $request->order ?? $category->order,
            ]);

            return redirect()->route('admin.community.categories.index')
                ->with('success', 'Category updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating category: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete category
     */
    public function destroy(CommunityCategory $category)
    {
        try {
            // Check if category has posts or groups
            if ($category->posts()->count() > 0) {
                return redirect()->route('admin.community.categories.index')
                    ->with('error', 'Cannot delete category with existing posts. Move posts to another category first.');
            }

            if ($category->groups()->count() > 0) {
                return redirect()->route('admin.community.categories.index')
                    ->with('error', 'Cannot delete category with existing groups. Move groups to another category first.');
            }

            $category->delete();

            return redirect()->route('admin.community.categories.index')
                ->with('success', 'Category deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->route('admin.community.categories.index')
                ->with('error', 'Error deleting category: ' . $e->getMessage());
        }
    }

    /**
     * Toggle category status
     */
    public function toggleStatus(CommunityCategory $category): JsonResponse
    {
        try {
            $category->update(['is_active' => !$category->is_active]);

            return response()->json([
                'success' => true,
                'message' => 'Category status updated successfully',
                'is_active' => $category->is_active,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating category status: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update category order
     */
    public function updateOrder(Request $request): JsonResponse
    {
        $request->validate([
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:community_categories,id',
            'categories.*.order' => 'required|integer|min:0',
        ]);

        try {
            foreach ($request->categories as $categoryData) {
                CommunityCategory::where('id', $categoryData['id'])
                    ->update(['order' => $categoryData['order']]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Category order updated successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating category order: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request): JsonResponse
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'categories' => 'required|array',
            'categories.*' => 'exists:community_categories,id',
        ]);

        try {
            $categories = CommunityCategory::whereIn('id', $request->categories);

            switch ($request->action) {
                case 'activate':
                    $categories->update(['is_active' => true]);
                    $message = 'Categories activated successfully';
                    break;

                case 'deactivate':
                    $categories->update(['is_active' => false]);
                    $message = 'Categories deactivated successfully';
                    break;

                case 'delete':
                    // Check if any category has posts or groups
                    $categoriesWithContent = $categories->withCount(['posts', 'groups'])
                        ->get()
                        ->filter(function($category) {
                            return $category->posts_count > 0 || $category->groups_count > 0;
                        });

                    if ($categoriesWithContent->count() > 0) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Cannot delete categories with existing posts or groups',
                        ], 400);
                    }

                    $categories->delete();
                    $message = 'Categories deleted successfully';
                    break;
            }

            return response()->json([
                'success' => true,
                'message' => $message,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error performing bulk action: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get categories for API (used in dropdowns)
     */
    public function apiIndex(): JsonResponse
    {
        $categories = CommunityCategory::where('is_active', true)
            ->orderBy('order')
            ->select('id', 'name', 'color', 'icon')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }
} 