<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\BaseApiController;
use App\Http\Resources\FitGuideResource;
use App\Http\Resources\FitGuideCollection;
use App\Models\FgSingle;
use App\Models\FgSeries;
use App\Models\FgCategory;
use App\Models\FgSeriesEpisode;
use Illuminate\Http\Request;

class FitGuideController extends BaseApiController
{
    public function index(Request $request)
    {
        try {
            // Get the selected category from the request
            $categorySlug = $request->input('category'); // This would be passed from the frontend

            // Get categories for the filter buttons
            $categories = FgCategory::where('is_active', true)
                ->orderBy('name')
                ->get();

            // If a category is selected, filter the content by category
            if ($categorySlug) {
                // Fetch the category based on the slug
                $category = FgCategory::where('slug', $categorySlug)->first();

                if ($category) {
                    // Filter content by category
                    $featuredSingles = FgSingle::where('is_published', true)
                        ->where('fg_category_id', $category->id)
                        ->with(['category', 'subCategory'])
                        ->latest()
                        ->take(3)
                        ->get();

                    $featuredSeries = FgSeries::where('is_published', true)
                        ->where('fg_category_id', $category->id)
                        ->with(['category', 'subCategory'])
                        ->latest()
                        ->take(3)
                        ->get();

                    // Fetch all singles and series for the selected category
                    $allSingles = FgSingle::where('is_published', true)
                        ->where('fg_category_id', $category->id)
                        ->with(['category', 'subCategory'])
                        ->latest()
                        ->get();

                    $allSeries = FgSeries::where('is_published', true)
                        ->where('fg_category_id', $category->id)
                        ->with(['category', 'subCategory'])
                        ->latest()
                        ->get();
                } else {
                    // If the category is not found, return all content (fallback)
                    $featuredSingles = FgSingle::where('is_published', true)
                        ->with(['category', 'subCategory'])
                        ->latest()
                        ->take(3)
                        ->get();

                    $featuredSeries = FgSeries::where('is_published', true)
                        ->with(['category', 'subCategory'])
                        ->latest()
                        ->take(3)
                        ->get();

                    $allSingles = FgSingle::where('is_published', true)
                        ->with(['category', 'subCategory'])
                        ->latest()
                        ->get();

                    $allSeries = FgSeries::where('is_published', true)
                        ->with(['category', 'subCategory'])
                        ->latest()
                        ->get();
                }
            } else {
                // If no category is selected, fetch all content
                $featuredSingles = FgSingle::where('is_published', true)
                    ->with(['category', 'subCategory'])
                    ->latest()
                    ->take(3)
                    ->get();

                $featuredSeries = FgSeries::where('is_published', true)
                    ->with(['category', 'subCategory'])
                    ->latest()
                    ->take(3)
                    ->get();

                $allSingles = FgSingle::where('is_published', true)
                    ->with(['category', 'subCategory'])
                    ->latest()
                    ->get();

                $allSeries = FgSeries::where('is_published', true)
                    ->with(['category', 'subCategory'])
                    ->latest()
                    ->get();
            }

            // Check if this is an API request
            if ($this->expectsJson($request)) {
                return $this->successResponse([
                    'featured_singles' => FitGuideResource::collection($featuredSingles),
                    'featured_series' => FitGuideResource::collection($featuredSeries),
                    'all_singles' => FitGuideResource::collection($allSingles),
                    'all_series' => FitGuideResource::collection($allSeries),
                    'categories' => $categories->map(function ($category) {
                        return [
                            'id' => $category->id,
                            'name' => $category->name,
                            'slug' => $category->slug ?? null,
                            'is_active' => $category->is_active,
                        ];
                    }),
                ], 'FitGuide content retrieved successfully');
            }

            // Return web view for browser requests
            return view('public.fitguide.index', compact('featuredSingles', 'featuredSeries', 'allSingles', 'allSeries', 'categories'));
        } catch (\Exception $e) {
            // Handle API errors
            if ($this->expectsJson($request)) {
                return $this->handleException($e);
            }

            // Return web view with error for browser requests
            return view('public.fitguide.index', [
                'featuredSingles' => collect(),
                'featuredSeries' => collect(),
                'allSingles' => collect(),
                'allSeries' => collect(),
                'categories' => collect(),
                'error' => $e->getMessage()
            ]);
        }
    }

