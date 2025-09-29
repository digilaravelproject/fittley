<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserSubscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\ReferralUsage;
use App\Models\ReferralCode;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller
{
    /**
     * Display subscriptions listing
     */
    public function index(Request $request)
    {
        $subscriptions = UserSubscription::with(['user', 'subscriptionPlan'])
            ->when($request->get('status'), function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->get('search'), function ($query, $search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15);

        $stats = [
            'total' => UserSubscription::count(),
            'active' => UserSubscription::active()->count(),
            'trial' => UserSubscription::trial()->count(),
            'expired' => UserSubscription::expired()->count(),
            'cancelled' => UserSubscription::cancelled()->count(),
        ];

        return view('admin.subscription.subscriptions.index', compact('subscriptions', 'stats'));
    }

    /**
     * Display form to manually add a subscription for a user.
     */
    public function createForm()
    {
        $users = User::orderBy('name')->get();
        $plans = SubscriptionPlan::active()->ordered()->get();
        return view('admin.subscription.subscriptions.create', compact('users', 'plans'));
    }

    /**
     * Show subscription details
     */
    public function show($id)
    {
        $subscription = UserSubscription::with(['user', 'subscriptionPlan', 'referralUsage', 'influencerSale'])
            ->findOrFail($id);

        return view('admin.subscription.subscriptions.show', compact('subscription'));
    }

    /**
     * Cancel subscription
     */
    public function cancel(UserSubscription $subscription)
    {
        try {
            $subscription->cancel();
            
            // Update user subscription status
            $subscription->user->updateSubscriptionStatus('cancelled');

            return redirect()->back()
                ->with('success', 'Subscription cancelled successfully!');
        } catch (\Exception $e) {
            \Log::error('Error cancelling subscription: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error cancelling subscription!');
        }
    }

    /**
     * Reactivate subscription
     */
    public function reactivate(Request $request, UserSubscription $subscription)
    {
        $request->validate([
            'ends_at' => 'required|date|after:today',
        ]);

        try {
            $subscription->renew($request->ends_at);
            
            // Update user subscription status
            $subscription->user->updateSubscriptionStatus('active', $request->ends_at);

            return redirect()->back()
                ->with('success', 'Subscription reactivated successfully!');
        } catch (\Exception $e) {
            \Log::error('Error reactivating subscription: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error reactivating subscription!');
        }
    }

    /**
     * Extend subscription
     */
    public function extend(Request $request, UserSubscription $subscription)
    {
        $request->validate([
            'days' => 'required|integer|min:1|max:365',
        ]);

        try {
            $newEndDate = $subscription->ends_at->addDays($request->days);
            $subscription->update(['ends_at' => $newEndDate]);
            
            // Update user subscription status if needed
            if ($subscription->status === 'expired') {
                $subscription->update(['status' => 'active']);
                $subscription->user->updateSubscriptionStatus('active', $newEndDate);
            }

            return redirect()->back()
                ->with('success', "Subscription extended by {$request->days} days!");
        } catch (\Exception $e) {
            \Log::error('Error extending subscription: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error extending subscription!');
        }
    }

    /**
     * Create manual subscription
     */
    public function createManual(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'payment_method' => 'required|string',
            'amount_paid' => 'required|numeric|min:0',
            'started_at' => 'required|date',
            'ends_at' => 'required|date|after:started_at',
        ]);

        try {
            $subscription = UserSubscription::create([
                'user_id' => $request->user_id,
                'subscription_plan_id' => $request->subscription_plan_id,
                'status' => 'active',
                'amount_paid' => $request->amount_paid,
                'payment_method' => $request->payment_method,
                'transaction_id' => 'MANUAL_' . time(),
                'started_at' => $request->started_at,
                'ends_at' => $request->ends_at,
            ]);

            // Update user subscription status
            $user = User::find($request->user_id);
            $user->updateSubscriptionStatus('active', $request->ends_at);

            return redirect()->route('admin.subscription.subscriptions.index')
                ->with('success', 'Manual subscription created successfully!');
        } catch (\Exception $e) {
            \Log::error('Error creating manual subscription: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error creating manual subscription!')
                ->withInput();
        }
    }

    /**
     * Get subscriptions data for API
     */
    public function apiIndex(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 15);
        
        $subscriptions = UserSubscription::with(['user:id,name,email', 'subscriptionPlan:id,name,price'])
            ->when($request->get('status'), function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->get('user_id'), function ($query, $userId) {
                return $query->where('user_id', $userId);
            })
            ->latest()
            ->paginate($perPage);

        return response()->json($subscriptions);
    }

    /**
     * Get subscription analytics
     */
    public function analytics(Request $request): JsonResponse
    {
        $period = $request->get('period', '30'); // days
        $startDate = now()->subDays($period);

        $data = [
            'subscriptions_created' => UserSubscription::where('created_at', '>=', $startDate)->count(),
            'revenue' => UserSubscription::where('created_at', '>=', $startDate)->sum('amount_paid'),
            'active_subscriptions' => UserSubscription::active()->count(),
            'churn_rate' => $this->calculateChurnRate($startDate),
            'popular_plans' => $this->getPopularPlans($startDate),
            'daily_subscriptions' => $this->getDailySubscriptions($startDate),
        ];

        return response()->json($data);
    }

    /**
     * Calculate churn rate
     */
    private function calculateChurnRate($startDate)
    {
        $totalAtStart = UserSubscription::where('created_at', '<', $startDate)
            ->where('status', 'active')
            ->count();

        $cancelled = UserSubscription::where('cancelled_at', '>=', $startDate)->count();

        return $totalAtStart > 0 ? round(($cancelled / $totalAtStart) * 100, 2) : 0;
    }

    /**
     * Get popular plans
     */
    private function getPopularPlans($startDate)
    {
        return SubscriptionPlan::withCount(['subscriptions' => function ($query) use ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }])
        ->orderByDesc('subscriptions_count')
        ->take(5)
        ->get(['id', 'name', 'price']);
    }

    /**
     * Get daily subscription data
     */
    private function getDailySubscriptions($startDate)
    {
        return UserSubscription::selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(amount_paid) as revenue')
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Show analytics dashboard
     */
    public function analyticsDashboard(Request $request)
    {
        $period = $request->get('range', '30'); // days
        $startDate = now()->subDays($period);

        $data = [
            'subscriptions_created' => UserSubscription::where('created_at', '>=', $startDate)->count(),
            'revenue' => UserSubscription::where('created_at', '>=', $startDate)->sum('amount_paid'),
            'active_subscriptions' => UserSubscription::active()->count(),
            'churn_rate' => $this->calculateChurnRate($startDate),
            'popular_plans' => $this->getPopularPlans($startDate),
            'daily_subscriptions' => $this->getDailySubscriptions($startDate),
        ];

        return view('admin.subscription.analytics', compact('data'));
    }

    /**
     * Show referral analytics dashboard
     */
    public function referralAnalytics(Request $request)
    {
        $period = $request->get('range', '30'); // days
        $startDate = now()->subDays($period);

        $data = [
            'total_referrals' => ReferralUsage::where('created_at', '>=', $startDate)->count(),
            'successful_referrals' => ReferralUsage::where('used_at', '>=', $startDate)->count(),
            'referral_revenue' => UserSubscription::whereHas('referralUsage', function($query) use ($startDate) {
                $query->where('used_at', '>=', $startDate);
            })->sum('amount_paid'),
            'top_referrers' => $this->getTopReferrers($startDate),
            'referral_trends' => $this->getReferralTrends($startDate),
        ];

        return view('admin.subscription.referrals.analytics', compact('data'));
    }

    /**
     * Get top referrers
     */
    private function getTopReferrers($startDate)
    {
        return ReferralCode::withCount(['usages' => function($query) use ($startDate) {
            $query->where('used_at', '>=', $startDate);
        }])
        ->with('user:id,name,email')
        ->orderByDesc('usages_count')
        ->take(10)
        ->get();
    }

    /**
     * Get referral trends
     */
    private function getReferralTrends($startDate)
    {
        return ReferralUsage::selectRaw('DATE(used_at) as date, COUNT(*) as count')
            ->where('used_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Show referrals management page
     */
    public function referrals(Request $request)
    {
        try {
            $referralUsages = ReferralUsage::with(['referralCode.user', 'user', 'subscription.subscriptionPlan'])
                ->latest()
                ->paginate(20);

            $stats = [
                'total_referrals' => ReferralUsage::count(),
                'successful_referrals' => ReferralUsage::whereNotNull('used_at')->count(),
                'total_discount_given' => ReferralUsage::sum('discount_amount'),
                'revenue_from_referrals' => UserSubscription::whereHas('referralUsage')->sum('amount_paid'),
            ];

            return view('admin.subscription.referrals.index', compact('referralUsages', 'stats'));
        } catch (\Exception $e) {
            \Log::error('Error loading referrals: ' . $e->getMessage());
            
            // Return with empty data if there's an error
            $referralUsages = collect()->paginate(20);
            $stats = [
                'total_referrals' => 0,
                'successful_referrals' => 0,
                'total_discount_given' => 0,
                'revenue_from_referrals' => 0,
            ];

            return view('admin.subscription.referrals.index', compact('referralUsages', 'stats'))
                ->with('warning', 'Some referral data may not be available. Please ensure all tables are properly migrated.');
        }
    }
} 