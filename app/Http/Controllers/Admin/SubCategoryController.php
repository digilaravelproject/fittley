<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Models\Category;
use App\Http\Requests\StoreSubCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
    public function show($id)
    {
        // Find the subCategory and eagerly load 'category' and 'fitLiveSessions'
        $subCategory = SubCategory::with('category', 'fitLiveSessions')->find($id);

        // If the subCategory is not found, return a view with null data
        if (!$subCategory) {
            return view('admin.fitlive.subcategories.show', [
                'subCategory' => null
            ]);
        }

        // Load related data (limit fitLiveSessions to the latest 10)
        $subCategory->load(['category', 'fitLiveSessions' => function ($query) {
            $query->latest()->take(10);
        }]);

        // Prepare data as needed (similar to 'show_old' method)
        $data = [
            'id' => $subCategory->id,
            'category' => $subCategory->category ? $subCategory->category->name : 'No Category',
            'name' => $subCategory->name,
            'slug' => $subCategory->slug,
            'sort_order' => $subCategory->sort_order,
            'created_at' => $subCategory->created_at ? $subCategory->created_at->format('Y-m-d H:i:s') : null,
            'updated_at' => $subCategory->updated_at ? $subCategory->updated_at->format('Y-m-d H:i:s') : null,
            'sessions_count' => $subCategory->fitLiveSessions->count(),
        ];

        // Return the view with the prepared data
        return view('admin.fitlive.subcategories.show', compact('data', 'subCategory'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit_old(SubCategory $subCategory)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.fitlive.subcategories.edit', compact('subCategory', 'categories'));
    }
    public function edit($id)
    {
        $subCategory = SubCategory::find($id);

        if (!$subCategory) {
            return redirect()->route('admin.fitlive.subcategories.index')->with('error', 'Sub-category not found.');
        }

        $categories = Category::orderBy('name')->get();
        return view('admin.fitlive.subcategories.edit', compact('subCategory', 'categories'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update_old(StoreSubCategoryRequest $request, SubCategory $subCategory)
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $subCategory->update($data);

        return redirect()->route('admin.fitlive.subcategories.index')
            ->with('success', 'Sub-category updated successfully.');
    }
    public function update(StoreSubCategoryRequest $request, $id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $data = $request->validated();

        // If the slug is empty or hasn't changed, we auto-generate it from the name
        if (empty($data['slug']) || $data['slug'] == $subCategory->slug) {
            // Auto-generate the slug based on the name
            $slug = Str::slug($data['name']);

            // Ensure the slug is unique by checking for existing slugs
            $originalSlug = $slug;
            $counter = 1;
            while (SubCategory::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            // Set the unique slug
            $data['slug'] = $slug;
        }

        // Update the sub-category with the validated data
        $subCategory->update($data);

        return redirect()->route('admin.fitlive.subcategories.index')
            ->with('success', 'Sub-category updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $subCategory = SubCategory::findOrFail($id);
        if ($subCategory->fitLiveSessions()->count() > 0) {
            return redirect()->route('admin.fitlive.subcategories.index')
                ->with('error', 'Cannot delete sub-category with existing sessions.');
        }

        $subCategory->delete();

        return redirect()->route('admin.fitlive.subcategories.index')
            ->with('success', 'Sub-category deleted successfully.');
    }
}
