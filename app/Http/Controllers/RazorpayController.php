<?php

namespace App\Http\Controllers;

use App\Models\ReferralCode;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use Razorpay\Api\Api;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Auth;

class RazorpayController extends Controller
{
    public function createOrder(Request $request)
    {
        $plan = SubscriptionPlan::findOrFail($request->plan_id);
        $user = Auth::user();

        $priceInRupees = $plan->price;

        $referralCode = $request->referral_code ?? null;
        if ($referralCode) {
            $referral = ReferralCode::where('code', $referralCode)->first();
            if ($referral && $referral->is_active) {
                $discountPercent = $referral->discount_percentage ?? 10;
                $discountAmount = round(($priceInRupees * $discountPercent) / 100, 2);
                $priceInRupees -= $discountAmount;
            }
        }

        $priceInPaise = round($priceInRupees * 100);
        if ($priceInPaise < 100) {
            $priceInPaise = 100;
        }

        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        $order = $api->order->create([
            'receipt' => uniqid(),
            'amount' => $priceInPaise,
            'currency' => 'INR',
            'payment_capture' => 1,
        ]);

        return response()->json([
            'order_id' => $order['id'],         // ✅ Correct key
            'razorpay_key' => config('services.razorpay.key'),
            'amount' => $priceInPaise,
            'plan' => $plan
        ]);
    }

    public function paymentSuccess(Request $request)
    {
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        try {
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            $plan = SubscriptionPlan::findOrFail($request->plan_id);
            $user = Auth::user();

            PaymentTransaction::create([
                'user_id' => $user->id,
                'transaction_id' => $request->razorpay_payment_id,
                'payment_method' => 'razorpay',
                'payment_gateway' => 'razorpay',
                'amount' => $plan->price,
                'currency' => 'INR',
                'status' => 'completed',
                'gateway_transaction_id' => $request->razorpay_order_id,
                'gateway_response' => json_encode($request->all()),
                'processed_at' => now()
            ]);

            $durationMonths = $plan->duration_months ?? 1;
            UserSubscription::create([
                'user_id' => $user->id,
                'subscription_plan_id' => $plan->id,
                'status' => 'active',
                'amount_paid' => $plan->price,
                'payment_method' => 'razorpay',
                'transaction_id' => $request->razorpay_payment_id,
                'started_at' => now(),
                'ends_at' => now()->addMonths($durationMonths),
                'subscription_data' => json_encode($request->all())
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment verified and subscription activated.'
            ]);
        } catch (Exception $e) {
            Log::error('Razorpay Payment Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed.'
            ], 400);
        }
    }
}
