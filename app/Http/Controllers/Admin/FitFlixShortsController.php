<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFitFlixShortsRequest;
use App\Models\FitFlixShorts;
use App\Models\FitFlixShortsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class FitFlixShortsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = FitFlixShorts::with(['category', 'uploader']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->search($search);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            }
        }

        // Filter by featured
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === 'yes');
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        
        if (in_array($sortBy, ['title', 'views_count', 'created_at', 'published_at'])) {
            $query->orderBy($sortBy, $sortDirection);
        } else {
            $query->latest();
        }

        $shorts = $query->paginate(15);
        
        // Get categories for filter dropdown
        $categories = FitFlixShortsCategory::active()->ordered()->get();

        return view('admin.community.fitflix-shorts.index', compact('shorts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = FitFlixShortsCategory::active()->ordered()->get();
        return view('admin.community.fitflix-shorts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFitFlixShortsRequest $request)
    {
        try {
            $data = $request->validated();
            
            // Handle video file upload
            if ($request->hasFile('video_file')) {
                $videoFile = $request->file('video_file');
                $data['video_path'] = $videoFile->store('community/fitflix-shorts/videos', 'public');
                
                // Get video metadata
                $data['file_size'] = $videoFile->getSize();
                $data['video_format'] = $videoFile->getClientOriginalExtension();
                
                // Temporary metadata
                $data['video_width'] = 1080;
                $data['video_height'] = 1920;
                $data['duration'] = 60;
            }

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $data['thumbnail_path'] = $request->file('thumbnail')
                    ->store('community/fitflix-shorts/thumbnails', 'public');
            }

            // Generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['title']);
            }

            // Set uploader
            $data['uploaded_by'] = auth()->id();

            // ✅ Actually create record
            $shorts = FitFlixShorts::create($data);

            return redirect()->route('admin.community.fitflix-shorts.index')
                ->with('success', 'FitFlix Short created successfully!');

        } catch (\Exception $e) {
            Log::error('FitFlix Shorts creation failed: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Failed to create short. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FitFlixShorts $fitflix_short)
    {
        $fitflix_short->load(['category', 'uploader']);
        $categories = FitFlixShortsCategory::active()->ordered()->get();
        return view('admin.community.fitflix-shorts.show', compact('fitflix_short', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FitFlixShorts $fitflix_short)
    {
        $categories = FitFlixShortsCategory::active()->ordered()->get();
        return view('admin.community.fitflix-shorts.edit', compact('fitflix_short', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreFitFlixShortsRequest $request, FitFlixShorts $fitflix_short)
    {
        try {
            $data = $request->validated();

            // Remove file inputs from $data before update (not fillable)
            unset($data['video_file'], $data['thumbnail']);

            // Handle video file upload
            if ($request->hasFile('video_file')) {
                if ($fitflix_short->video_path) {
                    Storage::disk('public')->delete($fitflix_short->video_path);
                }

                $videoFile = $request->file('video_file');
                $data['video_path'] = $videoFile->store('community/fitflix-shorts/videos', 'public');

                $data['file_size'] = $videoFile->getSize();
                $data['video_format'] = $videoFile->getClientOriginalExtension();
                $data['video_width'] = 1080;
                $data['video_height'] = 1920;
                $data['duration'] = 60;
            }

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                if ($fitflix_short->thumbnail_path) {
                    Storage::disk('public')->delete($fitflix_short->thumbnail_path);
                }

                $data['thumbnail_path'] = $request->file('thumbnail')
                    ->store('community/fitflix-shorts/thumbnails', 'public');
            }

            // Generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['title']);
            }

            // Debug before saving
            // dd($data);

            $fitflix_short->fill($data);
            $fitflix_short->save();

            return redirect()->route('admin.community.fitflix-shorts.index')
                ->with('success', 'FitFlix Short updated successfully!');

        } catch (\Exception $e) {
            Log::error('FitFlix Shorts update failed: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Failed to update short. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FitFlixShorts $fitflix_short)
    {
        try {
            // Delete video file
            if ($fitflix_short->video_path) {
                Storage::disk('public')->delete($fitflix_short->video_path);
            }

            // Delete thumbnail
            if ($fitflix_short->thumbnail_path) {
                Storage::disk('public')->delete($fitflix_short->thumbnail_path);
            }

            $fitflix_short->delete();

            return redirect()->route('admin.community.fitflix-shorts.index')
                ->with('success', 'FitFlix Short deleted successfully!');

        } catch (\Exception $e) {
            Log::error('FitFlix Shorts deletion failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete short. Please try again.');
        }
    }

    /**
     * Toggle publication status
     */
    public function togglePublished(FitFlixShorts $fitflix_short)
    {
        try {
            $fitflix_short->update([
                'is_published' => !$fitflix_short->is_published,
                'published_at' => !$fitflix_short->is_published ? now() : null,
            ]);

            $status = $fitflix_short->is_published ? 'published' : 'unpublished';
            
            return response()->json([
                'success' => true,
                'message' => "Short {$status} successfully!",
                'is_published' => $fitflix_short->is_published
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update publication status.'
            ], 500);
        }
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(FitFlixShorts $fitflix_short)
    {
        try {
            $fitflix_short->update([
                'is_featured' => !$fitflix_short->is_featured
            ]);

            $status = $fitflix_short->is_featured ? 'featured' : 'unfeatured';
            
            return response()->json([
                'success' => true,
                'message' => "Short {$status} successfully!",
                'is_featured' => $fitflix_short->is_featured
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update featured status.'
            ], 500);
        }
    }
} 