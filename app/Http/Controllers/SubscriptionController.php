<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use App\Models\ReferralCode;
use App\Models\ReferralUsage;
use App\Models\InfluencerLink;
use App\Models\InfluencerSale;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    /**
     * Show subscription plans page
     */
    /**
     * Show subscription plans page
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $isUpgrade = false;
        $userSubscription = null;

        if ($user) {
            $hasActivePlan = $user->hasActiveSubscription() || $user->isOnTrial();

            // Check upgrade mode (user clicked "Upgrade Plan")
            if ($hasActivePlan) {
                if ($request->has('upgrade') && $request->get('upgrade') == 1) {
                    // ✅ Allow showing plans for upgrade
                    $isUpgrade = true;
                } else {
                    // ✅ Normal visit with active subscription → redirect
                    return redirect()->route('dashboard')
                        ->with('info', 'You already have an active subscription.');
                }
            }

            // Get the user's current subscription (if any)
            $userSubscription = $user->currentSubscription;
        }

        // ✅ Get all active plans
        $plans = SubscriptionPlan::active()->ordered()->get();

        // ✅ Referral / Influencer data remains the same
        $referralCode = session('referral_code');
        $influencerLink = session('influencer_link');

        return view('subscription.plans', compact(
            'plans',
            'userSubscription',
            'referralCode',
            'influencerLink',
            'isUpgrade'
        ));
    }

    public function index_old(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Redirect users with active subscriptions to dashboard
            if ($user->hasActiveSubscription() || $user->isOnTrial()) {
                return redirect()->route('dashboard')->with('info', 'You already have an active subscription.');
            }

            $userSubscription = $user->currentSubscription;
        }

        $plans = SubscriptionPlan::active()->ordered()->get();

        // Check if user came from referral link
        $referralCode = session('referral_code');
        $influencerLink = session('influencer_link');

        return view('subscription.plans', compact('plans', 'userSubscription', 'referralCode', 'influencerLink'));
    }

    /**
     * Alias for index() – required for the /subscription/plans route.
     */
    public function plans(Request $request)
    {
        return $this->index($request);
    }

    /**
     * Show subscription checkout page
     */
    public function checkout(SubscriptionPlan $plan, Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please login to continue with subscription.');
        }

        $user = Auth::user();

        // Check if user already has active subscription
        if ($user->hasActiveSubscription()) {
            return redirect()->route('user.subscription.manage')
                ->with('info', 'You already have an active subscription.');
        }

        $discountAmount = 0;
        $referralCode = null;
        $influencerLink = null;

        // Check for referral code
        if ($request->has('referral_code') || session('referral_code')) {
            $codeValue = $request->get('referral_code') ?? session('referral_code');
            $referralCode = ReferralCode::findByCode($codeValue);

            if ($referralCode && $referralCode->isValid()) {
                // Use new user discount percentage instead of referrer discount
                $discountPercentage = $referralCode->new_user_discount_percentage;
                $discountAmount = ($plan->price * $discountPercentage) / 100;
            }
        }

        // Check for influencer link
        if (session('influencer_link')) {
            $influencerLink = InfluencerLink::findByCode(session('influencer_link'));
        }

        $finalAmount = $plan->price - $discountAmount;

        return view('subscription.checkout', compact('plan', 'finalAmount', 'discountAmount', 'referralCode', 'influencerLink'));
    }

    /**
     * Process subscription payment
     */
    public function processPayment(Request $request, SubscriptionPlan $plan)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'referral_code' => 'nullable|string',
        ]);

        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Authentication required'], 401);
        }

        $user = Auth::user();

        // Check if user already has active subscription
        if ($user->hasActiveSubscription()) {
            return response()->json(['success' => false, 'message' => 'You already have an active subscription'], 400);
        }

        DB::beginTransaction();

        try {
            $discountAmount = 0;
            $referralUsage = null;
            $influencerSale = null;

            // Handle referral code
            if ($request->referral_code) {
                $referralCode = ReferralCode::findByCode($request->referral_code);

                if ($referralCode && $referralCode->isValid() && $referralCode->user_id !== $user->id) {
                    // Use new user discount percentage for the subscribing user
                    $discountPercentage = $referralCode->new_user_discount_percentage;
                    $discountAmount = ($plan->price * $discountPercentage) / 100;
                }
            }

            $finalAmount = $plan->price - $discountAmount;

            // Create subscription
            $subscription = UserSubscription::create([
                'user_id' => $user->id,
                'subscription_plan_id' => $plan->id,
                'status' => 'active',
                'amount_paid' => $finalAmount,
                'payment_method' => $request->payment_method,
                'transaction_id' => 'TXN_' . time() . '_' . $user->id,
                'started_at' => now(),
                'ends_at' => $this->calculateEndDate($plan),
                'trial_ends_at' => $plan->trial_days > 0 ? now()->addDays($plan->trial_days) : null,
            ]);

            // Update user subscription status
            $user->updateSubscriptionStatus('active', $subscription->ends_at);

            // Handle referral if exists
            if (isset($referralCode) && $discountAmount > 0) {
                $referralUsage = ReferralUsage::create([
                    'referral_code_id' => $referralCode->id,
                    'referrer_id' => $referralCode->user_id,
                    'referred_user_id' => $user->id,
                    'subscription_id' => $subscription->id,
                    'discount_amount' => $discountAmount,
                    'discount_percentage' => ($discountAmount / $plan->price) * 100,
                    'status' => 'applied',
                ]);

                $referralCode->incrementUsage();
            }

            // Handle influencer link if exists
            if (session('influencer_link')) {
                $influencerLink = InfluencerLink::findByCode(session('influencer_link'));

                if ($influencerLink && $influencerLink->isActive()) {
                    $influencerSale = InfluencerSale::createSale(
                        $influencerLink->influencerProfile,
                        $subscription,
                        $influencerLink
                    );

                    $influencerLink->incrementConversions();

                    // Clear influencer link from session
                    session()->forget('influencer_link');
                }
            }

            // Clear referral code from session
            session()->forget('referral_code');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Subscription activated successfully!',
                'subscription_id' => $subscription->id,
                'redirect_url' => route('user.subscription.manage')
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Subscription payment error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Payment processing failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Show user subscription management page
     */
    public function manage()
    {
        $user = Auth::user();
        $currentSubscription = $user->currentSubscription;
        $subscriptionHistory = $user->subscriptions()->with('subscriptionPlan')->latest()->paginate(10);
        $referralCode = $user->getOrCreateReferralCode();
        $referralStats = $this->getReferralStats($user);

        return view('user.subscription.manage', compact(
            'currentSubscription',
            'subscriptionHistory',
            'referralCode',
            'referralStats'
        ));
    }

    /**
     * Cancel subscription
     */
    public function cancel(Request $request)
    {
        $user = Auth::user();
        $subscription = $user->currentSubscription;

        if (!$subscription) {
            return redirect()->back()->with('error', 'No active subscription found.');
        }

        try {
            $subscription->cancel();
            $user->updateSubscriptionStatus('cancelled');

            return redirect()->back()->with('success', 'Subscription cancelled successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error cancelling subscription.');
        }
    }

    /**
     * Apply referral code
     */
    public function applyReferral(Request $request)
    {
        $request->validate([
            'referral_code' => 'required|string',
        ]);

        $referralCode = ReferralCode::findByCode($request->referral_code);

        if (!$referralCode) {
            return response()->json(['success' => false, 'message' => 'Invalid referral code']);
        }

        if (!$referralCode->isValid()) {
            return response()->json(['success' => false, 'message' => 'Referral code is expired or inactive']);
        }

        if (Auth::check() && $referralCode->user_id === Auth::id()) {
            return response()->json(['success' => false, 'message' => 'You cannot use your own referral code']);
        }

        // Store referral code in session
        session(['referral_code' => $request->referral_code]);

        $discountPercentage = $referralCode->discount_percentage;

        return response()->json([
            'success' => true,
            'message' => "Referral code applied! You'll get {$discountPercentage}% discount.",
            'discount_percentage' => $discountPercentage
        ]);
    }

    /**
     * Track influencer link click
     */
    public function trackInfluencerLink($linkCode, Request $request)
    {
        $influencerLink = InfluencerLink::findByCode($linkCode);

        if (!$influencerLink || !$influencerLink->isActive()) {
            return redirect()->route('subscription.plans')
                ->with('error', 'Invalid or expired link.');
        }

        // Track click
        $influencerLink->incrementClicks();

        // Store in session for later conversion tracking
        session(['influencer_link' => $linkCode]);

        return redirect()->to($influencerLink->target_url)
            ->with('success', 'Welcome! You came from a special link.');
    }

    /**
     * Get subscription plans for API
     */
    public function apiPlans(): JsonResponse
    {
        $plans = SubscriptionPlan::active()->ordered()->get();
        return response()->json($plans);
    }

    /**
     * Get user subscription status for API
     */
    public function apiUserSubscription(): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json(['subscription_status' => 'not_logged_in']);
        }

        $user = Auth::user();
        $currentSubscription = $user->currentSubscription;

        $data = [
            'subscription_status' => $user->subscription_status,
            'has_active_subscription' => $user->hasActiveSubscription(),
            'requires_subscription' => $user->requiresSubscription(),
            'can_access_content' => $user->canAccessContent(),
            'subscription_ends_at' => $user->subscription_ends_at,
            'days_remaining' => $user->subscription_days_remaining,
        ];

        if ($currentSubscription) {
            $data['current_subscription'] = $currentSubscription->load('subscriptionPlan');
        }

        return response()->json($data);
    }

    /**
     * Get current user subscription for API
     */
    public function apiCurrent(): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required'
            ], 401);
        }

        $user = Auth::user();
        $currentSubscription = $user->currentSubscription;

        if (!$currentSubscription) {
            return response()->json([
                'success' => true,
                'subscription' => null,
                'message' => 'No active subscription found'
            ]);
        }

        return response()->json([
            'success' => true,
            'subscription' => $currentSubscription->load('subscriptionPlan'),
            'user_status' => $user->getSubscriptionStatus()
        ]);
    }

    /**
     * Get user subscription history for API
     */
    public function apiHistory(Request $request): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required'
            ], 401);
        }

        $user = Auth::user();
        $perPage = $request->get('per_page', 10);

        $subscriptions = $user->subscriptions()
            ->with('subscriptionPlan')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'subscriptions' => $subscriptions
        ]);
    }

    /**
     * Subscribe to a plan via API
     */
    public function apiSubscribe(Request $request): JsonResponse
    {
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
            'payment_method' => 'required|string',
            'referral_code' => 'nullable|string',
        ]);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required'
            ], 401);
        }

        $user = Auth::user();
        $plan = SubscriptionPlan::findOrFail($request->plan_id);

        // Check if user already has active subscription
        if ($user->hasActiveSubscription()) {
            return response()->json([
                'success' => false,
                'message' => 'You already have an active subscription'
            ], 400);
        }

        DB::beginTransaction();

        try {
            $discountAmount = 0;
            $referralUsage = null;

            // Handle referral code
            if ($request->referral_code) {
                $referralCode = ReferralCode::findByCode($request->referral_code);

                if ($referralCode && $referralCode->isValid() && $referralCode->user_id !== $user->id) {
                    $discountPercentage = $referralCode->new_user_discount_percentage ?? 10;
                    $discountAmount = ($plan->price * $discountPercentage) / 100;
                }
            }

            $finalAmount = $plan->price - $discountAmount;

            // Create subscription
            $subscription = UserSubscription::create([
                'user_id' => $user->id,
                'subscription_plan_id' => $plan->id,
                'status' => 'active',
                'amount_paid' => $finalAmount,
                'payment_method' => $request->payment_method,
                'transaction_id' => 'API_TXN_' . time() . '_' . $user->id,
                'started_at' => now(),
                'ends_at' => $this->calculateEndDate($plan),
                'trial_ends_at' => $plan->trial_days > 0 ? now()->addDays($plan->trial_days) : null,
            ]);

            // Create referral usage record if referral code was used
            if ($request->referral_code && isset($referralCode)) {
                $referralUsage = ReferralUsage::create([
                    'referral_code_id' => $referralCode->id,
                    'referred_user_id' => $user->id,
                    'subscription_id' => $subscription->id,
                    'discount_amount' => $discountAmount,
                    'status' => 'completed'
                ]);

                // Update referral code usage count
                $referralCode->increment('usage_count');
            }

            // Update user subscription status
            $user->updateSubscriptionStatus('active', $subscription->ends_at);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Subscription activated successfully!',
                'subscription' => $subscription->load('subscriptionPlan'),
                'discount_applied' => $discountAmount > 0 ? $discountAmount : null
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('API Subscription error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Subscription processing failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Cancel user subscription via API
     */
    public function apiCancel(Request $request): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required'
            ], 401);
        }

        $user = Auth::user();
        $currentSubscription = $user->currentSubscription;

        if (!$currentSubscription) {
            return response()->json([
                'success' => false,
                'message' => 'No active subscription found'
            ], 404);
        }

        try {
            $currentSubscription->cancel();
            $user->updateSubscriptionStatus('cancelled', $currentSubscription->ends_at);

            return response()->json([
                'success' => true,
                'message' => 'Subscription cancelled successfully',
                'subscription' => $currentSubscription->fresh()
            ]);
        } catch (\Exception $e) {
            \Log::error('API Subscription cancellation error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error cancelling subscription'
            ], 500);
        }
    }

    /**
     * Renew subscription via API
     */
    public function apiRenew(Request $request): JsonResponse
    {
        $request->validate([
            'plan_id' => 'sometimes|exists:subscription_plans,id',
            'payment_method' => 'required|string',
        ]);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required'
            ], 401);
        }

        $user = Auth::user();
        $currentSubscription = $user->currentSubscription;

        if (!$currentSubscription) {
            return response()->json([
                'success' => false,
                'message' => 'No subscription found to renew'
            ], 404);
        }

        try {
            $plan = $request->plan_id ?
                SubscriptionPlan::findOrFail($request->plan_id) :
                $currentSubscription->subscriptionPlan;

            $newEndDate = $this->calculateEndDate($plan);

            $currentSubscription->renew($newEndDate, $plan->price);
            $user->updateSubscriptionStatus('active', $newEndDate);

            return response()->json([
                'success' => true,
                'message' => 'Subscription renewed successfully',
                'subscription' => $currentSubscription->fresh()->load('subscriptionPlan')
            ]);
        } catch (\Exception $e) {
            \Log::error('API Subscription renewal error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error renewing subscription'
            ], 500);
        }
    }

    /**
     * Get user referrals for API
     */
    public function apiReferrals(Request $request): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required'
            ], 401);
        }

        $user = Auth::user();
        $referralCode = $user->referralCode;

        if (!$referralCode) {
            return response()->json([
                'success' => true,
                'referrals' => [],
                'stats' => [
                    'total_referrals' => 0,
                    'successful_referrals' => 0,
                    'total_discount_earned' => 0,
                ],
                'message' => 'No referral code found'
            ]);
        }

        $perPage = $request->get('per_page', 10);

        $referrals = $referralCode->usages()
            ->with(['referredUser:id,name,email', 'subscription.subscriptionPlan'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        $stats = $this->getReferralStats($user);

        return response()->json([
            'success' => true,
            'referrals' => $referrals,
            'stats' => $stats,
            'referral_code' => $referralCode
        ]);
    }

    /**
     * Apply referral code via API
     */
    public function apiApplyReferral(Request $request): JsonResponse
    {
        $request->validate([
            'referral_code' => 'required|string',
        ]);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required'
            ], 401);
        }

        $referralCode = ReferralCode::findByCode($request->referral_code);

        if (!$referralCode) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid referral code'
            ], 404);
        }

        if (!$referralCode->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'Referral code is expired or inactive'
            ], 400);
        }

        $user = Auth::user();

        if ($referralCode->user_id === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot use your own referral code'
            ], 400);
        }

        // Store referral code in session for next subscription
        session(['referral_code' => $request->referral_code]);

        return response()->json([
            'success' => true,
            'message' => 'Referral code applied successfully',
            'discount_percentage' => $referralCode->discount_percentage
        ]);
    }

    /**
     * Track influencer link click via API
     */
    public function apiTrackInfluencerLink($linkCode, Request $request): JsonResponse
    {
        $influencerLink = InfluencerLink::findByCode($linkCode);

        if (!$influencerLink || !$influencerLink->isActive()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired link'
            ], 404);
        }

        // Track click
        $influencerLink->incrementClicks();

        // Store in session for later conversion tracking
        session(['influencer_link' => $linkCode]);

        return response()->json([
            'success' => true,
            'message' => 'Link tracked successfully',
            'redirect_url' => $influencerLink->target_url
        ]);
    }

    /**
     * Convert influencer sale via API
     */
    public function apiConvertInfluencerSale(Request $request, $linkCode): JsonResponse
    {
        $request->validate([
            'subscription_id' => 'required|exists:user_subscriptions,id',
            'amount' => 'required|numeric|min:0'
        ]);

        $influencerLink = InfluencerLink::findByCode($linkCode);

        if (!$influencerLink || !$influencerLink->isActive()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired link'
            ], 404);
        }

        try {
            // Create influencer sale record
            $sale = InfluencerSale::create([
                'influencer_link_id' => $influencerLink->id,
                'subscription_id' => $request->subscription_id,
                'amount' => $request->amount,
                'commission_rate' => $influencerLink->commission_rate ?? 10,
                'commission_amount' => ($request->amount * ($influencerLink->commission_rate ?? 10)) / 100,
                'converted_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Conversion tracked successfully',
                'sale' => $sale
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error tracking conversion'
            ], 500);
        }
    }

    /**
     * Check content access via API
     */
    public function apiContentAccessCheck(Request $request): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => true,
                'has_access' => false,
                'message' => 'Authentication required'
            ]);
        }

        $user = Auth::user();

        return response()->json([
            'success' => true,
            'has_access' => $user->hasActiveSubscription(),
            'subscription_status' => $user->subscription_status,
            'subscription_ends_at' => $user->subscription_ends_at
        ]);
    }

    /**
     * Check specific content access via API
     */
    public function apiContentAccess(Request $request, $type, $id): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => true,
                'has_access' => false,
                'message' => 'Authentication required'
            ]);
        }

        $user = Auth::user();
        $hasAccess = $user->hasActiveSubscription();

        // You can add specific content type logic here
        switch ($type) {
            case 'fitdoc':
            case 'fitguide':
            case 'fitnews':
            case 'fitinsight':
            case 'fitlive':
                // For now, all content requires active subscription
                break;
            default:
                $hasAccess = true; // Default to accessible
        }

        return response()->json([
            'success' => true,
            'has_access' => $hasAccess,
            'content_type' => $type,
            'content_id' => $id,
            'subscription_status' => $user->subscription_status
        ]);
    }

    /**
     * Get user's own referral code for API
     */
    public function apiMyReferralCode(Request $request): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required'
            ], 401);
        }

        $user = Auth::user();
        $referralCode = $user->getOrCreateReferralCode();
        $stats = $this->getReferralStats($user);

        return response()->json([
            'success' => true,
            'referral_code' => $referralCode,
            'stats' => $stats,
            'share_url' => url('/subscription/plans?ref=' . $referralCode->code)
        ]);
    }

    /**
     * Validate referral code via API
     */
    public function apiValidateReferralCode($code): JsonResponse
    {
        $referralCode = ReferralCode::findByCode($code);

        if (!$referralCode) {
            return response()->json([
                'success' => false,
                'valid' => false,
                'message' => 'Referral code not found'
            ], 404);
        }

        $isValid = $referralCode->isValid();
        $discountPercentage = $referralCode->new_user_discount_percentage ?? 10;

        return response()->json([
            'success' => true,
            'valid' => $isValid,
            'discount_percentage' => $isValid ? $discountPercentage : 0,
            'message' => $isValid ? 'Valid referral code' : 'Referral code is expired or inactive',
            'referral_code' => $referralCode->code
        ]);
    }

    /**
     * Get public subscription plans (no authentication required)
     */
    public function apiPublicPlans()
    {
        try {
            $plans = SubscriptionPlan::where('is_active', true)
                ->orderBy('price', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $plans
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch subscription plans',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate subscription end date
     */
    private function calculateEndDate(SubscriptionPlan $plan)
    {
        $startDate = now();

        if ($plan->billing_cycle == 'monthly') {
            return $startDate->copy()->addMonth();
        }
        if ($plan->billing_cycle == 'quarterly') {
            return $startDate->copy()->addMonths(3);
        }
        if ($plan->billing_cycle == 'yearly') {
            return $startDate->copy()->addYear();
        }
    }

    /**
     * Get referral statistics for user
     */
    private function getReferralStats($user)
    {
        $referralCode = $user->referralCode;

        if (!$referralCode) {
            return [
                'total_referrals' => 0,
                'successful_referrals' => 0,
                'total_discount_earned' => 0,
                'available_discount_percentage' => 0,
            ];
        }

        $successfulReferrals = $referralCode->successfulUsages()->count();
        $totalDiscountEarned = $referralCode->successfulUsages()->sum('discount_amount');

        return [
            'total_referrals' => $referralCode->usage_count,
            'successful_referrals' => $successfulReferrals,
            'total_discount_earned' => $totalDiscountEarned,
            'available_discount_percentage' => $referralCode->discount_percentage,
        ];
    }
}