    public function index_old(Request $request)
    {
        try {
            // Get featured content for index page (limited)
            $featuredSingles = FgSingle::where('is_published', true)
                ->with(['category', 'subCategory'])
                ->latest()
                ->take(3)
                ->get();

            $featuredSeries = FgSeries::where('is_published', true)
                ->with(['category', 'subCategory'])
                ->latest()
                ->take(3)
                ->get();

            // Get ALL published singles and series for full display
            $allSingles = FgSingle::where('is_published', true)
                ->with(['category', 'subCategory'])
                ->latest()
                ->get();

            $allSeries = FgSeries::where('is_published', true)
                ->with(['category', 'subCategory'])
                ->latest()
                ->get();

            $categories = FgCategory::where('is_active', true)
                ->orderBy('name')
                ->get();

            // Check if this is an API request
            if ($this->expectsJson($request)) {
                return $this->successResponse([
                    'featured_singles' => FitGuideResource::collection($featuredSingles),
                    'featured_series' => FitGuideResource::collection($featuredSeries),
                    'all_singles' => FitGuideResource::collection($allSingles),
                    'all_series' => FitGuideResource::collection($allSeries),
                    'categories' => $categories->map(function ($category) {
                        return [
                            'id' => $category->id,
                            'name' => $category->name,
                            'slug' => $category->slug ?? null,
                            'is_active' => $category->is_active,
                        ];
                    }),
                ], 'FitGuide content retrieved successfully');
            }

            // Return web view for browser requests
            return view('public.fitguide.index', compact('featuredSingles', 'featuredSeries', 'allSingles', 'allSeries', 'categories'));
        } catch (\Exception $e) {
            // Handle API errors
            if ($this->expectsJson($request)) {
                return $this->handleException($e);
            }

            // Return web view with error for browser requests
            return view('public.fitguide.index', [
                'featuredSingles' => collect(),
                'featuredSeries' => collect(),
                'allSingles' => collect(),
                'allSeries' => collect(),
                'categories' => collect(),
                'error' => $e->getMessage()
            ]);
        }
    }

    public function categories(Request $request)
    {
        try {
            $categories = FgCategory::where('is_active', true)
                ->withCount(['singles' => function ($query) {
                    $query->where('is_published', true);
                }])
                ->withCount(['series' => function ($query) {
                    $query->where('is_published', true);
                }])
                ->orderBy('name')
                ->get();

            // Check if this is an API request
            if ($this->expectsJson($request)) {
                return $this->successResponse(
                    $categories->map(function ($category) {
                        return [
                            'id' => $category->id,
                            'name' => $category->name,
                            'slug' => $category->slug ?? null,
                            'is_active' => $category->is_active,
                            'singles_count' => $category->singles_count,
                            'series_count' => $category->series_count,
                            'total_content' => $category->singles_count + $category->series_count,
                        ];
                    }),
                    'FitGuide categories retrieved successfully'
                );
            }

            // Return web view for browser requests
            return view('public.fitguide.categories', compact('categories'));
        } catch (\Exception $e) {
            if ($this->expectsJson($request)) {
                return $this->handleException($e);
            }

            return view('public.fitguide.categories', ['categories' => collect()]);
        }
    }

    public function category(Request $request, FgCategory $category)
    {
        try {
            if (!$category->is_active) {
                if ($this->expectsJson($request)) {
                    return $this->notFoundResponse('Category not found or inactive');
                }
                abort(404);
            }

            $paginationParams = $this->getPaginationParams($request);

            $singles = FgSingle::where('fg_category_id', $category->id)
                ->where('is_published', true)
                ->with(['category', 'subCategory'])
                ->latest()
                ->paginate($paginationParams['per_page']);

            $series = FgSeries::where('fg_category_id', $category->id)
                ->where('is_published', true)
                ->with(['category', 'subCategory'])
                ->latest()
                ->paginate($paginationParams['per_page']);

            // Check if this is an API request
            if ($this->expectsJson($request)) {
                return $this->successResponse([
                    'category' => [
                        'id' => $category->id,
                        'name' => $category->name,
                        'slug' => $category->slug ?? null,
                        'is_active' => $category->is_active,
                    ],
                    'singles' => [
                        'data' => FitGuideResource::collection($singles->items()),
                        'pagination' => [
                            'current_page' => $singles->currentPage(),
                            'total_pages' => $singles->lastPage(),
                            'per_page' => $singles->perPage(),
                            'total' => $singles->total(),
                            'has_more_pages' => $singles->hasMorePages(),
                        ],
                    ],
                    'series' => [
                        'data' => FitGuideResource::collection($series->items()),
                        'pagination' => [
                            'current_page' => $series->currentPage(),
                            'total_pages' => $series->lastPage(),
                            'per_page' => $series->perPage(),
                            'total' => $series->total(),
                            'has_more_pages' => $series->hasMorePages(),
                        ],
                    ],
                ], 'Category content retrieved successfully');
            }

            // Return web view for browser requests
            return view('public.fitguide.category', compact('category', 'singles', 'series'));
        } catch (\Exception $e) {
            if ($this->expectsJson($request)) {
                return $this->handleException($e);
            }

            return view('public.fitguide.category', [
                'category' => $category,
                'singles' => collect(),
                'series' => collect()
            ]);
        }
    }

