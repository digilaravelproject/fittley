<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FgCategory;
use App\Models\FgSubCategory;
use App\Http\Requests\StoreFgSubCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FgSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categoryFilter = $request->get('category');
        
        $subCategories = FgSubCategory::with('category')
            ->withCount(['singles', 'series'])
            ->when($categoryFilter, function ($query) use ($categoryFilter) {
                $query->where('fg_category_id', $categoryFilter);
            })
            ->ordered()
            ->paginate(10);
            
        $categories = FgCategory::active()->ordered()->get();
        
        return view('admin.fitguide.subcategories.index', compact('subCategories', 'categories', 'categoryFilter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = FgCategory::active()->ordered()->get();
        return view('admin.fitguide.subcategories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFgSubCategoryRequest $request)
    {
        try {
            $data = $request->validated();
            $data['is_active'] = $request->has('is_active');
            
            FgSubCategory::create($data);
            
            return redirect()->route('admin.fitguide.subcategories.index')
                ->with('success', 'Subcategory created successfully.');
        } catch (\Exception $e) {
            Log::error('FgSubCategory creation failed: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FgSubCategory $fgSubCategory)
    {
        $fgSubCategory->load([
            'category',
            'singles' => function ($query) {
                $query->latest()->limit(5);
            },
            'series' => function ($query) {
                $query->latest()->limit(5);
            }
        ]);
        
        return view('admin.fitguide.subcategories.show', compact('fgSubCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FgSubCategory $fgSubCategory)
    {
        $categories = FgCategory::active()->ordered()->get();
        return view('admin.fitguide.subcategories.edit', compact('fgSubCategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreFgSubCategoryRequest $request, FgSubCategory $fgSubCategory)
    {
        try {
            $data = $request->validated();
            $data['is_active'] = $request->has('is_active');
            
            $fgSubCategory->update($data);
            
            return redirect()->route('admin.fitguide.subcategories.index')
                ->with('success', 'Subcategory updated successfully.');
        } catch (\Exception $e) {
            Log::error('FgSubCategory update failed: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FgSubCategory $fgSubCategory)
    {
        try {
            // Check if subcategory has singles or series
            $hasContent = $fgSubCategory->singles()->count() > 0 ||
                         $fgSubCategory->series()->count() > 0;
                         
            if ($hasContent) {
                return back()->with('error', 'Cannot delete subcategory that contains content.');
            }
            
            $fgSubCategory->delete();
            
            return redirect()->route('admin.fitguide.subcategories.index')
                ->with('success', 'Subcategory deleted successfully.');
        } catch (\Exception $e) {
            Log::error('FgSubCategory deletion failed: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Toggle the active status of the subcategory.
     */
    public function toggleStatus(FgSubCategory $fgSubCategory)
    {
        try {
            $fgSubCategory->update(['is_active' => !$fgSubCategory->is_active]);
            
            $status = $fgSubCategory->is_active ? 'activated' : 'deactivated';
            return response()->json([
                'success' => true,
                'message' => "Subcategory {$status} successfully.",
                'is_active' => $fgSubCategory->is_active
            ]);
        } catch (\Exception $e) {
            Log::error('FgSubCategory status toggle failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    /**
     * Get subcategories by category ID (AJAX endpoint).
     */
    public function getByCategory(FgCategory $category)
    {
        $subCategories = $category->subCategories()
            ->active()
            ->ordered()
            ->select('id', 'name')
            ->get();
            
        return response()->json($subCategories);
    }
}
