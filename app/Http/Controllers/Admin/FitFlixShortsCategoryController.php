<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFitFlixShortsCategoryRequest;
use App\Models\FitFlixShortsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FitFlixShortsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = FitFlixShortsCategory::query();

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
        
        if (in_array($sortBy, ['name', 'sort_order', 'created_at', 'shorts_count'])) {
            if ($sortBy === 'shorts_count') {
                $query->withCount('shorts')->orderBy('shorts_count', $sortDirection);
            } else {
                $query->orderBy($sortBy, $sortDirection);
            }
        } else {
            $query->ordered();
        }

        $categories = $query->withCount(['shorts', 'publishedShorts'])->paginate(15);

        return view('admin.community.fitflix-shorts.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.community.fitflix-shorts.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFitFlixShortsCategoryRequest $request)
    {
        try {
            $data = $request->validated();
            
            // Handle banner image upload
            if ($request->hasFile('banner_image')) {
                $data['banner_image_path'] = $request->file('banner_image')
                    ->store('community/fitflix-shorts/categories/banners', 'public');
            }

            // Generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            $category = FitFlixShortsCategory::create($data);

            return redirect()->route('admin.community.fitflix-shorts.categories.index')
                ->with('success', 'FitFlix Shorts category created successfully!');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to create category. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FitFlixShortsCategory $fitflix_shorts_category)
    {
        $fitflix_shorts_category->load(['shorts' => function ($query) {
            $query->latest()->limit(10);
        }]);

        $stats = [
            'total_shorts' => $fitflix_shorts_category->shorts()->count(),
            'published_shorts' => $fitflix_shorts_category->publishedShorts()->count(),
            'total_views' => $fitflix_shorts_category->shorts()->sum('views_count'),
            'recent_shorts' => $fitflix_shorts_category->shorts()->latest()->limit(5)->get(),
        ];

        return view('admin.community.fitflix-shorts.categories.show', compact('fitflix_shorts_category', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FitFlixShortsCategory $fitflix_shorts_category)
    {
        return view('admin.community.fitflix-shorts.categories.edit', compact('fitflix_shorts_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreFitFlixShortsCategoryRequest $request, FitFlixShortsCategory $fitflix_shorts_category)
    {
        try {
            $data = $request->validated();
            
            // Handle banner image upload
            if ($request->hasFile('banner_image')) {
                // Delete old banner image
                if ($fitflix_shorts_category->banner_image_path) {
                    Storage::disk('public')->delete($fitflix_shorts_category->banner_image_path);
                }
                
                $data['banner_image_path'] = $request->file('banner_image')
                    ->store('community/fitflix-shorts/categories/banners', 'public');
            }

            // Generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            $fitflix_shorts_category->update($data);

            return redirect()->route('admin.community.fitflix-shorts.categories.index')
                ->with('success', 'FitFlix Shorts category updated successfully!');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to update category. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FitFlixShortsCategory $fitflix_shorts_category)
    {
        try {
            // Check if category can be deleted
            if (!$fitflix_shorts_category->canBeDeleted()) {
                return back()->with('error', 'Cannot delete category that has shorts associated with it.');
            }

            // Delete banner image
            if ($fitflix_shorts_category->banner_image_path) {
                Storage::disk('public')->delete($fitflix_shorts_category->banner_image_path);
            }

            $fitflix_shorts_category->delete();

            return redirect()->route('admin.community.fitflix-shorts.categories.index')
                ->with('success', 'FitFlix Shorts category deleted successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete category. Please try again.');
        }
    }

    /**
     * Toggle category status
     */
    public function toggleStatus(FitFlixShortsCategory $fitflix_shorts_category)
    {
        try {
            $fitflix_shorts_category->update([
                'is_active' => !$fitflix_shorts_category->is_active
            ]);

            $status = $fitflix_shorts_category->is_active ? 'activated' : 'deactivated';
            
            return response()->json([
                'success' => true,
                'message' => "Category {$status} successfully!",
                'is_active' => $fitflix_shorts_category->is_active
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update category status.'
            ], 500);
        }
    }
} 