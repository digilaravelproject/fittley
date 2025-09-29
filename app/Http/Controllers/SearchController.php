<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FitDoc;
use App\Models\FgSingle;
use App\Models\FgSeries;
use App\Models\FiBlog;
use App\Models\FitNews;
use App\Models\FitLiveSession;
use App\Models\FitFlixShorts;
use App\Models\CommunityPost;

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

        if (!$query && !$category) {
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
                ->where(function($q) use ($query) {
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
            $queryBuilder->where(function($q) use ($query) {
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
                    $queryBuilder->selectRaw("*, 
                        (CASE 
                            WHEN title LIKE ? THEN 3
                            WHEN description LIKE ? THEN 2
                            ELSE 1
                        END) as relevance_score", ["%{$query}%", "%{$query}%"])
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
            $singles->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            });

            $series->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            });
        }

        if ($category) {
            $singles->whereHas('category', function($q) use ($category) {
                $q->where('slug', $category);
            });
            $series->whereHas('category', function($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        $singlesResults = $singles->paginate(6);
        $seriesResults = $series->paginate(6);

        return [
            'singles' => $singlesResults,
            'series' => $seriesResults
        ];
    }

    /**
     * Search FitNews with filters.
     */
    private function searchFitNews($query, $category, $filters, $sort)
    {
        $queryBuilder = FitNews::published();

        if ($query) {
            $queryBuilder->where(function($q) use ($query) {
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
            $queryBuilder->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('content', 'LIKE', "%{$query}%")
                  ->orWhere('excerpt', 'LIKE', "%{$query}%");
            });
        }

        if ($category) {
            $queryBuilder->whereHas('category', function($q) use ($category) {
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
            $queryBuilder->where(function($q) use ($query) {
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
            $queryBuilder->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            });
        }

        if ($category) {
            $queryBuilder->whereHas('category', function($q) use ($category) {
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
}
