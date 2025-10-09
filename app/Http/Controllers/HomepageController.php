<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomepageHero;
use App\Models\FitDoc;
use App\Models\FitArenaEvent;
use App\Models\FitLiveSession;
use App\Models\FgSingle;
use App\Models\FgSeries;
use App\Models\FitNews;
use App\Models\FiBlog;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\FgCategory;

class HomepageController extends Controller
{
    public function index()
    {
        // Get active hero content
        $hero = HomepageHero::active()->ordered()->first();

        // 1. FitDoc Content - Videos and Series
        $fitDocVideos = collect();
        $fitDocSeries = collect();
        if (class_exists('App\Models\FitDoc')) {
            $fitDocVideos = FitDoc::where('is_published', true)
                ->where('type', 'single')
                ->orderBy('created_at', 'desc')
                ->get();
            
            $fitDocSeries = FitDoc::where('is_published', true)
                ->where('type', 'series')
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        $fitarenaliveEvents = collect();
        // Get live events
        $fitarenaliveEvents = FitArenaEvent::where('visibility', 'public')
            ->orderBy('start_date', 'desc')
            ->take(4)
            ->get()
            ->map(function ($event) {
                $event->banner_image_path = $event->banner_image;
                return $event;
            });

        // 2. FitLive Content - Organized by Categories and Subcategories
        $fitLiveCategories = collect();
        if (class_exists('App\Models\Category')) {
            $fitLiveCategories = Category::with(['subCategories' => function($query) {
                $query->with(['fitLiveSessions' => function($q) {
                    $q->where('visibility', 'public')
                      ->orderByRaw("CASE status WHEN 'live' THEN 1 WHEN 'scheduled' THEN 2 WHEN 'ended' THEN 3 END")
                      ->orderBy('scheduled_at', 'desc');
                }]);
            }])
            // ->whereHas('fitLiveSessions', function($query) {
            //     $query->where('visibility', 'public');
            // })
            ->where('id', '!=', 17)
            ->orderByDesc('sort_order')
            ->get();
        }
        
        // echo '<pre>';print_r($fitLiveCategories);die;

        // 3. FitNews Content - Live first, then archive
        $fitNewsLive = collect();
        $fitNewsArchive = collect();
        if (class_exists('App\Models\FitNews')) {
            $fitNewsLive = FitNews::where('status', 'live')
                ->with('creator')
                ->orderBy('started_at', 'desc')
                ->get();
            
            $fitNewsArchive = FitNews::whereIn('status', ['ended', 'scheduled'])
                ->with('creator')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // 4. FitGuide Content - Organized by Categories and Subcategories
        $fitGuideCategories = collect();
        $fitGuides = collect();
        if (class_exists('App\Models\FgCategory')) {
            $fitGuideCategories = FgCategory::with(['singles' => function($query) {
                $query->where('is_published', true)
                      ->orderBy('created_at', 'desc');
            }, 'series' => function($query) {
                $query->where('is_published', true)
                      ->orderBy('created_at', 'desc');
            }])
            ->where('is_active', true)
            ->whereHas('singles', function($query) {
                $query->where('is_published', true);
            })
            ->orWhereHas('series', function($query) {
                $query->where('is_published', true);
            })
            ->orderBy('sort_order')
            ->get();
            
            // Also get simple collection for homepage_new.blade.php
            $fitGuides = collect();
            if (class_exists('App\Models\FgSingle')) {
                $singles = FgSingle::where('is_published', true)->latest()->take(3)->get();
                $fitGuides = $fitGuides->merge($singles);
            }
            if (class_exists('App\Models\FgSeries')) {
                $series = FgSeries::where('is_published', true)->latest()->take(3)->get();
                $fitGuides = $fitGuides->merge($series);
            }
        }

        // 5. FitInsights Content - Single row
        $fitInsights = collect();
        if (class_exists('App\Models\FiBlog')) {
            $fitInsights = FiBlog::where('status', 'published')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($event) {
                    $event->banner_image_path = $event->featured_image_path;
                    return $event;
                });
        }

        return view('homepage', compact(
            'hero',
            'fitDocVideos',
            'fitDocSeries',
            'fitLiveCategories',
            'fitarenaliveEvents',
            'fitNewsLive',
            'fitNewsArchive',
            'fitGuideCategories',
            'fitGuides',
            'fitInsights'
        ));
    }
}
