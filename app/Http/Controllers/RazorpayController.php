<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use Razorpay\Api\Api;
use Carbon\Carbon;
use Exception;

class RazorpayController extends Controller
{
    /**
     * Create Razorpay Order
     */
    public function createOrder(Request $request)
    {
        try {
            $user = Auth::user();
            $plan = SubscriptionPlan::findOrFail($request->plan_id);

            // Prevent downgrade or same plan if user is upgrading
            $active = $user->currentSubscription;
            if ($active && $active->status === 'active') {
                $currentPrice = $active->plan->price ?? $active->amount_paid;
                if ($plan->price <= $currentPrice) {
                    return response()->json(['success' => false, 'message' => 'You cannot downgrade or repurchase the same plan.']);
                }
            }

            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

            $order = $api->order->create([
                'receipt' => 'order_' . time(),
                'amount' => $plan->price * 100, // Amount in paise
                'currency' => 'INR'
            ]);

            return response()->json([
                'success' => true,
                'razorpay_key' => config('services.razorpay.key'),
                'order_id' => $order['id'],
                'amount' => $order['amount']
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Confirm Razorpay Payment
     */
    public function paymentSuccess(Request $request)
    {
        try {
            $user = Auth::user();
            $plan = SubscriptionPlan::findOrFail($request->plan_id);

            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

            // ✅ 1. Verify Razorpay Signature
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            // ✅ 2. Expire previous active subscription (if any)
            if ($user->hasActiveSubscription()) {
                $user->currentSubscription->update([
                    'status' => 'expired',
                    'ends_at' => now()
                ]);
            }

            // ✅ 3. Calculate new subscription dates
            $startDate = now();

            if ($plan->trial_days > 0) {
                // User gets trial first
                $status = 'trial';
                $trialEnd = $startDate->copy()->addDays($plan->trial_days);

                // End date starts AFTER trial
                $endDate = $trialEnd->copy()->addMonths($plan->duration_months);
            } else {
                // No trial → Active immediately
                $status = 'active';
                $trialEnd = null;
                $endDate = $startDate->copy()->addMonths($plan->duration_months);
            }

            // ✅ 4. Create new subscription record
            $subscription = UserSubscription::create([
                'user_id' => $user->id,
                'subscription_plan_id' => $plan->id,
                'status' => $status,
                'amount_paid' => $plan->price,
                'payment_method' => 'razorpay',
                'transaction_id' => $request->razorpay_payment_id,
                'gateway_subscription_id' => $request->razorpay_order_id,
                'started_at' => $startDate,
                'trial_ends_at' => $trialEnd,
                'ends_at' => $endDate,
                'subscription_data' => json_encode($request->all())
            ]);

            return response()->json([
                'success'   => true,
                'message'   => 'Subscription activated!',
                'data'      => $subscription
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Confirm Razorpay Payment
     */
    public function confirmPayment(Request $request)
    {
        try {
            $user = Auth::user();
            $plan = SubscriptionPlan::findOrFail($request->plan_id);

            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

            // Verify the signature
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            // If user already has active subscription → expire it before adding new
            if ($user->hasActiveSubscription()) {
                $user->currentSubscription->update([
                    'status' => 'expired',
                    'ends_at' => Carbon::now()
                ]);
            }

            // Calculate start/end/trial dates
            $startDate = Carbon::now();
            $endDate = $startDate->copy()->addMonths($plan->duration_months);
            $trialEnd = $plan->trial_days > 0 ? $startDate->copy()->addDays($plan->trial_days) : null;

            // Create new subscription record
            $subscription = UserSubscription::create([
                'user_id' => $user->id,
                'subscription_plan_id' => $plan->id,
                'status' => 'active',
                'amount_paid' => $plan->price,
                'payment_method' => 'razorpay',
                'transaction_id' => $request->razorpay_payment_id,
                'gateway_subscription_id' => $request->razorpay_order_id,
                'started_at' => $startDate,
                'ends_at' => $endDate,
                'trial_ends_at' => $trialEnd,
                'subscription_data' => json_encode($request->all())
            ]);

            return response()->json(['success' => true, 'message' => 'Subscription activated!', 'data' => $subscription]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Payment verification failed: ' . $e->getMessage()]);
        }
    }
}
