<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HomepageHero;
use Illuminate\Http\JsonResponse;

class BannerController extends Controller
{
    /**
     * Get homepage banner content for mobile application
     * As per tc1.md requirements: Banner API with video link and other details from admin's homepage heroes section
     * Parameters: Title, Category name, Button links
     */
    public function getHomepageBanners(): JsonResponse
    {
        try {
            $banners = HomepageHero::active()
                ->ordered()
                ->get()
                ->map(function ($hero) {
                    return [
                        'id' => $hero->id,
                        'title' => $hero->title,
                        'category' => $hero->category,
                        'description' => $hero->description,
                        'video_link' => $hero->youtube_embed_url,
                        'video_id' => $hero->youtube_video_id,
                        'thumbnail' => $hero->youtube_thumbnail_url,
                        'duration' => $hero->duration,
                        'year' => $hero->year,
                        'button_links' => [
                            'play_button' => [
                                'text' => $hero->play_button_text,
                                'link' => $hero->play_button_link
                            ],
                            'trailer_button' => [
                                'text' => $hero->trailer_button_text,
                                'link' => $hero->trailer_button_link
                            ]
                        ],
                        'sort_order' => $hero->sort_order,
                        'is_active' => $hero->is_active,
                        'created_at' => $hero->created_at->format('Y-m-d H:i:s'),
                        'updated_at' => $hero->updated_at->format('Y-m-d H:i:s')
                    ];
                });

            return response()->json([
                'success' => true,
                'message' => 'Homepage banners retrieved successfully',
                'data' => $banners,
                'total' => $banners->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch homepage banners',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific banner by ID
     */
    public function getBannerById($id): JsonResponse
    {
        try {
            $hero = HomepageHero::active()->find($id);

            if (!$hero) {
                return response()->json([
                    'success' => false,
                    'message' => 'Banner not found'
                ], 404);
            }

            $bannerData = [
                'id' => $hero->id,
                'title' => $hero->title,
                'category' => $hero->category,
                'description' => $hero->description,
                'video_link' => $hero->youtube_embed_url,
                'video_id' => $hero->youtube_video_id,
                'thumbnail' => $hero->youtube_thumbnail_url,
                'duration' => $hero->duration,
                'year' => $hero->year,
                'button_links' => [
                    'play_button' => [
                        'text' => $hero->play_button_text,
                        'link' => $hero->play_button_link
                    ],
                    'trailer_button' => [
                        'text' => $hero->trailer_button_text,
                        'link' => $hero->trailer_button_link
                    ]
                ],
                'sort_order' => $hero->sort_order,
                'is_active' => $hero->is_active,
                'created_at' => $hero->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $hero->updated_at->format('Y-m-d H:i:s')
            ];

            return response()->json([
                'success' => true,
                'message' => 'Banner retrieved successfully',
                'data' => $bannerData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch banner',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
