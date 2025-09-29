<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FgSingle;
use App\Models\FgSeries;
use App\Models\FgCategory;
use App\Models\FgSubCategory;
use Illuminate\Http\Request;

class FitGuideController extends Controller
{
    /**
     * Display a listing of all FitGuide content (singles and series).
     */
    public function index(Request $request)
    {
        $query = $request->get('search');
        $categoryFilter = $request->get('category');
        $typeFilter = $request->get('type'); // 'single' or 'series'

        // Get singles
        $singlesQuery = FgSingle::with(['category', 'subCategory'])
            ->when($query, function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->when($categoryFilter, function ($q) use ($categoryFilter) {
                $q->where('fg_category_id', $categoryFilter);
            });

        // Get series
        $seriesQuery = FgSeries::with(['category', 'subCategory'])
            ->when($query, function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->when($categoryFilter, function ($q) use ($categoryFilter) {
                $q->where('fg_category_id', $categoryFilter);
            });

        // Apply type filter
        if ($typeFilter === 'single') {
            $singles = $singlesQuery->latest()->paginate(10);
            $series = collect();
        } elseif ($typeFilter === 'series') {
            $singles = collect();
            $series = $seriesQuery->latest()->paginate(10);
        } else {
            // Show both, but paginate separately for better UX
            $singles = $singlesQuery->latest()->limit(5)->get();
            $series = $seriesQuery->latest()->limit(5)->get();
        }

        $categories = FgCategory::active()->ordered()->get();

        return view('admin.fitguide.index', compact(
            'singles', 
            'series', 
            'categories', 
            'query', 
            'categoryFilter', 
            'typeFilter'
        ));
    }

    /**
     * Display statistics for the dashboard.
     */
    public function stats()
    {
        $totalSingles = FgSingle::count();
        $totalSeries = FgSeries::count();
        $totalEpisodes = \App\Models\FgSeriesEpisode::count();
        $publishedSingles = FgSingle::where('is_published', true)->count();
        $publishedSeries = FgSeries::where('is_published', true)->count();
        $totalCategories = FgCategory::count();
        $totalSubCategories = FgSubCategory::count();

        return [
            'total_singles' => $totalSingles,
            'total_series' => $totalSeries,
            'total_episodes' => $totalEpisodes,
            'published_singles' => $publishedSingles,
            'published_series' => $publishedSeries,
            'total_categories' => $totalCategories,
            'total_subcategories' => $totalSubCategories,
            'draft_singles' => $totalSingles - $publishedSingles,
            'draft_series' => $totalSeries - $publishedSeries,
        ];
    }
}