    public function showSingle(Request $request, FgSingle $fgSingle)
    {
        try {
            if (!$fgSingle->is_published) {
                if ($this->expectsJson($request)) {
                    return $this->notFoundResponse('FitGuide single not found or not published');
                }
                abort(404);
            }

            // Load relationships for API response
            $fgSingle->load(['category', 'subCategory']);

            // Check if this is an API request
            if ($this->expectsJson($request)) {
                return $this->resourceResponse(
                    new FitGuideResource($fgSingle),
                    'FitGuide single retrieved successfully'
                );
            }

            // Return web view for browser requests
            return view('public.fitguide.single', compact('fgSingle'));
        } catch (\Exception $e) {
            if ($this->expectsJson($request)) {
                return $this->handleException($e);
            }

            abort(404);
        }
    }

    public function showSeries(Request $request, FgSeries $fgSeries)
    {
        try {
            if (!$fgSeries->is_published) {
                if ($this->expectsJson($request)) {
                    return $this->notFoundResponse('FitGuide series not found or not published');
                }
                abort(404);
            }

            // Get episodes for this series
            $episodes = FgSeriesEpisode::where('fg_series_id', $fgSeries->id)
                ->where('is_published', true)
                ->orderBy('episode_number')
                ->get();

            // Load relationships for API response
            $fgSeries->load(['category', 'subCategory']);
            $fgSeries->setRelation('episodes', $episodes);

            // Check if this is an API request
            if ($this->expectsJson($request)) {
                return $this->resourceResponse(
                    new FitGuideResource($fgSeries),
                    'FitGuide series retrieved successfully'
                );
            }

            // Return web view for browser requests
            return view('public.fitguide.series', compact('fgSeries', 'episodes'));
        } catch (\Exception $e) {
            if ($this->expectsJson($request)) {
                return $this->handleException($e);
            }

            abort(404);
        }
    }

    public function showEpisode(Request $request, FgSeries $fgSeries, $episodeNumber)
    {
        try {
            // Find the episode by episode number for this series
            $episode = FgSeriesEpisode::where('fg_series_id', $fgSeries->id)
                ->where('episode_number', $episodeNumber)
                ->where('is_published', true)
                ->first();

            if (!$episode || !$fgSeries->is_published) {
                if ($this->expectsJson($request)) {
                    return $this->notFoundResponse('Episode not found or not published');
                }
                abort(404);
            }

            // Check if this is an API request
            if ($this->expectsJson($request)) {
                return $this->successResponse([
                    'series' => [
                        'id' => $fgSeries->id,
                        'title' => $fgSeries->title,
                        'slug' => $fgSeries->slug,
                    ],
                    'episode' => [
                        'id' => $episode->id,
                        'episode_number' => $episode->episode_number,
                        'title' => $episode->title,
                        'description' => $episode->description,
                        'duration_minutes' => $episode->duration_minutes,
                        'video_url' => $episode->getVideoUrl() ?? null,
                        'is_published' => $episode->is_published,
                        'created_at' => $episode->created_at?->toISOString(),
                        'updated_at' => $episode->updated_at?->toISOString(),
                    ],
                ], 'Episode retrieved successfully');
            }

            // Return web view for browser requests
            return view('public.fitguide.episode', compact('fgSeries', 'episode'));
        } catch (\Exception $e) {
            if ($this->expectsJson($request)) {
                return $this->handleException($e);
            }

            abort(404);
        }
    }
}