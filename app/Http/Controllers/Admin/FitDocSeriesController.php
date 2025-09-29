<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFitDocRequest;
use App\Models\FitDoc;
use App\Models\FitDocEpisode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FitDocSeriesController extends Controller
{
    /**
     * Display a listing of series.
     */
    public function index(Request $request)
    {
        $query = FitDoc::where('type', 'series');

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

        $series = $query->withCount('episodes')
                        ->orderBy('created_at', 'desc')
                        ->paginate(12);

        return view('admin.fitdoc.series.index', compact('series'));
    }

    /**
     * Show the form for creating a new series.
     */
    public function create()
    {
        return view('admin.fitdoc.series.create');
    }

    /**
     * Store a newly created series.
     */
    public function store(StoreFitDocRequest $request)
    {
        try {
            $data = $request->validated();
            $data['type'] = 'series'; // Force type to series

            // Handle banner image upload
            if ($request->hasFile('banner_image')) {
                $data['banner_image_path'] = $request->file('banner_image')->store('fitdoc/banners', 'public');
            }

            // Handle trailer upload
            if ($request->hasFile('trailer_file')) {
                $data['trailer_file_path'] = $request->file('trailer_file')->store('fitdoc/trailers', 'public');
            }

            // Generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['title']);
            }

            // Create the series
            $fitDoc = FitDoc::create($data);

            return redirect()->route('admin.fitdoc.series.index')
                           ->with('success', 'Series created successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error creating series: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified series.
     */
    public function show(FitDoc $fitDoc)
    {
        // Ensure it's a series
        if ($fitDoc->type !== 'series') {
            return redirect()->route('admin.fitdoc.series.index')
                           ->with('error', 'This is not a series.');
        }

        $fitDoc->load(['episodes' => function ($query) {
            $query->orderBy('episode_number');
        }]);

        return view('admin.fitdoc.series.show', compact('fitDoc'));
    }

    /**
     * Show the form for editing the specified series.
     */
    public function edit(FitDoc $fitDoc)
    {
        // Ensure it's a series
        if ($fitDoc->type !== 'series') {
            return redirect()->route('admin.fitdoc.series.index')
                           ->with('error', 'This is not a series.');
        }

        return view('admin.fitdoc.series.edit', compact('fitDoc'));
    }

    /**
     * Update the specified series.
     */
    public function update(StoreFitDocRequest $request, FitDoc $fitDoc)
    {
        // Ensure it's a series
        if ($fitDoc->type !== 'series') {
            return redirect()->route('admin.fitdoc.series.index')
                           ->with('error', 'This is not a series.');
        }

        try {
            $data = $request->validated();
            $data['type'] = 'series'; // Force type to series

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

            // Update the series
            $fitDoc->update($data);

            return redirect()->route('admin.fitdoc.series.index')
                           ->with('success', 'Series updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error updating series: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified series.
     */
    public function destroy(FitDoc $fitDoc)
    {
        // Ensure it's a series
        if ($fitDoc->type !== 'series') {
            return redirect()->route('admin.fitdoc.series.index')
                           ->with('error', 'This is not a series.');
        }

        try {
            // Delete associated files
            if ($fitDoc->banner_image_path && Storage::disk('public')->exists($fitDoc->banner_image_path)) {
                Storage::disk('public')->delete($fitDoc->banner_image_path);
            }
            
            if ($fitDoc->trailer_file_path && Storage::disk('public')->exists($fitDoc->trailer_file_path)) {
                Storage::disk('public')->delete($fitDoc->trailer_file_path);
            }

            // Delete episodes and their files
            foreach ($fitDoc->episodes as $episode) {
                if ($episode->video_file_path && Storage::disk('public')->exists($episode->video_file_path)) {
                    Storage::disk('public')->delete($episode->video_file_path);
                }
            }

            $fitDoc->delete();

            return redirect()->route('admin.fitdoc.series.index')
                           ->with('success', 'Series deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error deleting series: ' . $e->getMessage());
        }
    }

    /**
     * Toggle the published status of the specified series.
     */
    public function toggleStatus(FitDoc $fitDoc)
    {
        // Ensure it's a series
        if ($fitDoc->type !== 'series') {
            return response()->json([
                'success' => false,
                'message' => 'This is not a series.'
            ], 400);
        }

        try {
            $fitDoc->update(['is_published' => !$fitDoc->is_published]);

            $status = $fitDoc->is_published ? 'published' : 'unpublished';
            
            return response()->json([
                'success' => true,
                'message' => "Series {$status} successfully!",
                'is_published' => $fitDoc->is_published
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display episodes for a series.
     */
    public function episodes(FitDoc $fitDoc)
    {
        if ($fitDoc->type !== 'series') {
            return redirect()->route('admin.fitdoc.series.index')
                           ->with('error', 'Episodes are only available for series content.');
        }

        $episodes = $fitDoc->episodes()->orderBy('episode_number')->paginate(20);
        $series = $fitDoc; // Alias for view consistency

        return view('admin.fitdoc.series.episodes', compact('series', 'episodes'));
    }

    /**
     * Show the form for creating a new episode.
     */
    public function createEpisode(FitDoc $fitDoc)
    {
        if ($fitDoc->type !== 'series') {
            return redirect()->route('admin.fitdoc.series.index')
                           ->with('error', 'Episodes can only be added to series content.');
        }

        $nextEpisodeNumber = $fitDoc->episodes()->max('episode_number') + 1;
        $series = $fitDoc; // Alias for view consistency

        return view('admin.fitdoc.series.episode-create', compact('series', 'nextEpisodeNumber'));
    }

    /**
     * Store a newly created episode.
     */
    public function storeEpisode(Request $request, FitDoc $fitDoc)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'episode_number' => 'required|integer|min:1|unique:fit_doc_episodes,episode_number,NULL,id,fit_doc_id,' . $fitDoc->id,
            'duration_minutes' => 'nullable|integer|min:1',
            'video_type' => 'required|in:youtube,s3,upload',
            'video_url' => 'nullable|string|max:500',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,webm|max:512000',
            'is_published' => 'boolean',
        ]);

        try {
            $data = $request->all();
            $data['fit_doc_id'] = $fitDoc->id;
            $data['slug'] = Str::slug($data['title']);

            // Handle video upload
            if ($request->hasFile('video_file')) {
                $data['video_file_path'] = $request->file('video_file')->store('fitdoc/episodes', 'public');
            }

            FitDocEpisode::create($data);

            return redirect()->route('admin.fitdoc.series.episodes', $fitDoc)
                           ->with('success', 'Episode created successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error creating episode: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing an episode.
     */
    public function editEpisode(FitDoc $fitDoc, FitDocEpisode $episode)
    {
        $series = $fitDoc; // Alias for view consistency
        return view('admin.fitdoc.series.episode-edit', compact('series', 'episode'));
    }

    /**
     * Update an episode.
     */
    public function updateEpisode(Request $request, FitDoc $fitDoc, FitDocEpisode $episode)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'episode_number' => 'required|integer|min:1|unique:fit_doc_episodes,episode_number,' . $episode->id . ',id,fit_doc_id,' . $fitDoc->id,
            'duration_minutes' => 'nullable|integer|min:1',
            'video_type' => 'required|in:youtube,s3,upload',
            'video_url' => 'nullable|string|max:500',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,webm|max:512000',
            'is_published' => 'boolean',
        ]);

        try {
            $data = $request->all();
            $data['slug'] = Str::slug($data['title']);

            // Handle video upload
            if ($request->hasFile('video_file')) {
                // Delete old video if exists
                if ($episode->video_file_path && Storage::disk('public')->exists($episode->video_file_path)) {
                    Storage::disk('public')->delete($episode->video_file_path);
                }
                $data['video_file_path'] = $request->file('video_file')->store('fitdoc/episodes', 'public');
            }

            $episode->update($data);

            return redirect()->route('admin.fitdoc.series.episodes', $fitDoc)
                           ->with('success', 'Episode updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error updating episode: ' . $e->getMessage());
        }
    }

    /**
     * Delete an episode.
     */
    public function destroyEpisode(FitDoc $fitDoc, FitDocEpisode $episode)
    {
        try {
            // Delete associated video file
            if ($episode->video_file_path && Storage::disk('public')->exists($episode->video_file_path)) {
                Storage::disk('public')->delete($episode->video_file_path);
            }

            $episode->delete();

            return redirect()->route('admin.fitdoc.series.episodes', $fitDoc)
                           ->with('success', 'Episode deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error deleting episode: ' . $e->getMessage());
        }
    }

    /**
     * Toggle episode status.
     */
    public function toggleEpisodeStatus(FitDoc $fitDoc, FitDocEpisode $episode)
    {
        try {
            $episode->update(['is_published' => !$episode->is_published]);

            $status = $episode->is_published ? 'published' : 'unpublished';
            
            return response()->json([
                'success' => true,
                'message' => "Episode {$status} successfully!",
                'is_published' => $episode->is_published
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating episode status: ' . $e->getMessage()
            ], 500);
        }
    }
}
