<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFitDocRequest;
use App\Models\FitDoc;
use App\Models\FitDocEpisode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FitDocController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get statistics
        $totalContent = FitDoc::count();
        $singleVideos = FitDoc::where('type', 'single')->count();
        $seriesCount = FitDoc::where('type', 'series')->count();
        $totalEpisodes = FitDocEpisode::count();

        // Get recent content (last 6 items)
        $recentContent = FitDoc::orderBy('created_at', 'desc')
                              ->limit(6)
                              ->get();

        return view('admin.fitdoc.index', compact(
            'totalContent', 
            'singleVideos', 
            'seriesCount', 
            'totalEpisodes', 
            'recentContent'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.fitdoc.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFitDocRequest $request)
    {
        try {
            $data = $request->validated();

            // Debug logging
            \Log::info('FitDoc Store - Request files:', $request->allFiles());
            \Log::info('FitDoc Store - Has banner_image:', [$request->hasFile('banner_image')]);

            // Handle banner image upload
            if ($request->hasFile('banner_image')) {
                $bannerPath = $request->file('banner_image')->store('fitdoc/banners', 'public');
                $data['banner_image_path'] = $bannerPath;
                \Log::info('FitDoc Store - Banner uploaded:', ['path' => $bannerPath]);
            }

            // Handle trailer upload
            if ($request->hasFile('trailer_file')) {
                $data['trailer_file_path'] = $request->file('trailer_file')->store('fitdoc/trailers', 'public');
            }

            // Handle video upload (for single type)
            if ($request->hasFile('video_file')) {
                $data['video_file_path'] = $request->file('video_file')->store('fitdoc/videos', 'public');
            }

            // Generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['title']);
            }

            \Log::info('FitDoc Store - Data before create:', $data);

            // Create the FitDoc
            $fitDoc = FitDoc::create($data);

            \Log::info('FitDoc Store - Created FitDoc:', ['id' => $fitDoc->id, 'banner_image_path' => $fitDoc->banner_image_path]);

            return redirect()->route('admin.fitdoc.index')
                           ->with('success', 'FitDoc content created successfully!');

        } catch (\Exception $e) {
            \Log::error('FitDoc Store - Error:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error creating FitDoc: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FitDoc $fitDoc)
    {
        $fitDoc->load(['episodes' => function ($query) {
            $query->orderBy('episode_number');
        }]);

        return view('admin.fitdoc.show', compact('fitDoc'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FitDoc $fitDoc)
    {
        return view('admin.fitdoc.edit', compact('fitDoc'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreFitDocRequest $request, FitDoc $fitDoc)
    {
        try {
            $data = $request->validated();

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

            // Handle video upload (for single type)
            if ($request->hasFile('video_file')) {
                // Delete old video if exists
                if ($fitDoc->video_file_path && Storage::disk('public')->exists($fitDoc->video_file_path)) {
                    Storage::disk('public')->delete($fitDoc->video_file_path);
                }
                $data['video_file_path'] = $request->file('video_file')->store('fitdoc/videos', 'public');
            }

            // Update the FitDoc
            $fitDoc->update($data);

            return redirect()->route('admin.fitdoc.index')
                           ->with('success', 'FitDoc content updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error updating FitDoc: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FitDoc $fitDoc)
    {
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

            // Delete episodes and their files
            foreach ($fitDoc->episodes as $episode) {
                if ($episode->video_file_path && Storage::disk('public')->exists($episode->video_file_path)) {
                    Storage::disk('public')->delete($episode->video_file_path);
                }
            }

            $fitDoc->delete();

            return redirect()->route('admin.fitdoc.index')
                           ->with('success', 'FitDoc content deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error deleting FitDoc: ' . $e->getMessage());
        }
    }

    /**
     * Toggle the published status of the specified resource.
     */
    public function toggleStatus(FitDoc $fitDoc)
    {
        try {
            $fitDoc->update(['is_published' => !$fitDoc->is_published]);

            $status = $fitDoc->is_published ? 'published' : 'unpublished';
            
            return response()->json([
                'success' => true,
                'message' => "FitDoc {$status} successfully!",
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
            return redirect()->route('admin.fitdoc.show', $fitDoc)
                           ->with('error', 'Episodes are only available for series content.');
        }

        $episodes = $fitDoc->episodes()->orderBy('episode_number')->paginate(20);

        return view('admin.fitdoc.episodes', compact('fitDoc', 'episodes'));
    }

    /**
     * Show the form for creating a new episode.
     */
    public function createEpisode(FitDoc $fitDoc)
    {
        if ($fitDoc->type !== 'series') {
            return redirect()->route('admin.fitdoc.show', $fitDoc)
                           ->with('error', 'Episodes can only be added to series content.');
        }

        $nextEpisodeNumber = $fitDoc->episodes()->max('episode_number') + 1;

        return view('admin.fitdoc.episode-create', compact('fitDoc', 'nextEpisodeNumber'));
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

            return redirect()->route('admin.fitdoc.episodes', $fitDoc)
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
        return view('admin.fitdoc.episode-edit', compact('fitDoc', 'episode'));
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

            return redirect()->route('admin.fitdoc.episodes', $fitDoc)
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

            return redirect()->route('admin.fitdoc.episodes', $fitDoc)
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

    /**
     * Get dashboard stats for FitDoc.
     */
    public function stats()
    {
        $stats = [
            'total_content' => FitDoc::count(),
            'published_content' => FitDoc::published()->count(),
            'draft_content' => FitDoc::where('is_published', false)->count(),
            'single_videos' => FitDoc::byType('single')->count(),
            'series_count' => FitDoc::byType('series')->count(),
            'total_episodes' => FitDocEpisode::count(),
            'published_episodes' => FitDocEpisode::published()->count(),
            'recent_content' => FitDoc::orderBy('created_at', 'desc')->limit(5)->get(),
        ];

        return response()->json($stats);
    }
}
