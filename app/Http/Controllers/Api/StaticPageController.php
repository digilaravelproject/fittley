<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StaticPageController extends Controller
{
    /**
     * Get specific page by type
     */
    public function getPages($type): JsonResponse
    {
        try {
            // Fetch the page by type
            $page = StaticPage::where('type', $type)->first();

            if (!$page) {
                return response()->json([
                    'success' => false,
                    'message' => 'Page not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Page retrieved successfully',
                'data' => $page
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch page',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Enquiry form
     */
    public function contactUs(Request $request): JsonResponse
    {
        try {
            // Validate the incoming request
            $validated = $request->validate([
                'name'         => 'required|string|max:255',
                'phone_number' => 'required|string|max:20',
                'details'      => 'nullable|string',
            ]);

            // Save data to contact_us table
            ContactUs::create([
                'name'         => $validated['name'],
                'phone_number' => $validated['phone_number'],
                // In DB your column is `detail` (singular), so we map it:
                'detail'       => $validated['details'] ?? null,
            ]);

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Our team will contact you shortly'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit enquiry',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
