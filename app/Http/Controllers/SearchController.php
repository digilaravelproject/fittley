<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FgCategory;
use App\Models\FgSeries;
use App\Models\FgSingle;
use App\Models\FiBlog;
use App\Models\FitArenaEvent;
use App\Models\FitDoc;
use App\Models\FitFlixShorts;
use App\Models\FitLiveSession;
use App\Models\FitNews;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    /**
     * Global search across all content types.
     */
    public function index(Request $request)
    {
        $query = $request->get('q');
        $type = $request->get('type', 'all'); // all, fitdoc, fitguide, fitnews, fitinsight, fitlive, shorts
        $category = $request->get('category');
        $sort = $request->get('sort', 'relevance'); // relevance, date, rating, popularity
        $filters = $request->only(['duration', 'difficulty', 'language', 'cost']);

        $results = [];

        if (! $query && ! $category) {
            return view('search.index', compact('results', 'query', 'type'));
        }

        // Search FitDocs
        if ($type === 'all' || $type === 'fitdoc') {
            $fitDocs = $this->searchFitDocs($query, $category, $filters, $sort);
            $results['fitdocs'] = $fitDocs;
        }

        // Search FitGuide
        if ($type === 'all' || $type === 'fitguide') {
            $fitGuides = $this->searchFitGuides($query, $category, $filters, $sort);
            $results['fitguides'] = $fitGuides;
        }

        // Search FitNews
        if ($type === 'all' || $type === 'fitnews') {
            $fitNews = $this->searchFitNews($query, $category, $filters, $sort);
            $results['fitnews'] = $fitNews;
        }

        // Search FitInsight
        if ($type === 'all' || $type === 'fitinsight') {
            $fitBlogs = $this->searchFitBlogs($query, $category, $filters, $sort);
            $results['fitblogs'] = $fitBlogs;
        }

        // Search FitLive
        if ($type === 'all' || $type === 'fitlive') {
            $fitLive = $this->searchFitLive($query, $category, $filters, $sort);
            $results['fitlive'] = $fitLive;
        }

        // Search FitFlix Shorts
        if ($type === 'all' || $type === 'shorts') {
            $shorts = $this->searchShorts($query, $category, $filters, $sort);
            $results['shorts'] = $shorts;
        }

        return view('search.index', compact('results', 'query', 'type', 'category', 'sort', 'filters'));
    }

    /**
     * API search endpoint.
     */
    public function apiSearch(Request $request)
    {
        $query = $request->get('q');
        $type = $request->get('type', 'all');
        $limit = $request->get('limit', 20);

        $results = [];

        if ($type === 'all' || $type === 'fitdoc') {
            $results['fitdocs'] = FitDoc::published()
                ->where(function ($q) use ($query) {
                    $q->where('title', 'LIKE', "%{$query}%")
                        ->orWhere('description', 'LIKE', "%{$query}%");
                })
                ->limit($limit)
                ->get(['id', 'title', 'type', 'banner_image_path']);
        }

        // Add other content types...

        return response()->json($results);
    }

    /**
     * Search FitDocs with filters.
     */
    private function searchFitDocs($query, $category, $filters, $sort)
    {
        $queryBuilder = FitDoc::published();

        if ($query) {
            $queryBuilder->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->orWhere('language', 'LIKE', "%{$query}%");
            });
        }

        // Apply filters
        if (isset($filters['language']) && $filters['language']) {
            $queryBuilder->where('language', $filters['language']);
        }

        if (isset($filters['cost']) && $filters['cost'] !== null) {
            if ($filters['cost'] === 'free') {
                $queryBuilder->where('cost', 0);
            } elseif ($filters['cost'] === 'paid') {
                $queryBuilder->where('cost', '>', 0);
            }
        }

        // Apply sorting
        switch ($sort) {
            case 'date':
                $queryBuilder->orderBy('release_date', 'desc');
                break;
            case 'rating':
                $queryBuilder->orderBy('feedback', 'desc');
                break;
            case 'popularity':
                $queryBuilder->withCount('userWatchProgress')->orderBy('user_watch_progress_count', 'desc');
                break;
            default: // relevance
                if ($query) {
                    $queryBuilder->selectRaw('*,
                        (CASE
                            WHEN title LIKE ? THEN 3
                            WHEN description LIKE ? THEN 2
                            ELSE 1
                        END) as relevance_score', ["%{$query}%", "%{$query}%"])
                        ->orderBy('relevance_score', 'desc');
                }
                break;
        }

        return $queryBuilder->paginate(12);
    }

    /**
     * Search FitGuides with filters.
     */
    private function searchFitGuides($query, $category, $filters, $sort)
    {
        // Single guides
        $singles = FgSingle::published();
        $series = FgSeries::published();

        if ($query) {
            $singles->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%");
            });

            $series->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%");
            });
        }

        if ($category) {
            $singles->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
            $series->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        $singlesResults = $singles->paginate(6);
        $seriesResults = $series->paginate(6);

        return [
            'singles' => $singlesResults,
            'series' => $seriesResults,
        ];
    }

    /**
     * Search FitNews with filters.
     */
    private function searchFitNews($query, $category, $filters, $sort)
    {
        $queryBuilder = FitNews::published();

        if ($query) {
            $queryBuilder->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('content', 'LIKE', "%{$query}%")
                    ->orWhere('excerpt', 'LIKE', "%{$query}%");
            });
        }

        switch ($sort) {
            case 'date':
                $queryBuilder->orderBy('published_at', 'desc');
                break;
            default:
                $queryBuilder->orderBy('created_at', 'desc');
                break;
        }

        return $queryBuilder->paginate(12);
    }

    /**
     * Search FitBlogs with filters.
     */
    private function searchFitBlogs($query, $category, $filters, $sort)
    {
        $queryBuilder = FiBlog::published();

        if ($query) {
            $queryBuilder->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('content', 'LIKE', "%{$query}%")
                    ->orWhere('excerpt', 'LIKE', "%{$query}%");
            });
        }

        if ($category) {
            $queryBuilder->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        return $queryBuilder->paginate(12);
    }

    /**
     * Search FitLive sessions.
     */
    private function searchFitLive($query, $category, $filters, $sort)
    {
        $queryBuilder = FitLiveSession::query();

        if ($query) {
            $queryBuilder->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->orWhere('instructor_name', 'LIKE', "%{$query}%");
            });
        }

        return $queryBuilder->orderBy('scheduled_at', 'desc')->paginate(12);
    }

    /**
     * Search FitFlix Shorts.
     */
    private function searchShorts($query, $category, $filters, $sort)
    {
        $queryBuilder = FitFlixShorts::published();

        if ($query) {
            $queryBuilder->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%");
            });
        }

        if ($category) {
            $queryBuilder->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        return $queryBuilder->orderBy('created_at', 'desc')->paginate(12);
    }

    /**
     * Get search suggestions.
     */
    public function suggestions(Request $request)
    {
        $query = $request->get('q');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $suggestions = [];

        // Get title suggestions from different content types
        $fitDocTitles = FitDoc::published()
            ->where('title', 'LIKE', "%{$query}%")
            ->limit(5)
            ->pluck('title');

        $fitGuideTitles = collect()
            ->merge(FgSingle::published()->where('title', 'LIKE', "%{$query}%")->limit(3)->pluck('title'))
            ->merge(FgSeries::published()->where('title', 'LIKE', "%{$query}%")->limit(3)->pluck('title'));

        $suggestions = $fitDocTitles->merge($fitGuideTitles)->unique()->take(10);

        return response()->json($suggestions);
    }

    public function search(Request $request)
    {
        try {
            $query = $request->get('query'); // Get the search query

            if (! $query) {
                return response()->json([], 400); // Return a 400 if no query is provided
            }

            $results = collect();

            // Search fg_categories (categories) first and track their slugs
            $matchingFgCategories = FgCategory::where('name', 'LIKE', "%$query%")->take(5)->get();

            $addedCategorySlugs = [];

            $matchingFgCategories->each(function ($category) use (&$results, &$addedCategorySlugs) {
                $addedCategorySlugs[] = $category->slug;

                if ($category->slug === 'fitcast-live' || $category->slug === 'fitcast') {
                    $url = route('fitguide.fitcast');
                } else {
                    $url = route('fitguide.index', ['category' => $category->slug]);
                }

                $results->push([
                    'title' => $category->name,
                    'url' => $url,
                ]);
            });
            $today = Carbon::today()->toDateString();
            // Now search other models
            $fitDocResults = FitDoc::where('title', 'LIKE', "%$query%")->take(5)->get();
            $fitNewsResults = FitNews::where('title', 'LIKE', "%$query%")
                ->whereDate('scheduled_at', $today)  // ya published_at agar available hai
                ->take(5)
                ->get();
            $fgSingleResults = FgSingle::with('category')->where('title', 'LIKE', "%$query%")->take(5)->get();
            $fgSeriesResults = FgSeries::with('category')->where('title', 'LIKE', "%$query%")->take(5)->get();
            $fitArenaResults = FitArenaEvent::Where('title', 'LIKE', "%$query%")
                ->where('visibility', 'public')
                ->take(5)
                ->get();
            $fitBlogResults = FiBlog::Where('title', 'LIKE', "%$query%")
                ->where('status', 'published')
                ->take(5)
                ->get();

            // Search subcategories
            $matchingSubCategories = \App\Models\SubCategory::where('name', 'LIKE', "%$query%")->take(5)->get();
            foreach ($matchingSubCategories as $subCategory) {
                $results->push([
                    'title' => $subCategory->name,
                    'url' => route('fitlive.daily-classes.show', $subCategory->id),
                ]);
            }

            // Process fitLiveCategories (same as your existing logic)
            $fitLiveCategories = collect();
            if (class_exists('App\Models\Category')) {
                $fitLiveCategories = Category::with(['subCategories' => function ($subQuery) use ($query) {
                    $subQuery->with(['fitLiveSessions' => function ($sessionQuery) use ($query) {
                        $sessionQuery->where('visibility', 'public')
                            ->where('title', 'LIKE', "%$query%")
                            ->orderByRaw("CASE status WHEN 'live' THEN 1 WHEN 'scheduled' THEN 2 WHEN 'ended' THEN 3 END")
                            ->orderBy('scheduled_at', 'desc');
                    }]);
                }])
                    ->where('id', '!=', 17)
                    ->orderByDesc('sort_order')
                    ->take(5)
                    ->get();

                foreach ($fitLiveCategories as $category) {
                    foreach ($category->subCategories as $subCategory) {
                        foreach ($subCategory->fitLiveSessions as $session) {
                            if ($session->category_id == 21) {
                                if (Carbon::parse($session->scheduled_at)->isSameDay($today)) {
                                    $timeFormatted = Carbon::parse($session->scheduled_at)->format('h:i A');
                                    $titleWithTime = $session->title . ' - ' . $timeFormatted;

                                    $route = route('fitlive.daily-classes.show', $session->sub_category_id);

                                    $results->push([
                                        'title' => $titleWithTime,
                                        'url' => $route,
                                    ]);
                                }
                            } else {
                                $route = route('fitlive.session', $session->id);

                                $results->push([
                                    'title' => $session->title,
                                    'url' => $route,
                                ]);
                            }
                        }
                    }
                }
            }
            // Add results from FitAreena
            $fitArenaResults->each(function ($item) use ($results) {
                $results->push([
                    'title' => $item->title,
                    'url' => route('fitarena.show', $item->slug),
                ]);
            });
            // Add results from FitDoc
            $fitDocResults->each(function ($item) use ($results) {
                $results->push([
                    'title' => $item->title,
                    'url' => route('fitdoc.single.show', $item->id),
                ]);
            });

            // Add results from FitNews
            $fitNewsResults->each(function ($item) use ($results) {
                $results->push([
                    'title' => $item->title,
                    'url' => route('fitnews.show', $item->id),
                ]);
            });
            // Add results from Fit Blog
            $fitBlogResults->each(function ($item) use ($results) {
                $results->push([
                    'title' => $item->title,
                    'url' => route('fitinsight.show', $item->id),
                ]);
            });

            // Add results from FgSingle only if category slug not already added
            $fgSingleResults->each(function ($item) use (&$results, $addedCategorySlugs) {
                $category = $item->category; // Relationship to fg_categories
                if ($category && ! in_array($category->slug, $addedCategorySlugs)) {
                    $results->push([
                        'title' => $item->title,
                        'url' => route('fitguide.single.show', $item->slug),
                    ]);
                }
            });

            // Add results from FgSeries only if category slug not already added
            $fgSeriesResults->each(function ($item) use (&$results, $addedCategorySlugs) {
                $category = $item->category; // Relationship to fg_categories
                if ($category && ! in_array($category->slug, $addedCategorySlugs)) {
                    $results->push([
                        'title' => $item->title,
                        'url' => route('fitguide.series.show', $item->slug),
                    ]);
                }
            });

            // Optional: FiBlog results here if needed

            // Remove duplicates by URL and reset keys
            $results = $results->unique('url')->values();

            return response()->json($results);
        } catch (\Exception $e) {
            Log::error('Search Error: ' . $e->getMessage());

            return response()->json(['error' => 'Something went wrong. Please try again later.'], 500);
        }
    }

    public function search_old_2(Request $request)
    {
        try {
            $query = $request->get('query'); // Get the search query

            if (! $query) {
                return response()->json([], 400); // Return a 400 if no query is provided
            }

            // Initialize an empty collection to store the results
            $results = collect();

            // Searching across multiple models like FitDoc, FitNews, FitLiveSession
            $fitDocResults = FitDoc::where('title', 'LIKE', "%$query%")->take(5)->get();
            $fitNewsResults = FitNews::where('title', 'LIKE', "%$query%")->take(5)->get();
            // $fitLiveResults = FitLiveSession::where('title', 'LIKE', "%$query%")->take(5)->get();
            $fgSingleResults = FgSingle::where('title', 'LIKE', "%$query%")->take(5)->get();
            $fgSeriesResults = FgSeries::where('title', 'LIKE', "%$query%")->take(5)->get();
            $fiBlogResults = FiBlog::where('title', 'LIKE', "%$query%")->take(5)->get();
            // Additional FitLive Results via Category > SubCategory > FitLiveSession structure
            $fitLiveCategories = collect();
            if (class_exists('App\Models\Category')) {
                $fitLiveCategories = Category::with(['subCategories' => function ($subQuery) use ($query) {
                    $subQuery->with(['fitLiveSessions' => function ($sessionQuery) use ($query) {
                        $sessionQuery->where('visibility', 'public')
                            ->where('title', 'LIKE', "%$query%")
                            ->orderByRaw("CASE status WHEN 'live' THEN 1 WHEN 'scheduled' THEN 2 WHEN 'ended' THEN 3 END")
                            ->orderBy('scheduled_at', 'desc');
                    }]);
                }])
                    ->where('id', '!=', 17)
                    ->orderByDesc('sort_order')
                    ->get();

                // Process nested results
                foreach ($fitLiveCategories as $category) {
                    foreach ($category->subCategories as $subCategory) {
                        foreach ($subCategory->fitLiveSessions as $session) {
                            $route = $session->category_id == 21
                                ? route('fitlive.daily-classes.show', $session->id)
                                : route('fitlive.session', $session->id);

                            $results->push([
                                'title' => $session->title,
                                'url' => $route,
                            ]);
                        }
                    }
                }
            }

            // Add results from FitDoc
            $fitDocResults->each(function ($item) use ($results) {
                $results->push([
                    'title' => $item->title,
                    'url' => route('fitdoc.single.show', $item->id), // FitDoc URL
                ]);
            });

            // Add results from FitNews
            $fitNewsResults->each(function ($item) use ($results) {
                $results->push([
                    'title' => $item->title,
                    'url' => route('fitnews.show', $item->id), // FitNews URL
                ]);
            });

            // // Add results from FitLiveSession
            // $fitLiveResults->each(function ($item) use ($results) {
            //     $route = $item->category_id == 21
            //         ? route('fitlive.daily-classes.show', $item->id)
            //         : route('fitlive.session', $item->id); // Default route for other categories

            //     $results->push([
            //         'title' => $item->title,
            //         'url' => $route, // Dynamic FitLiveSession URL
            //     ]);
            // });

            // Add results from FgSingle
            // Add results from FgSingle
            $fgSingleResults->each(function ($item) use ($results) {
                // Fetch category for this FgSingle item
                $category = $item->category; // Assuming `category` is a relationship on the `FgSingle` model

                // Generate the route URL
                $results->push([
                    'title' => $item->title,
                    'url' => route('fitguide.index', ['category' => $category->slug]), // FgSingle URL with category slug
                ]);
            });

            // Add results from FgSeries
            $fgSeriesResults->each(function ($item) use ($results) {
                // Fetch category for this FgSingle item
                $category = $item->category; // Assuming `category` is a relationship on the `FgSingle` model

                // Generate the route URL
                $results->push([
                    'title' => $item->title,
                    'url' => route('fitguide.index', ['category' => $category->slug]), // FgSingle URL with category slug
                ]);
            });

            // Add results from FiBlog
            // $fiBlogResults->each(function ($item) use ($results) {
            //     $results->push([
            //         'title' => $item->title,
            //         'url' => route('fiblog.show', $item->id), // FiBlog URL
            //     ]);
            // });
            $results = $results->unique('url')->values();

            // Return the results as JSON
            return response()->json($results);
        } catch (\Exception $e) {
            // Log the exception message
            Log::error('Search Error: ' . $e->getMessage());

            // Return a 500 response with error message
            return response()->json(['error' => 'Something went wrong. Please try again later.'], 500);
        }
    }
}
