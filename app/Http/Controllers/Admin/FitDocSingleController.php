<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFitDocRequest;
use App\Models\FitDoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FitDocSingleController extends Controller
{
    /**
     * Display a listing of single videos.
     */
    public function index(Request $request)
    {
        $query = FitDoc::where('type', 'single');

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by language
        if ($request->filled('language')) {
            $query->byLanguage($request->language);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->published();
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            }
        }

        $singles = $query->orderBy('created_at', 'desc')->paginate(12);

        // Get filter options
        $languages = FitDoc::where('type', 'single')->distinct()->pluck('language')->filter()->sort();

        return view('admin.fitdoc.single.index', compact('singles', 'languages'));
    }

    /**
     * Show the form for creating a new single video.
     */
    public function create()
    {
        return view('admin.fitdoc.single.create');
    }

    /**
     * Store a newly created single video.
     */
    public function store(StoreFitDocRequest $request)
    {
        // Debug logging
        \Log::info('=== FitDoc Single Store Method Called ===');
        \Log::info('Request method: ' . $request->method());
        \Log::info('Request URL: ' . $request->url());
        \Log::info('Request all data: ', $request->all());
        \Log::info('Request files: ', $request->allFiles());
        
        try {
            $data = $request->validated();
            \Log::info('Validated data: ', $data);
            
            $data['type'] = 'single'; // Force type to single

            // Handle banner image upload
            if ($request->hasFile('banner_image')) {
                $bannerPath = $request->file('banner_image')->store('fitdoc/banners', 'public');
                $data['banner_image_path'] = $bannerPath;
                \Log::info('FitDoc Single Store - Banner uploaded:', ['path' => $bannerPath]);
            }

            // Handle trailer upload
            if ($request->hasFile('trailer_file')) {
                $data['trailer_file_path'] = $request->file('trailer_file')->store('fitdoc/trailers', 'public');
            }

            // Handle video upload (required for single)
            if ($request->hasFile('video_file')) {
                $data['video_file_path'] = $request->file('video_file')->store('fitdoc/videos', 'public');
            }

            // Generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['title']);
            }

            // Create the single video
            $fitDoc = FitDoc::create($data);
            \Log::info('FitDoc created with ID: ' . $fitDoc->id);

            return redirect()->route('admin.fitdoc.single.index')
                           ->with('success', 'Single video created successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation Error: ', $e->errors());
            return redirect()->back()
                           ->withErrors($e->validator)
                           ->withInput()
                           ->with('error', 'Validation failed. Please check the form.');
        } catch (\Exception $e) {
            \Log::error('General Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error creating single video: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified single video.
     */
    public function show(FitDoc $fitDoc)
    {
        // Ensure it's a single video
        if ($fitDoc->type !== 'single') {
            return redirect()->route('admin.fitdoc.single.index')
                           ->with('error', 'This is not a single video.');
        }

        return view('admin.fitdoc.single.show', compact('fitDoc'));
    }

    /**
     * Show the form for editing the specified single video.
     */
    public function edit(FitDoc $fitDoc)
    {
        // Ensure it's a single video
        if ($fitDoc->type !== 'single') {
            return redirect()->route('admin.fitdoc.single.index')
                           ->with('error', 'This is not a single video.');
        }

        return view('admin.fitdoc.single.edit', compact('fitDoc'));
    }

    /**
     * Update the specified single video.
     */
    public function update(StoreFitDocRequest $request, FitDoc $fitDoc)
    {
        // Ensure it's a single video
        if ($fitDoc->type !== 'single') {
            return redirect()->route('admin.fitdoc.single.index')
                           ->with('error', 'This is not a single video.');
        }

        try {
            $data = $request->validated();
            $data['type'] = 'single'; // Force type to single

            // Handle banner image upload
            if ($request->hasFile('banner_image')) {
                // Delete old banner if exists
                if ($fitDoc->banner_image_path && Storage::disk('public')->exists($fitDoc->banner_image_path)) {
                    Storage::disk('public')->delete($fitDoc->banner_image_path);
                }
                $data['banner_image_path'] = $request->file('banner_image')->store('fitdoc/banners', 'public');
            }

            // Handle trailer upload
            if ($request->hasFile('trailer_file')) {
                // Delete old trailer if exists
                if ($fitDoc->trailer_file_path && Storage::disk('public')->exists($fitDoc->trailer_file_path)) {
                    Storage::disk('public')->delete($fitDoc->trailer_file_path);
                }
                $data['trailer_file_path'] = $request->file('trailer_file')->store('fitdoc/trailers', 'public');
            }

            // Handle video upload
            if ($request->hasFile('video_file')) {
                // Delete old video if exists
                if ($fitDoc->video_file_path && Storage::disk('public')->exists($fitDoc->video_file_path)) {
                    Storage::disk('public')->delete($fitDoc->video_file_path);
                }
                $data['video_file_path'] = $request->file('video_file')->store('fitdoc/videos', 'public');
            }

            // Update the single video
            $fitDoc->update($data);

            return redirect()->route('admin.fitdoc.single.index')
                           ->with('success', 'Single video updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error updating single video: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified single video.
     */
    public function destroy(FitDoc $fitDoc)
    {
        // Ensure it's a single video
        if ($fitDoc->type !== 'single') {
            return redirect()->route('admin.fitdoc.single.index')
                           ->with('error', 'This is not a single video.');
        }

        try {
            // Delete associated files
            if ($fitDoc->banner_image_path && Storage::disk('public')->exists($fitDoc->banner_image_path)) {
                Storage::disk('public')->delete($fitDoc->banner_image_path);
            }
            
            if ($fitDoc->trailer_file_path && Storage::disk('public')->exists($fitDoc->trailer_file_path)) {
                Storage::disk('public')->delete($fitDoc->trailer_file_path);
            }
            
            if ($fitDoc->video_file_path && Storage::disk('public')->exists($fitDoc->video_file_path)) {
                Storage::disk('public')->delete($fitDoc->video_file_path);
            }

            $fitDoc->delete();

            return redirect()->route('admin.fitdoc.single.index')
                           ->with('success', 'Single video deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error deleting single video: ' . $e->getMessage());
        }
    }

    /**
     * Toggle the published status of the specified single video.
     */
    public function toggleStatus(FitDoc $fitDoc)
    {
        // Ensure it's a single video
        if ($fitDoc->type !== 'single') {
            return response()->json([
                'success' => false,
                'message' => 'This is not a single video.'
            ], 400);
        }

        try {
            $fitDoc->update(['is_published' => !$fitDoc->is_published]);

            $status = $fitDoc->is_published ? 'published' : 'unpublished';
            
            return response()->json([
                'success' => true,
                'message' => "Single video {$status} successfully!",
                'is_published' => $fitDoc->is_published
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
    }
}
