<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FgCategory;
use App\Http\Requests\StoreFgCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FgCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = FgCategory::withCount(['subCategories', 'singles', 'series'])
            ->ordered()
            ->paginate(10);
            
        return view('admin.fitguide.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.fitguide.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFgCategoryRequest $request)
    {
        try {
            $data = $request->validated();
            $data['is_active'] = $request->has('is_active');
            
            FgCategory::create($data);
            
            return redirect()->route('admin.fitguide.categories.index')
                ->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            Log::error('FgCategory creation failed: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FgCategory $fgCategory)
    {
        $fgCategory->load([
            'subCategories' => function ($query) {
                $query->withCount(['singles', 'series']);
            },
            'singles' => function ($query) {
                $query->latest()->limit(5);
            },
            'series' => function ($query) {
                $query->latest()->limit(5);
            }
        ]);
        
        return view('admin.fitguide.categories.show', compact('fgCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FgCategory $fgCategory)
    {
        return view('admin.fitguide.categories.edit', compact('fgCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreFgCategoryRequest $request, FgCategory $fgCategory)
    {
        try {
            $data = $request->validated();
            $data['is_active'] = $request->has('is_active');
            
            $fgCategory->update($data);
            
            return redirect()->route('admin.fitguide.categories.index')
                ->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            Log::error('FgCategory update failed: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FgCategory $fgCategory)
    {
        try {
            // Check if category has subcategories, singles, or series
            $hasContent = $fgCategory->subCategories()->count() > 0 ||
                         $fgCategory->singles()->count() > 0 ||
                         $fgCategory->series()->count() > 0;
                         
            if ($hasContent) {
                return back()->with('error', 'Cannot delete category that contains subcategories or content.');
            }
            
            $fgCategory->delete();
            
            return redirect()->route('admin.fitguide.categories.index')
                ->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            Log::error('FgCategory deletion failed: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Toggle the active status of the category.
     */
    public function toggleStatus(FgCategory $fgCategory)
    {
        try {
            $fgCategory->update(['is_active' => !$fgCategory->is_active]);
            
            $status = $fgCategory->is_active ? 'activated' : 'deactivated';
            return response()->json([
                'success' => true,
                'message' => "Category {$status} successfully.",
                'is_active' => $fgCategory->is_active
            ]);
        } catch (\Exception $e) {
            Log::error('FgCategory status toggle failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }
}
