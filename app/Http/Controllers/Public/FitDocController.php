<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\FitDoc;
use App\Models\FgSeries;
use Illuminate\Http\Request;

class FitDocController extends Controller
{
    public function index()
    {
        // Get featured singles (movies)
        $featuredSingles = FitDoc::published()
            ->where('type', 'single')
            ->orderBy('feedback', 'desc')
            ->limit(6)
            ->get();

        // Get featured series
        $featuredSeries = FitDoc::published()
            ->where('type', 'series')
            ->orderBy('feedback', 'desc')
            ->limit(6)
            ->get();

        return view('public.fitdoc.index', compact('featuredSingles', 'featuredSeries'));
    }

    public function singles()
    {
        return view('public.fitdoc.singles');
    }

    public function series()
    {
        return view('public.fitdoc.series');
    }

    public function showSingle($fitDoc)
    {
        $fitDoc = FitDoc::where('slug', $fitDoc)->orWhere('id', $fitDoc)->firstOrFail();
        return view('public.fitdoc.single', compact('fitDoc'));
    }

    public function showSeries($fitDoc)
    {
        $fitDoc = FitDoc::where('slug', $fitDoc)->orWhere('id', $fitDoc)->firstOrFail();
        
        // Load episodes for the series
        $fitDoc->load(['episodes' => function($query) {
            $query->orderBy('episode_number');
        }]);
        
        return view('public.fitdoc.series-show', compact('fitDoc'));
    }

    public function showEpisode($fitDoc, $episode)
    {
        $fitDoc = FitDoc::where('slug', $fitDoc)->orWhere('id', $fitDoc)->firstOrFail();
        return view('public.fitdoc.episode', compact('fitDoc', 'episode'));
    }
} 