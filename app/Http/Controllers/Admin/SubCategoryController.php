<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Models\Category;
use App\Http\Requests\StoreSubCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subCategories = SubCategory::with('category')
            ->withCount('fitLiveSessions')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.fitlive.subcategories.index', compact('subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.fitlive.subcategories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubCategoryRequest $request)
    {
        $data = $request->validated();
        
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $subCategory = SubCategory::create($data);

        return redirect()->route('admin.fitlive.subcategories.index')
            ->with('success', 'Sub-category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategory $subCategory)
    {
        $subCategory->load(['category', 'fitLiveSessions' => function ($query) {
            $query->latest()->take(10);
        }]);

        return view('admin.fitlive.subcategories.show', compact('subCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategory $subCategory)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.fitlive.subcategories.edit', compact('subCategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSubCategoryRequest $request, SubCategory $subCategory)
    {
        $data = $request->validated();
        
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $subCategory->update($data);

        return redirect()->route('admin.fitlive.subcategories.index')
            ->with('success', 'Sub-category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subCategory)
    {
        if ($subCategory->fitLiveSessions()->count() > 0) {
            return redirect()->route('admin.fitlive.subcategories.index')
                ->with('error', 'Cannot delete sub-category with existing sessions.');
        }

        $subCategory->delete();

        return redirect()->route('admin.fitlive.subcategories.index')
            ->with('success', 'Sub-category deleted successfully.');
    }
}
