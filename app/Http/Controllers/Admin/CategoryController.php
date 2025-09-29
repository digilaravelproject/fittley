<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount([
                'subCategories as sub_categories_count',
                'fitLiveSessions as fit_live_sessions_count'
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.fitlive.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.fitlive.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category = Category::create($data);

        return redirect()->route('admin.fitlive.categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load(['subCategories', 'fitLiveSessions' => function ($query) {
            $query->latest()->limit(10);
        }]);

        return view('admin.fitlive.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.fitlive.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category->update($data);

        return redirect()->route('admin.fitlive.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // if ($category->fitLiveSessions()->count() > 0) {
        //     return redirect()->route('admin.fitlive.categories.index')
        //         ->with('error', 'Cannot delete category with existing sessions.');
        // }

        $category->delete();

        return redirect()->route('admin.fitlive.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
