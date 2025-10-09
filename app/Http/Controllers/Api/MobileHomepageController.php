<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FitSeries;
use App\Models\FitDoc;
use App\Models\FitLiveSession;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\FitCast;
use App\Models\FitNews;
use App\Models\FitInsight;
use App\Models\FiBlog;
use App\Models\FitArenaEvent;
use App\Models\FgSingle;
use App\Models\FgSeries;
use Illuminate\Http\JsonResponse;

class MobileHomepageController extends Controller
{
    /**
     * Get homepage content for mobile application with specific structure
     * As per tc1.md: Single API for home page with title, category, image, id
     * for Fitseries, Fitlive, Fitexpert live, Fit arena live, Fit Guide, FitNews, Fit Insights
     */
    public function getHomepageContent(): JsonResponse
    {
        try {
            $data = [
                'fitseries' => $this->getFitSeries(),
                'fitlive' => $this->getFitLive(),
                'fitexpert_live' => $this->getFitExpertLive(),
                'fit_arena_live' => $this->getFitArenaLive(),
                'fit_guide' => $this->getFitGuide(),
                'fitnews' => $this->getFitNews(),
                // New array added by darshan
                'fit_casts' => $this->getFitCasts(),
                'fit_insights' => $this->getFitInsights()
            ];

            return response()->json([
                'success' => true,
                'message' => 'Homepage content retrieved successfully',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch homepage content',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Fit Series content with title, category, image, id
     */
    private function getFitSeries(): array
    {
        try {
            $fitDocs = FitDoc::where('is_published', true)
                ->where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($item) {
                    return [
                        'id'             => $item->id,
                        'title'          => $item->title,
                        'category'       => ucfirst($item->type),
                        'image'          => $item->banner_image_url,
                        'description'    => $item->description,
                        'duration'       => $item->duration_minutes ? $item->duration_minutes . ' min' : 'N/A',
                        'total_episodes' => $item->total_episodes ?? 1,
                        'feedback'       => $item->feedback,
                        'release_date'   => $item->release_date?->format('Y-m-d'),
                        'type'           => $item->type === 'single' ? 'documentory' : 'series',
                    ];
                })
                ->groupBy('category'); // 👈 Group by category

            return $fitDocs->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }


    /**
     * Get Fit Live sessions with title, category, image, id
     */
    private function getFitLive_old(): array
    {
        try {
            $sessions = FitLiveSession::with(['category', 'instructor'])
                ->where('visibility', 'public')
                ->whereIn('status', ['scheduled', 'live'])
                ->orderBy('scheduled_at', 'asc')
                ->get() // Remove limit to get ALL sessions
                ->map(function ($session) {
                    return [
                        'id' => $session->id,
                        'title' => $session->title,
                        'category' => $session->category ? $session->category->name : 'Live Session',
                        'image' => $session->banner_image ? asset('storage/app/public/' . $session->banner_image) : null,
                        'description' => $session->description,
                        'instructor' => $session->instructor ? $session->instructor->name : 'Unknown',
                        'scheduled_at' => $session->scheduled_at?->format('Y-m-d H:i:s'),
                        'status' => $session->status,
                        'type' => 'fitlive'
                    ];
                });

            return $sessions->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Get Fit Live sessions with title, category, image, id
     */
    private function getFitLive(): array
    {
        try {
            $subcategories = SubCategory::with(['category'])
                ->where('category_id', 21)
                ->where('id', '!=', 17)
                ->orderBy('sort_order')
                ->get()
                ->map(function ($subcategory) {
                    return [
                        'id' => $subcategory->id,
                        'title' => $subcategory->name,
                        'category' => $subcategory->category ? $subcategory->category->name : 'Unknown Category',
                        'image' => $subcategory->banner_image ? asset('storage/app/public/' . $subcategory->banner_image) : null,
                        'description' => null, // subcategories table doesn’t have description
                        'instructor' => null, // not applicable for subcategory
                        'scheduled_at' => null, // not applicable
                        'status' => null, // not applicable
                        'type' => 'subcategory'
                    ];
                });

            return $subcategories->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Get Fit Expert Live sessions (premium live sessions)
     */
    private function getFitExpertLive(): array
    {
        try {
            // For FitExpert Live, we'll use sessions with 'expert' in title or specific category
            $expertSessions = FitLiveSession::with(['category', 'instructor'])
                ->where('visibility', 'public')
                // ->where(function($query) {
                //     $query->where('title', 'like', '%expert%')
                //           ->orWhere('title', 'like', '%advanced%')
                //           ->orWhere('title', 'like', '%masterclass%');
                // })
                ->whereIn('status', ['scheduled', 'live'])
                ->orderBy('scheduled_at', 'asc')
                ->limit(10)
                ->get()
                ->map(function ($session) {
                    return [
                        'id' => $session->id,
                        'title' => $session->title,
                        'category' => $session->category ? $session->category->name : 'Expert Session',
                        'image' => $session->banner_image ? asset('' . $session->banner_image) : null,
                        'recording_url' => $session->recording_url,
                        'description' => $session->description,
                        'instructor' => $session->instructor ? $session->instructor->name : 'Expert',
                        'scheduled_at' => $session->scheduled_at?->format('Y-m-d H:i:s'),
                        'status' => $session->status,
                        'type' => 'fitexpert_live'
                    ];
                });

            return $expertSessions->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Get Fit Arena Live events
     */
    private function getFitArenaLive(): array
    {
        try {
            $arenaEvents = FitArenaEvent::where('status', 'live')
                ->orWhere('status', 'upcoming')
                ->orderBy('start_date', 'asc')
                ->limit(10)
                ->get()
                ->map(function ($event) {
                    return [
                        'id' => $event->id,
                        'title' => $event->title,
                        'category' => $event->event_type ?? 'Arena Event',
                        // 'image' => $event->banner_image ? asset('storage/app/public/' . $event->banner_image) : null,
                        'image' => $event->banner_image ? "https://fittelly.com/storage/app/public/" . $event->banner_image : null,
                        'description' => $event->description,
                        'start_date' => $event->start_date?->format('Y-m-d H:i:s'),
                        'end_date' => $event->end_date?->format('Y-m-d H:i:s'),
                        'status' => $event->status,
                        'type' => 'fit_arena_live'
                    ];
                });

            return $arenaEvents->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Get Fit Guide content
     */
    private function getFitGuide(): array
    {
        try {
            // Get FitGuide singles and series
            $singles = FgSingle::with(['category', 'subCategory'])
                ->where('is_published', true)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'title' => $item->title,
                        'category' => $item->category ? $item->category->name : 'Quick Guide',
                        'image' => $item->banner_image_url,
                        'description' => $item->description,
                        'duration' => $item->duration_minutes ? $item->duration_minutes . ' min' : 'N/A',
                        'type' => 'fitguide_single'
                    ];
                });

            $series = FgSeries::with(['category', 'subCategory'])
                ->where('is_published', true)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'title' => $item->title,
                        'category' => $item->category ? $item->category->name : 'Training Series',
                        'image' => $item->banner_image_url,
                        'description' => $item->description,
                        'total_episodes' => $item->total_episodes ?? 0,
                        'type' => 'fitguide_series'
                    ];
                });

            // Combine singles and series
            $allGuides = $singles->concat($series)->take(20); // Limit total to 20

            // ✅ Group by category
            $allGuides = $allGuides->groupBy('category')->map(function ($items) {
                return $items->values(); // reset keys inside each category
            });

            return $allGuides->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Get Fit News content
     */
    private function getFitNews(): array
    {
        try {
            $news = FitNews::with(['creator'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'title' => $item->title,
                        'category' => 'News',
                        // 'image' => $item->thumbnail ? asset('storage/app/public/' . $item->thumbnail) : null,
                        'image' => $item->thumbnail ? "https://fittelly.com/storage/app/public/" . $item->thumbnail : null,
                        'description' => $item->description,
                        'creator' => $item->creator ? $item->creator->name : 'News Team',
                        'scheduled_at' => $item->scheduled_at?->format('Y-m-d H:i:s'),
                        'status' => $item->status,
                        'type' => 'fitnews'
                    ];
                });

            return $news->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Get Fit Insights content
     */
    private function getFitInsights(): array
    {
        try {
            $insights = FiBlog::with(['author', 'category'])
                ->published()
                ->orderBy('published_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($insight) {
                    return [
                        'id' => $insight->id,
                        'title' => $insight->title,
                        'category' => $insight->category ? $insight->category->name : 'Insights',
                        'image' => $insight->featured_image_url,
                        'description' => $insight->excerpt,
                        'author' => $insight->author ? $insight->author->name : 'Author',
                        'published_at' => $insight->published_at?->format('Y-m-d H:i:s'),
                        'reading_time' => $insight->reading_time ?? 0,
                        'type' => 'fit_insights'
                    ];
                });

            return $insights->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Get all fit casts/videos
     */
    public function getFitCasts(): array
    {
        try {
            $fitCasts = FitCast::with(['category', 'instructor'])
                ->active()
                ->published()
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($cast) {
                    return [
                        'id' => $cast->id,
                        'title' => $cast->title,
                        'description' => $cast->description,
                        // 'thumbnail' => $cast->thumbnail ? asset('storage/app/public/' . $cast->thumbnail) : null,
                        'thumbnail' =>  $cast->thumbnail ? "https://fittelly.com/storage/app/public/" .  $cast->thumbnail : null,
                        'video_url' => $cast->video_url,
                        'duration' => $cast->duration,
                        'category' => $cast->category ? [
                            'id' => $cast->category->id,
                            'name' => $cast->category->name
                        ] : null,
                        'instructor' => $cast->instructor ? [
                            'id' => $cast->instructor->id,
                            'name' => $cast->instructor->name,
                            'profile_image' => $cast->instructor->profile_picture ? asset('storage/app/public/' . $cast->instructor->profile_picture) : null
                        ] : null,
                        'views_count' => $cast->views_count ?? 0,
                        'likes_count' => $cast->likes_count ?? 0,
                        'is_featured' => $cast->is_featured ?? false,
                        'published_at' => $cast->published_at?->format('Y-m-d H:i:s'),
                        'created_at' => $cast->created_at->format('Y-m-d H:i:s')
                    ];
                });

            return $fitCasts->toArray();
        } catch (\Exception $e) {
            \Log::error('Error in getFitCasts: ' . $e->getMessage());
            return [];
        }
    }
}
