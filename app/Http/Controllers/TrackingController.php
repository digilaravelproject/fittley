<?php

namespace App\Http\Controllers;

use App\Models\InfluencerLink;
use App\Models\ReferralCode;
use App\Models\InfluencerLinkVisit;
use App\Models\ReferralUsage;
use App\Services\TrackingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class TrackingController extends Controller
{
    protected $trackingService;

    public function __construct(TrackingService $trackingService)
    {
        $this->trackingService = $trackingService;
    }

    /**
     * Handle influencer link tracking
     * Route: /inf/{code}
     */
    public function trackInfluencerLink(Request $request, string $code)
    {
        try {
            // Find the influencer link
            $influencerLink = InfluencerLink::where('code', $code)
                                          ->where('is_active', true)
                                          ->first();

            if (!$influencerLink) {
                return redirect()->route('homepage')->with('error', 'Invalid influencer link');
            }

            // Track the visit
            $visit = $this->trackingService->trackInfluencerVisit($influencerLink, $request);

            // Store tracking info in session for signup attribution
            Session::put('influencer_tracking', [
                'link_id' => $influencerLink->id,
                'visit_id' => $visit->id,
                'influencer_id' => $influencerLink->influencerProfile->user_id,
                'tracked_at' => now(),
            ]);

            // Redirect to target URL or subscription plans
            $targetUrl = $influencerLink->target_url ?: route('subscription.plans');
            
            return redirect($targetUrl);

        } catch (\Exception $e) {
            \Log::error('Influencer tracking error: ' . $e->getMessage());
            return redirect()->route('homepage');
        }
    }

    /**
     * Handle referral code tracking
     * Route: /ref/{code}
     */
    public function trackReferralCode(Request $request, string $code)
    {
        try {
            // Track referral code usage
            $referralUsage = $this->trackingService->trackReferralCode($code, $request);

            if (!$referralUsage) {
                return redirect()->route('subscription.plans')
                    ->with('error', 'Invalid or expired referral code');
            }

            // Store referral info in session
            Session::put('referral_tracking', [
                'code' => $code,
                'usage_id' => $referralUsage->id,
                'referrer_id' => $referralUsage->referralCode->user_id,
                'discount_type' => $referralUsage->referralCode->discount_type,
                'discount_value' => $referralUsage->referralCode->discount_value,
                'tracked_at' => now(),
            ]);

            // Redirect to subscription plans with discount info
            return redirect()->route('subscription.plans')
                ->with('referral_discount', [
                    'code' => $code,
                    'type' => $referralUsage->referralCode->discount_type,
                    'value' => $referralUsage->referralCode->discount_value,
                ]);

        } catch (\Exception $e) {
            \Log::error('Referral tracking error: ' . $e->getMessage());
            return redirect()->route('subscription.plans');
        }
    }

    /**
     * API endpoint for tracking page views and time on site
     */
    public function trackPageView(Request $request)
    {
        try {
            $sessionId = Session::getId();

            // Find active visit for this session
            $visit = InfluencerLinkVisit::where('session_id', $sessionId)
                                      ->whereDate('created_at', today())
                                      ->first();

            if ($visit) {
                $visit->updatePageViews();
                
                if ($request->has('time_spent')) {
                    $visit->updateTimeOnSite($request->get('time_spent'));
                }
            }

            return response()->json(['status' => 'tracked']);

        } catch (\Exception $e) {
            \Log::error('Page view tracking error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }

    /**
     * Generate unique influencer link
     */
    public function generateInfluencerLink(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'target_url' => 'nullable|url',
            'custom_code' => 'nullable|string|max:20|unique:influencer_links,code',
        ]);

        try {
            $user = auth()->user();
            
            if (!$user->influencerProfile) {
                return response()->json(['error' => 'Not an approved influencer'], 403);
            }

            // Check tier limits
            $tier = $user->currentCommissionTier;
            if ($tier && !$tier->canUserCreateCustomLinks($user)) {
                return response()->json(['error' => 'Link creation limit reached for your tier'], 403);
            }

            $link = $this->trackingService->generateInfluencerLink($user, [
                'name' => $request->name,
                'target_url' => $request->target_url,
                'custom_code' => $request->custom_code,
            ]);

            return response()->json([
                'link' => $link,
                'message' => 'Influencer link created successfully!'
            ]);

        } catch (\Exception $e) {
            \Log::error('Link generation error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create link'], 500);
        }
    }

    /**
     * Get influencer analytics
     */
    public function getInfluencerAnalytics(Request $request)
    {
        try {
            $user = auth()->user();
            
            if (!$user->influencerProfile) {
                return response()->json(['error' => 'Not an approved influencer'], 403);
            }

            $days = $request->get('days', 30);
            $analytics = $this->trackingService->getInfluencerAnalytics($user, $days);

            return response()->json($analytics);

        } catch (\Exception $e) {
            \Log::error('Analytics error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch analytics'], 500);
        }
    }

    /**
     * Update influencer tier (can be called via cron job)
     */
    public function updateInfluencerTiers()
    {
        try {
            $updatedCount = \App\Models\CommissionTier::updateAllUserTiers();
            
            return response()->json([
                'message' => "Updated {$updatedCount} influencer tiers",
                'updated_count' => $updatedCount
            ]);

        } catch (\Exception $e) {
            \Log::error('Tier update error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update tiers'], 500);
        }
    }

    /**
     * Get commission tiers (for display purposes)
     */
    public function getCommissionTiers()
    {
        try {
            $tiers = \App\Models\CommissionTier::active()
                                             ->orderBy('sort_order')
                                             ->get();

            return response()->json($tiers);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch tiers'], 500);
        }
    }
}
