<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FgSeries;
use App\Models\FgSeriesEpisode;
use App\Models\FgCategory;
use App\Models\FgSubCategory;
use App\Http\Requests\StoreFgSeriesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FgSeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->get('search');
        $categoryFilter = $request->get('category');
        $statusFilter = $request->get('status');

        $series = FgSeries::with(['category', 'subCategory'])
            ->withCount('episodes')
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

        return view('admin.fitguide.series.index', compact('series', 'categories', 'query', 'categoryFilter', 'statusFilter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = FgCategory::active()->ordered()->get();
        return view('admin.fitguide.series.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFgSeriesRequest $request)
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

            $series = FgSeries::create($data);

            // Handle episodes if provided
            if ($request->has('episodes') && is_array($request->input('episodes'))) {
                $this->storeEpisodes($series, $request->input('episodes'), $request);
            }

            DB::commit();
            return redirect()->route('admin.fitguide.series.index')
                ->with('success', 'Series created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('FgSeries creation failed: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FgSeries $fgSeries)
    {
        $fgSeries->load(['category', 'subCategory', 'episodes' => function ($query) {
            $query->orderBy('episode_number');
        }]);
        
        return view('admin.fitguide.series.show', compact('fgSeries'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FgSeries $fgSeries)
    {
        $categories = FgCategory::active()->ordered()->get();
        $subCategories = FgSubCategory::where('fg_category_id', $fgSeries->fg_category_id)->active()->ordered()->get();
        $fgSeries->load(['episodes' => function ($query) {
            $query->orderBy('episode_number');
        }]);
        
        return view('admin.fitguide.series.edit', compact('fgSeries', 'categories', 'subCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreFgSeriesRequest $request, FgSeries $fgSeries)
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
                if ($fgSeries->banner_image_path) {
                    Storage::disk('public')->delete($fgSeries->banner_image_path);
                }
                $data['banner_image_path'] = $request->file('banner_image_path')->store('fitguide/banners', 'public');
            }

            // Handle trailer upload
            if ($request->input('trailer_type') === 'upload' && $request->hasFile('trailer_file_path')) {
                if ($fgSeries->trailer_file_path) {
                    Storage::disk('public')->delete($fgSeries->trailer_file_path);
                }
                $data['trailer_file_path'] = $request->file('trailer_file_path')->store('fitguide/trailers', 'public');
            } elseif ($request->input('trailer_type') !== 'upload') {
                $data['trailer_file_path'] = null;
            }

            $fgSeries->update($data);

            DB::commit();
            return redirect()->route('admin.fitguide.series.index')
                ->with('success', 'Series updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('FgSeries update failed: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FgSeries $fgSeries)
    {
        try {
            // Delete associated files
            if ($fgSeries->banner_image_path) {
                Storage::disk('public')->delete($fgSeries->banner_image_path);
            }
            if ($fgSeries->trailer_file_path) {
                Storage::disk('public')->delete($fgSeries->trailer_file_path);
            }

            // Delete episode files
            foreach ($fgSeries->episodes as $episode) {
                if ($episode->video_file_path) {
                    Storage::disk('public')->delete($episode->video_file_path);
                }
            }

            $fgSeries->delete(); // Episodes will be deleted via cascade

            return redirect()->route('admin.fitguide.series.index')
                ->with('success', 'Series deleted successfully.');

        } catch (\Exception $e) {
            Log::error('FgSeries deletion failed: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Toggle the published status of the series.
     */
    public function toggleStatus(FgSeries $fgSeries)
    {
        try {
            $fgSeries->update(['is_published' => !$fgSeries->is_published]);

            $status = $fgSeries->is_published ? 'published' : 'unpublished';
            return response()->json([
                'success' => true,
                'message' => "Series {$status} successfully.",
                'is_published' => $fgSeries->is_published
            ]);

        } catch (\Exception $e) {
            Log::error('FgSeries status toggle failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    /**
     * Display episodes for a series.
     */
    public function episodes(FgSeries $fgSeries)
    {
        $episodes = $fgSeries->episodes()->orderBy('episode_number')->paginate(10);
        return view('admin.fitguide.series.episodes', compact('fgSeries', 'episodes'));
    }

    /**
     * Show form for creating a new episode.
     */
    public function createEpisode(FgSeries $fgSeries)
    {
        $nextEpisodeNumber = $fgSeries->episodes()->max('episode_number') + 1;
        return view('admin.fitguide.series.episode-create', compact('fgSeries', 'nextEpisodeNumber'));
    }

    /**
     * Store a new episode.
     */
    public function storeEpisode(Request $request, FgSeries $fgSeries)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'episode_number' => 'required|integer|min:1|unique:fg_series_episodes,episode_number,NULL,id,fg_series_id,' . $fgSeries->id,
            'duration_minutes' => 'nullable|integer|min:1',
            'video_type' => 'required|in:youtube,s3,upload',
            'video_url' => 'nullable|required_if:video_type,youtube,s3|url',
            'video_file_path' => 'nullable|required_if:video_type,upload|file|mimes:mp4,mov,avi,wmv,flv,webm|max:512000',
            'is_published' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['fg_series_id'] = $fgSeries->id;
            $data['is_published'] = $request->has('is_published');

            if ($request->input('video_type') === 'upload' && $request->hasFile('video_file_path')) {
                $data['video_file_path'] = $request->file('video_file_path')->store('fitguide/episodes', 'public');
            }

            FgSeriesEpisode::create($data);

            DB::commit();
            return redirect()->route('admin.fitguide.series.episodes', $fgSeries)
                ->with('success', 'Episode created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Episode creation failed: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Show form for editing an episode.
     */
    public function editEpisode(FgSeries $fgSeries, FgSeriesEpisode $episode)
    {
        return view('admin.fitguide.series.episode-edit', compact('fgSeries', 'episode'));
    }

    /**
     * Update an episode.
     */
    public function updateEpisode(Request $request, FgSeries $fgSeries, FgSeriesEpisode $episode)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'episode_number' => 'required|integer|min:1|unique:fg_series_episodes,episode_number,' . $episode->id . ',id,fg_series_id,' . $fgSeries->id,
            'duration_minutes' => 'nullable|integer|min:1',
            'video_type' => 'required|in:youtube,s3,upload',
            'video_url' => 'nullable|required_if:video_type,youtube,s3|url',
            'video_file_path' => 'nullable|required_if:video_type,upload|file|mimes:mp4,mov,avi,wmv,flv,webm|max:512000',
            'is_published' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['is_published'] = $request->has('is_published');

            if ($request->input('video_type') === 'upload' && $request->hasFile('video_file_path')) {
                if ($episode->video_file_path) {
                    Storage::disk('public')->delete($episode->video_file_path);
                }
                $data['video_file_path'] = $request->file('video_file_path')->store('fitguide/episodes', 'public');
            } elseif ($request->input('video_type') !== 'upload') {
                $data['video_file_path'] = null;
            }

            $episode->update($data);

            DB::commit();
            return redirect()->route('admin.fitguide.series.episodes', $fgSeries)
                ->with('success', 'Episode updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Episode update failed: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Delete an episode.
     */
    public function destroyEpisode(FgSeries $fgSeries, FgSeriesEpisode $episode)
    {
        try {
            if ($episode->video_file_path) {
                Storage::disk('public')->delete($episode->video_file_path);
            }

            $episode->delete();

            return redirect()->route('admin.fitguide.series.episodes', $fgSeries)
                ->with('success', 'Episode deleted successfully.');

        } catch (\Exception $e) {
            Log::error('Episode deletion failed: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Toggle episode status.
     */
    public function toggleEpisodeStatus(FgSeries $fgSeries, FgSeriesEpisode $episode)
    {
        try {
            $episode->update(['is_published' => !$episode->is_published]);

            $status = $episode->is_published ? 'published' : 'unpublished';
            return response()->json([
                'success' => true,
                'message' => "Episode {$status} successfully.",
                'is_published' => $episode->is_published
            ]);

        } catch (\Exception $e) {
            Log::error('Episode status toggle failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    /**
     * Store episodes for a series.
     */
    private function storeEpisodes(FgSeries $series, array $episodes, Request $request)
    {
        foreach ($episodes as $index => $episodeData) {
            $data = [
                'fg_series_id' => $series->id,
                'title' => $episodeData['title'],
                'description' => $episodeData['description'] ?? null,
                'episode_number' => $episodeData['episode_number'],
                'duration_minutes' => $episodeData['duration_minutes'] ?? null,
                'video_type' => $episodeData['video_type'],
                'video_url' => $episodeData['video_url'] ?? null,
                'is_published' => isset($episodeData['is_published']) ? (bool) $episodeData['is_published'] : false,
            ];

            if ($episodeData['video_type'] === 'upload' && $request->hasFile("episodes.{$index}.video_file_path")) {
                $data['video_file_path'] = $request->file("episodes.{$index}.video_file_path")->store('fitguide/episodes', 'public');
            }

            FgSeriesEpisode::create($data);
        }
    }
}
