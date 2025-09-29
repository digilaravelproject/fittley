<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FitDoc;
use App\Models\Category;
use App\Models\FgSeries;
use Illuminate\Http\JsonResponse;

class FitDocController extends Controller
{
    /**
     * Get all documentaries
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = FitDoc::where('is_published', true)
            ->where('is_active', true);

            // Apply filters
            if ($request->has('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            if ($request->has('search')) {
                $query->where(function($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search . '%')
                      ->orWhere('description', 'like', '%' . $request->search . '%');
                });
            }

            $fitDocs = $query->orderBy('created_at', 'desc')
                ->paginate($request->get('per_page', 15));

            return response()->json([
                'success' => true,
                'message' => 'FitDoc documentaries retrieved successfully',
                'data' => $fitDocs,
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => '1.0'
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve FitDoc documentaries',
                'error' => $e->getMessage(),
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => '1.0'
                ]
            ], 500);
        }
    }

    /**
     * Get documentary details
     */
    public function show($id): JsonResponse
    {
        try {
            $fitDoc = FitDoc::where('is_published', true)
            ->where('is_active', true)
            ->findOrFail($id);

            // Note: views_count column doesn't exist, skipping increment

            return response()->json([
                'success' => true,
                'message' => 'FitDoc documentary retrieved successfully',
                'data' => $fitDoc,
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => '1.0'
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'FitDoc documentary not found',
                'error' => $e->getMessage(),
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => '1.0'
                ]
            ], 404);
        }
    }

    /**
     * Get FitDoc categories
     */
    public function getCategories(): JsonResponse
    {
        try {
            $categories = Category::where('type', 'fitdoc')
                ->where('is_active', true)
                ->orderBy('name')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'FitDoc categories retrieved successfully',
                'data' => $categories,
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => '1.0'
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve FitDoc categories',
                'error' => $e->getMessage(),
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => '1.0'
                ]
            ], 500);
        }
    }

    /**
     * Get series details
     */
    public function getSeries($id): JsonResponse
    {
        try {
            $series = FgSeries::where('is_active', true)
            ->with(['episodes' => function($query) {
                $query->where('is_published', true)
                      ->orderBy('episode_number');
            }])
            ->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'FitDoc series retrieved successfully',
                'data' => $series,
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => '1.0'
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'FitDoc series not found',
                'error' => $e->getMessage(),
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => '1.0'
                ]
            ], 404);
        }
    }
}
