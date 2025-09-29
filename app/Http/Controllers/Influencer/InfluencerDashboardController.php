<?php

namespace App\Http\Controllers\Influencer;

use App\Http\Controllers\Controller;
use App\Models\InfluencerProfile;
use App\Models\InfluencerLink;
use App\Models\InfluencerSale;
use App\Models\CommissionPayout;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InfluencerDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show influencer dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        $influencerProfile = $user->influencerProfile;

        if (!$influencerProfile) {
            return redirect()->route('influencer.application.create')
                ->with('info', 'Please complete your influencer application first.');
        }

        $stats = [
            'total_links' => $influencerProfile->links()->count(),
            'active_links' => $influencerProfile->activeLinks()->count(),
            'total_clicks' => $influencerProfile->links()->sum('clicks_count'),
            'total_conversions' => $influencerProfile->links()->sum('conversions_count'),
            'sales_this_month' => $influencerProfile->sales_this_month,
            'commission_this_month' => $influencerProfile->commission_this_month,
            'total_commission_earned' => $influencerProfile->total_commission_earned,
            'pending_commission' => $influencerProfile->pending_commission,
            'commission_rate' => $influencerProfile->commission_rate,
        ];

        $recentSales = $influencerProfile->sales()
            ->with(['customer', 'subscription.subscriptionPlan'])
            ->latest()
            ->take(10)
            ->get();

        $recentPayouts = $influencerProfile->payouts()
            ->latest()
            ->take(5)
            ->get();

        return view('influencer.dashboard', compact('influencerProfile', 'stats', 'recentSales', 'recentPayouts'));
    }

    /**
     * Show application form
     */
    public function createApplication()
    {
        $user = Auth::user();
        
        if ($user->influencerProfile) {
            return redirect()->route('influencer.dashboard')
                ->with('info', 'You already have an influencer application.');
        }

        return view('influencer.application.create');
    }

    /**
     * Submit application
     */
    public function storeApplication(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bio' => 'required|string|max:1000',
            'social_instagram' => 'nullable|url',
            'social_youtube' => 'nullable|url',
            'social_facebook' => 'nullable|url',
            'social_twitter' => 'nullable|url',
            'social_tiktok' => 'nullable|url',
            'followers_count' => 'required|integer|min:0',
            'niche' => 'required|string|max:255',
            'previous_work' => 'nullable|string|max:2000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();

        if ($user->influencerProfile) {
            return redirect()->route('influencer.dashboard')
                ->with('error', 'You already have an influencer application.');
        }

        try {
            $data = $validator->validated();
            $data['user_id'] = $user->id;
            $data['status'] = 'pending';
            $data['application_status'] = 'submitted';

            InfluencerProfile::create($data);

            return redirect()->route('influencer.dashboard')
                ->with('success', 'Application submitted successfully! We will review it within 24-48 hours.');
        } catch (\Exception $e) {
            \Log::error('Error creating influencer application: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error submitting application. Please try again.')
                ->withInput();
        }
    }

    /**
     * Show edit profile form
     */
    public function editProfile()
    {
        $influencerProfile = Auth::user()->influencerProfile;

        if (!$influencerProfile) {
            return redirect()->route('influencer.application.create');
        }

        return view('influencer.profile.edit', compact('influencerProfile'));
    }

    /**
     * Update profile (handles both web and API requests)
     */
    public function updateProfile(Request $request)
    {
        $influencerProfile = Auth::user()->influencerProfile;

        if (!$influencerProfile) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No influencer profile found'
                ], 404);
            }
            return redirect()->route('influencer.application.create');
        }

        // Different validation rules for API vs web
        $rules = $request->expectsJson() ? [
            'bio' => 'required|string|max:1000',
            'social_instagram' => 'nullable|url',
            'social_youtube' => 'nullable|url',
            'social_facebook' => 'nullable|url',
            'social_tiktok' => 'nullable|url',
            'social_twitter' => 'nullable|url',
            'audience_size' => 'required|integer|min:100',
            'niche' => 'required|string|max:255',
        ] : [
            'bio' => 'required|string|max:1000',
            'social_instagram' => 'nullable|url',
            'social_youtube' => 'nullable|url',
            'social_facebook' => 'nullable|url',
            'social_twitter' => 'nullable|url',
            'social_tiktok' => 'nullable|url',
            'followers_count' => 'required|integer|min:0',
            'niche' => 'required|string|max:255',
            'previous_work' => 'nullable|string|max:2000',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $influencerProfile->update($validator->validated());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Profile updated successfully',
                    'data' => $influencerProfile->fresh()
                ]);
            }

            return redirect()->route('influencer.dashboard')
                ->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update profile',
                    'error' => $e->getMessage()
                ], 500);
            }
            return redirect()->back()
                ->with('error', 'Error updating profile.')
                ->withInput();
        }
    }

    /**
     * Show links management
     */
    public function links()
    {
        $influencerProfile = Auth::user()->influencerProfile;

        if (!$influencerProfile || !$influencerProfile->isApproved()) {
            return redirect()->route('influencer.dashboard')
                ->with('error', 'Your influencer application must be approved first.');
        }

        $links = $influencerProfile->links()
            ->withCount('sales')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('influencer.links.index', compact('links'));
    }

    /**
     * Create new link
     */
    public function createLink()
    {
        $influencerProfile = Auth::user()->influencerProfile;

        if (!$influencerProfile || !$influencerProfile->isApproved()) {
            return redirect()->route('influencer.dashboard')
                ->with('error', 'Your influencer application must be approved first.');
        }

        return view('influencer.links.create');
    }

    /**
     * Store new link
     */
    public function storeLink(Request $request)
    {
        $influencerProfile = Auth::user()->influencerProfile;

        if (!$influencerProfile || !$influencerProfile->isApproved()) {
            return redirect()->route('influencer.dashboard')
                ->with('error', 'Your influencer application must be approved first.');
        }

        $validator = Validator::make($request->all(), [
            'campaign_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'target_url' => 'required|string|max:255',
            'expires_at' => 'nullable|date|after:today',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $validator->validated();
            $data['influencer_profile_id'] = $influencerProfile->id;

            InfluencerLink::create($data);

            return redirect()->route('influencer.links.index')
                ->with('success', 'Tracking link created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating link.')
                ->withInput();
        }
    }

    /**
     * Toggle link status
     */
    public function toggleLinkStatus(InfluencerLink $link)
    {
        $influencerProfile = Auth::user()->influencerProfile;

        if ($link->influencer_profile_id !== $influencerProfile->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        try {
            $link->update(['is_active' => !$link->is_active]);

            return response()->json([
                'success' => true,
                'message' => 'Link status updated successfully!',
                'is_active' => $link->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating link status!'
            ], 500);
        }
    }

    /**
     * Show sales (handles both web and API requests)
     */
    public function sales(Request $request)
    {
        $influencerProfile = Auth::user()->influencerProfile;

        if (!$influencerProfile) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No influencer profile found'
                ], 404);
            }
            return redirect()->route('influencer.dashboard');
        }

        $sales = $influencerProfile->sales()
            ->with(['customer', 'subscription.subscriptionPlan', 'influencerLink'])
            ->when($request->get('status'), function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(15);

        $stats = [
            'total_sales' => $influencerProfile->sales()->sum('sale_amount'),
            'total_commission' => $influencerProfile->sales()->confirmed()->sum('commission_amount'),
            'pending_sales' => $influencerProfile->sales()->pending()->count(),
            'confirmed_sales' => $influencerProfile->sales()->confirmed()->count(),
        ];

        // Return JSON for API requests
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'sales' => $sales,
                    'stats' => $stats
                ]
            ]);
        }

        // Return view for web requests
        return view('influencer.sales.index', compact('sales', 'stats'));
    }

    /**
     * Show payouts
     */
    public function payouts()
    {
        $influencerProfile = Auth::user()->influencerProfile;

        if (!$influencerProfile) {
            return redirect()->route('influencer.dashboard');
        }

        $payouts = $influencerProfile->payouts()
            ->latest()
            ->paginate(15);

        $stats = [
            'total_earned' => $influencerProfile->total_commission_earned,
            'total_paid' => $influencerProfile->total_commission_paid,
            'pending_commission' => $influencerProfile->pending_commission,
            'total_payouts' => $payouts->total(),
        ];

        return view('influencer.payouts.index', compact('payouts', 'stats'));
    }

    /**
     * Request payout
     */
    public function requestPayout(Request $request)
    {
        $influencerProfile = Auth::user()->influencerProfile;

        if (!$influencerProfile || !$influencerProfile->isApproved()) {
            return redirect()->back()
                ->with('error', 'Your influencer application must be approved first.');
        }

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:100|max:' . $influencerProfile->pending_commission,
            'payment_method' => 'required|string|in:bank_transfer,paypal',
            'payment_details' => 'required|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($influencerProfile->pending_commission < $request->amount) {
            return redirect()->back()
                ->with('error', 'Insufficient commission balance.');
        }

        try {
            CommissionPayout::createPayout(
                $influencerProfile,
                $request->amount,
                $request->payment_method,
                $request->payment_details
            );

            return redirect()->route('influencer.payouts.index')
                ->with('success', 'Payout request submitted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error requesting payout.')
                ->withInput();
        }
    }

    /**
     * Get analytics data
     */
    public function analytics(Request $request): JsonResponse
    {
        $influencerProfile = Auth::user()->influencerProfile;

        if (!$influencerProfile) {
            return response()->json(['error' => 'Influencer profile not found'], 404);
        }

        $period = $request->get('period', '30'); // days
        $startDate = now()->subDays($period);

        $data = [
            'clicks' => $influencerProfile->links()->sum('clicks_count'),
            'conversions' => $influencerProfile->links()->sum('conversions_count'),
            'sales_amount' => $influencerProfile->sales()
                ->where('sale_date', '>=', $startDate)
                ->sum('sale_amount'),
            'commission_earned' => $influencerProfile->sales()
                ->confirmed()
                ->where('sale_date', '>=', $startDate)
                ->sum('commission_amount'),
            'conversion_rate' => $this->calculateConversionRate($influencerProfile),
            'daily_stats' => $this->getDailyStats($influencerProfile, $startDate),
            'top_links' => $this->getTopLinks($influencerProfile, $startDate),
        ];

        return response()->json($data);
    }

    /**
     * Calculate overall conversion rate
     */
    private function calculateConversionRate($influencerProfile)
    {
        $totalClicks = $influencerProfile->links()->sum('clicks_count');
        $totalConversions = $influencerProfile->links()->sum('conversions_count');

        return $totalClicks > 0 ? round(($totalConversions / $totalClicks) * 100, 2) : 0;
    }

    /**
     * Get daily statistics
     */
    private function getDailyStats($influencerProfile, $startDate)
    {
        return $influencerProfile->sales()
            ->selectRaw('DATE(sale_date) as date, COUNT(*) as sales_count, SUM(sale_amount) as total_amount, SUM(commission_amount) as commission')
            ->where('sale_date', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Get top performing links
     */
    private function getTopLinks($influencerProfile, $startDate)
    {
        return $influencerProfile->links()
            ->withCount(['sales' => function ($query) use ($startDate) {
                $query->where('sale_date', '>=', $startDate);
            }])
            ->withSum(['sales as total_commission' => function ($query) use ($startDate) {
                $query->confirmed()->where('sale_date', '>=', $startDate);
            }], 'commission_amount')
            ->orderByDesc('sales_count')
            ->take(5)
            ->get();
    }

    // API Methods
    
    /**
     * Get influencer dashboard data for API
     */
    public function apiIndex(): JsonResponse
    {
        $user = Auth::user();
        $influencerProfile = $user->influencerProfile;

        if (!$influencerProfile) {
            return response()->json([
                'success' => false,
                'message' => 'No influencer profile found',
                'data' => [
                    'has_profile' => false,
                    'application_url' => '/api/influencer/apply'
                ]
            ], 404);
        }

        $stats = [
            'total_clicks' => $influencerProfile->links()->sum('clicks_count'),
            'total_conversions' => $influencerProfile->links()->sum('conversions_count'),
            'total_commission' => $influencerProfile->total_commission_earned,
            'pending_commission' => $influencerProfile->pending_commission,
            'active_links' => $influencerProfile->links()->where('is_active', true)->count(),
            'total_sales' => $influencerProfile->sales()->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'profile' => $influencerProfile,
                'stats' => $stats,
                'status' => $influencerProfile->status
            ]
        ]);
    }

    /**
     * Apply as influencer via API
     */
    public function apply(Request $request): JsonResponse
    {
        $request->validate([
            'bio' => 'required|string|max:1000',
            'social_instagram' => 'nullable|url',
            'social_youtube' => 'nullable|url',
            'social_facebook' => 'nullable|url',
            'social_tiktok' => 'nullable|url',
            'social_twitter' => 'nullable|url',
            'audience_size' => 'required|integer|min:100',
            'niche' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0|max:50',
        ]);

        $user = Auth::user();

        // Check if user already has an influencer profile
        if ($user->influencerProfile) {
            return response()->json([
                'success' => false,
                'message' => 'You already have an influencer application',
                'data' => [
                    'status' => $user->influencerProfile->status
                ]
            ], 400);
        }

        try {
            $influencerProfile = InfluencerProfile::create([
                'user_id' => $user->id,
                'bio' => $request->bio,
                'social_instagram' => $request->social_instagram,
                'social_youtube' => $request->social_youtube,
                'social_facebook' => $request->social_facebook,
                'social_tiktok' => $request->social_tiktok,
                'social_twitter' => $request->social_twitter,
                'audience_size' => $request->audience_size,
                'niche' => $request->niche,
                'experience_years' => $request->experience_years,
                'status' => 'pending',
                'applied_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Influencer application submitted successfully',
                'data' => [
                    'profile' => $influencerProfile,
                    'status' => 'pending'
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit application',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get influencer status for API
     */
    public function status(): JsonResponse
    {
        $user = Auth::user();
        $influencerProfile = $user->influencerProfile;

        if (!$influencerProfile) {
            return response()->json([
                'success' => true,
                'data' => [
                    'has_profile' => false,
                    'status' => null,
                    'can_apply' => true
                ]
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'has_profile' => true,
                'status' => $influencerProfile->status,
                'applied_at' => $influencerProfile->applied_at,
                'approved_at' => $influencerProfile->approved_at,
                'can_apply' => false
            ]
        ]);
    }

    /**
     * Get profile data for API
     */
    public function profile(): JsonResponse
    {
        $user = Auth::user();
        $influencerProfile = $user->influencerProfile;

        if (!$influencerProfile) {
            return response()->json([
                'success' => false,
                'message' => 'No influencer profile found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $influencerProfile
        ]);
    }

}