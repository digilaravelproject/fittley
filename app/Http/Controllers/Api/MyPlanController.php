<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserSubscription;
use App\Models\SubscriptionPlan;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MyPlanController extends Controller
{
    /**
     * Get all user's purchased plans
     */
    public function getMyPlans(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $status = $request->get('status', 'all'); // all, active, expired, cancelled
            $perPage = $request->get('per_page', 20);

            $query = UserSubscription::with([
                'subscriptionPlan:id,name,price,features',
                'paymentTransaction',
                'user'
            ])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

            // Filter by status
            switch ($status) {
                case 'active':
                    $query->where('status', 'active')
                          ->where('ends_at', '>', now());
                    break;
                case 'expired':
                    $query->where(function ($q) {
                        $q->where('status', 'expired')
                          ->orWhere('ends_at', '<=', now());
                    });
                    break;
                case 'cancelled':
                    $query->where('status', 'cancelled');
                    break;
                default:
                    // Show all plans
                    break;
            }

            $subscriptions = $query->paginate($perPage);

            $formattedSubscriptions = $subscriptions->getCollection()->map(function ($subscription) {
                return $this->formatSubscriptionData($subscription);
            });

            // Get summary statistics
            $summary = $this->getSubscriptionSummary($user->id);

            return response()->json([
                'success' => true,
                'data' => [
                    'subscriptions' => $formattedSubscriptions,
                    'summary' => $summary,
                    'pagination' => [
                        'current_page' => $subscriptions->currentPage(),
                        'last_page' => $subscriptions->lastPage(),
                        'per_page' => $subscriptions->perPage(),
                        'total' => $subscriptions->total(),
                        'has_more_pages' => $subscriptions->hasMorePages()
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch user plans',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get current active plan
     */
    public function getCurrentPlan(): JsonResponse
    {
        try {
            $user = Auth::user();

            $currentSubscription = UserSubscription::with([
                'subscriptionPlan',
                'paymentTransaction'
            ])
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->where('ends_at', '>', now())
            ->orderBy('ends_at', 'desc')
            ->first();

            if (!$currentSubscription) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'has_active_plan' => false,
                        'message' => 'No active subscription found'
                    ]
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'has_active_plan' => true,
                    'subscription' => $this->formatSubscriptionData($currentSubscription),
                    'days_remaining' => $currentSubscription->ends_at->diffInDays(now()),
                    'auto_renewal' => $currentSubscription->auto_renewal ?? false
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch current plan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get subscription details by ID
     */
    public function getSubscriptionDetails($subscriptionId): JsonResponse
    {
        try {
            $user = Auth::user();

            $subscription = UserSubscription::with([
                'subscriptionPlan',
                'paymentTransaction',
                'user'
            ])
            ->where('id', $subscriptionId)
            ->where('user_id', $user->id)
            ->first();

            if (!$subscription) {
                return response()->json([
                    'success' => false,
                    'message' => 'Subscription not found'
                ], 404);
            }

            $subscriptionData = $this->formatSubscriptionData($subscription);
            
            // Add detailed features
            $subscriptionData['plan']['features'] = $subscription->subscriptionPlan->features ?? [];

            // Add usage statistics if available
            $subscriptionData['usage'] = $this->getUsageStatistics($subscription);

            return response()->json([
                'success' => true,
                'data' => $subscriptionData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch subscription details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available plans for upgrade/purchase
     */
    public function getAvailablePlans(): JsonResponse
    {
        try {
            $user = Auth::user();
            $currentSubscription = UserSubscription::where('user_id', $user->id)
                ->where('status', 'active')
                ->where('ends_at', '>', now())
            ->orderBy('ends_at', 'desc')
                ->first();

            $plans = SubscriptionPlan::where('is_active', true)
                ->orderBy('price', 'asc')
                ->get()
                ->map(function ($plan) use ($currentSubscription) {
                    return [
                        'id' => $plan->id,
                        'name' => $plan->name,
                        'description' => $plan->description,
                        'price' => $plan->price,
                        'currency' => 'INR', // Default currency
                        'billing_cycle' => $plan->billing_cycle,
                        'duration_months' => $plan->duration_months ?? 1,
                        'is_popular' => $plan->is_popular ?? false,
                        'is_current' => $currentSubscription && $currentSubscription->subscription_plan_id === $plan->id,
                        'features' => $plan->features ?? [], // Use features attribute
                        'trial_days' => $plan->trial_days ?? 0,
                        'created_at' => $plan->created_at->format('Y-m-d H:i:s')
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => [
                    'plans' => $plans,
                    'has_active_subscription' => $currentSubscription !== null
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch available plans',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel subscription
     */
    public function cancelSubscription(Request $request, $subscriptionId): JsonResponse
    {
        try {
            $request->validate([
                'reason' => 'nullable|string|max:500',
                'cancel_immediately' => 'nullable|boolean'
            ]);

            $user = Auth::user();

            $subscription = UserSubscription::where('id', $subscriptionId)
                ->where('user_id', $user->id)
                ->where('status', 'active')
                ->first();

            if (!$subscription) {
                return response()->json([
                    'success' => false,
                    'message' => 'Active subscription not found'
                ], 404);
            }

            $cancelImmediately = $request->get('cancel_immediately', false);

            if ($cancelImmediately) {
                $subscription->update([
                    'status' => 'cancelled',
                    'cancelled_at' => now(),
                    'cancellation_reason' => $request->reason,
                    'ends_at' => now() // Immediate cancellation
                ]);
                $message = 'Subscription cancelled immediately';
            } else {
                $subscription->update([
                    'auto_renewal' => false,
                    'cancelled_at' => now(),
                    'cancellation_reason' => $request->reason
                    // Keep ends_at as is - will expire naturally
                ]);
                $message = 'Subscription will not auto-renew and will expire on ' . $subscription->ends_at->format('Y-m-d');
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'subscription_id' => $subscription->id,
                    'status' => $subscription->status,
                    'expires_at' => $subscription->ends_at->format('Y-m-d H:i:s'),
                    'cancelled_at' => $subscription->cancelled_at->format('Y-m-d H:i:s')
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel subscription',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reactivate cancelled subscription
     */
    public function reactivateSubscription($subscriptionId): JsonResponse
    {
        try {
            $user = Auth::user();

            $subscription = UserSubscription::where('id', $subscriptionId)
                ->where('user_id', $user->id)
                ->where('status', 'cancelled')
                ->where('ends_at', '>', now()) // Can only reactivate if not expired
                ->first();

            if (!$subscription) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cancelled subscription not found or already expired'
                ], 404);
            }

            $subscription->update([
                'status' => 'active',
                'auto_renewal' => true,
                'cancelled_at' => null,
                'cancellation_reason' => null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Subscription reactivated successfully',
                'data' => [
                    'subscription_id' => $subscription->id,
                    'status' => $subscription->status,
                    'expires_at' => $subscription->ends_at->format('Y-m-d H:i:s')
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reactivate subscription',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get payment history
     */
    public function getPaymentHistory(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $perPage = $request->get('per_page', 20);

            $payments = PaymentTransaction::with(['userSubscription.subscriptionPlan'])
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);

            $formattedPayments = $payments->getCollection()->map(function ($payment) {
                return [
                    'id' => $payment->id,
                    'amount' => $payment->amount,
                    'currency' => $payment->currency,
                    'status' => $payment->status,
                    'payment_method' => $payment->payment_method,
                    'transaction_id' => $payment->transaction_id,
                    'plan_name' => $payment->userSubscription->subscriptionPlan->name ?? 'Unknown Plan',
                    'payment_date' => $payment->created_at->format('Y-m-d H:i:s'),
                    'payment_date_formatted' => $payment->created_at->format('M d, Y'),
                    'receipt_url' => $payment->receipt_url,
                    'refund_status' => $payment->refund_status,
                    'refunded_amount' => $payment->refunded_amount
                ];
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'payments' => $formattedPayments,
                    'pagination' => [
                        'current_page' => $payments->currentPage(),
                        'last_page' => $payments->lastPage(),
                        'per_page' => $payments->perPage(),
                        'total' => $payments->total(),
                        'has_more_pages' => $payments->hasMorePages()
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch payment history',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Format subscription data for API response
     */
    private function formatSubscriptionData($subscription): array
    {
        $now = now();
        $isActive = $subscription->status === 'active' && $subscription->ends_at > $now;
        $isExpired = $subscription->ends_at <= $now;
        $daysRemaining = $isActive ? $subscription->ends_at->diffInDays($now) : 0;

        return [
            'id' => $subscription->id,
            'status' => $subscription->status,
            'is_active' => $isActive,
            'is_expired' => $isExpired,
            'plan' => [
                'id' => $subscription->subscriptionPlan->id,
                'name' => $subscription->subscriptionPlan->name,
                'description' => $subscription->subscriptionPlan->description,
                'features' => $subscription->subscriptionPlan->features,
                'price' => $subscription->subscriptionPlan->price,
                'currency' => $subscription->subscriptionPlan->currency,
                'billing_cycle' => $subscription->subscriptionPlan->billing_cycle
            ],
            'purchase_date' => $subscription->created_at->format('Y-m-d H:i:s'),
            'purchase_date_formatted' => $subscription->created_at->format('M d, Y'),
            'start_date' => $subscription->started_at->format('Y-m-d H:i:s'),
            'start_date_formatted' => $subscription->started_at->format('M d, Y'),
            'expiry_date' => $subscription->ends_at->format('Y-m-d H:i:s'),
            'expiry_date_formatted' => $subscription->ends_at->format('M d, Y'),
            'days_remaining' => $daysRemaining,
            'auto_renewal' => $subscription->auto_renewal ?? false,
            'payment_info' => $subscription->paymentTransaction ? [
                'amount_paid' => $subscription->paymentTransaction->amount,
                'payment_method' => $subscription->paymentTransaction->payment_method,
                'transaction_id' => $subscription->paymentTransaction->transaction_id,
                'payment_status' => $subscription->paymentTransaction->status
            ] : null,
            'cancelled_at' => $subscription->cancelled_at ? $subscription->cancelled_at->format('Y-m-d H:i:s') : null,
            'cancellation_reason' => $subscription->cancellation_reason
        ];
    }

    /**
     * Get subscription summary statistics
     */
    private function getSubscriptionSummary($userId): array
    {
        $totalSubscriptions = UserSubscription::where('user_id', $userId)->count();
        $activeSubscriptions = UserSubscription::where('user_id', $userId)
            ->where('status', 'active')
            ->where('ends_at', '>', now())
            ->count();
        $expiredSubscriptions = UserSubscription::where('user_id', $userId)
            ->where(function ($q) {
                $q->where('status', 'expired')
                  ->orWhere('ends_at', '<=', now());
            })
            ->count();
        $totalSpent = PaymentTransaction::where('user_id', $userId)
            ->where('status', 'completed')
            ->sum('amount');

        return [
            'total_subscriptions' => $totalSubscriptions,
            'active_subscriptions' => $activeSubscriptions,
            'expired_subscriptions' => $expiredSubscriptions,
            'total_spent' => $totalSpent,
            'currency' => 'USD' // You might want to make this dynamic
        ];
    }

    /**
     * Get usage statistics for subscription
     */
    private function getUsageStatistics($subscription): array
    {
        // This would depend on your specific features and how you track usage
        // Example implementation:
        return [
            'videos_watched' => 0, // Implement based on your tracking
            'live_sessions_attended' => 0,
            'downloads_used' => 0,
            'storage_used' => 0
        ];
    }
}