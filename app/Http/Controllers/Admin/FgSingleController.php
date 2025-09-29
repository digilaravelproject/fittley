<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FgSingle;
use App\Models\FgCategory;
use App\Models\FgSubCategory;
use App\Http\Requests\StoreFgSingleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FgSingleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->get('search');
        $categoryFilter = $request->get('category');
        $statusFilter = $request->get('status');

        $singles = FgSingle::with(['category', 'subCategory'])
            ->when($query, function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->when($categoryFilter, function ($q) use ($categoryFilter) {
                $q->where('fg_category_id', $categoryFilter);
            })
            ->when($statusFilter !== null, function ($q) use ($statusFilter) {
                $q->where('is_published', $statusFilter);
            })
            ->latest()
            ->paginate(10);

        $categories = FgCategory::active()->ordered()->get();

        return view('admin.fitguide.single.index', compact('singles', 'categories', 'query', 'categoryFilter', 'statusFilter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $categories = FgCategory::active()->ordered()->get();
        return view('admin.fitguide.single.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFgSingleRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['is_published'] = $request->has('is_published');
            
            // Handle empty subcategory selection
            if (empty($data['fg_sub_category_id'])) {
                $data['fg_sub_category_id'] = null;
            }

            // Handle banner image upload
            if ($request->hasFile('banner_image_path')) {
                $data['banner_image_path'] = $request->file('banner_image_path')->store('fitguide/banners', 'public');
            }

            // Handle trailer upload
            if ($request->input('trailer_type') === 'upload' && $request->hasFile('trailer_file_path')) {
                $data['trailer_file_path'] = $request->file('trailer_file_path')->store('fitguide/trailers', 'public');
            }

            // Handle main video upload
            if ($request->input('video_type') === 'upload' && $request->hasFile('video_file_path')) {
                $data['video_file_path'] = $request->file('video_file_path')->store('fitguide/videos', 'public');
            }

            FgSingle::create($data);

            DB::commit();
            return redirect()->route('admin.fitguide.single.index')
                ->with('success', 'Single video created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('FgSingle creation failed: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FgSingle $fgSingle)
    {
        $fgSingle->load(['category', 'subCategory']);
        return view('admin.fitguide.single.show', compact('fgSingle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FgSingle $fgSingle)
    {
        $categories = FgCategory::active()->ordered()->get();
        $subCategories = FgSubCategory::where('fg_category_id', $fgSingle->fg_category_id)->active()->ordered()->get();
        
        return view('admin.fitguide.single.edit', compact('fgSingle', 'categories', 'subCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreFgSingleRequest $request, FgSingle $fgSingle)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['is_published'] = $request->has('is_published');
            
            // Handle empty subcategory selection
            if (empty($data['fg_sub_category_id'])) {
                $data['fg_sub_category_id'] = null;
            }

            // Handle banner image upload
            if ($request->hasFile('banner_image_path')) {
                // Delete old banner if exists
                if ($fgSingle->banner_image_path) {
                    Storage::disk('public')->delete($fgSingle->banner_image_path);
                }
                $data['banner_image_path'] = $request->file('banner_image_path')->store('fitguide/banners', 'public');
            }

            // Handle trailer upload
            if ($request->input('trailer_type') === 'upload' && $request->hasFile('trailer_file_path')) {
                // Delete old trailer if exists
                if ($fgSingle->trailer_file_path) {
                    Storage::disk('public')->delete($fgSingle->trailer_file_path);
                }
                $data['trailer_file_path'] = $request->file('trailer_file_path')->store('fitguide/trailers', 'public');
            } elseif ($request->input('trailer_type') !== 'upload') {
                // Clear file path if switching from upload to URL
                $data['trailer_file_path'] = null;
            }

            // Handle main video upload
            if ($request->input('video_type') === 'upload' && $request->hasFile('video_file_path')) {
                // Delete old video if exists
                if ($fgSingle->video_file_path) {
                    Storage::disk('public')->delete($fgSingle->video_file_path);
                }
                $data['video_file_path'] = $request->file('video_file_path')->store('fitguide/videos', 'public');
            } elseif ($request->input('video_type') !== 'upload') {
                // Clear file path if switching from upload to URL
                $data['video_file_path'] = null;
            }

            $fgSingle->update($data);

            DB::commit();
            return redirect()->route('admin.fitguide.single.index')
                ->with('success', 'Single video updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('FgSingle update failed: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FgSingle $fgSingle)
    {
        try {
            // Delete associated files
            if ($fgSingle->banner_image_path) {
                Storage::disk('public')->delete($fgSingle->banner_image_path);
            }
            if ($fgSingle->trailer_file_path) {
                Storage::disk('public')->delete($fgSingle->trailer_file_path);
            }
            if ($fgSingle->video_file_path) {
                Storage::disk('public')->delete($fgSingle->video_file_path);
            }

            $fgSingle->delete();

            return redirect()->route('admin.fitguide.single.index')
                ->with('success', 'Single video deleted successfully.');

        } catch (\Exception $e) {
            Log::error('FgSingle deletion failed: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Toggle the published status of the single.
     */
    public function toggleStatus(FgSingle $fgSingle)
    {
        try {
            $fgSingle->update(['is_published' => !$fgSingle->is_published]);

            $status = $fgSingle->is_published ? 'published' : 'unpublished';
            return response()->json([
                'success' => true,
                'message' => "Single video {$status} successfully.",
                'is_published' => $fgSingle->is_published
            ]);

        } catch (\Exception $e) {
            Log::error('FgSingle status toggle failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }
}
