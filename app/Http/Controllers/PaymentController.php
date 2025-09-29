<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Exception;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Create payment intent for subscription
     */
    public function createPaymentIntent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan_id' => 'required|exists:subscription_plans,id',
            'payment_method_id' => 'required|string',
            'referral_code' => 'nullable|string|exists:referral_codes,code',
            'influencer_code' => 'nullable|string|exists:influencer_links,tracking_code',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = auth()->user();
            $plan = SubscriptionPlan::findOrFail($request->plan_id);

            // Check if user already has active subscription
            if ($user->hasActiveSubscription()) {
                return response()->json([
                    'success' => false,
                    'error' => 'You already have an active subscription'
                ], 400);
            }

            $options = [
                'payment_method_id' => $request->payment_method_id,
                'referral_code' => $request->referral_code,
                'influencer_code' => $request->influencer_code,
            ];

            $result = $this->paymentService->createSubscription($user, $plan, $options);

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'message' => 'Subscription created successfully',
                    'subscription' => $result['subscription'],
                    'payment_data' => $result['payment_data']
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => $result['error']
                ], 400);
            }

        } catch (Exception $e) {
            Log::error('Payment intent creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Payment processing failed'
            ], 500);
        }
    }

    /**
     * Handle successful payment
     */
    public function paymentSuccess(Request $request)
    {
        $user = auth()->user();
        $subscription = $user->currentSubscription;

        if (!$subscription) {
            return redirect()->route('subscription.plans')
                ->with('error', 'Subscription not found');
        }

        return view('subscription.success', compact('subscription'));
    }

    /**
     * Handle cancelled payment
     */
    public function paymentCancel(Request $request)
    {
        return view('subscription.cancel');
    }

    /**
     * Get payment methods for user
     */
    public function getPaymentMethods(Request $request)
    {
        try {
            $user = auth()->user();
            
            if (!$user->hasStripeId()) {
                return response()->json([
                    'success' => true,
                    'payment_methods' => []
                ]);
            }

            $paymentMethods = $user->paymentMethods();

            return response()->json([
                'success' => true,
                'payment_methods' => $paymentMethods->map(function ($method) {
                    return [
                        'id' => $method->id,
                        'type' => $method->type,
                        'card' => $method->card ? [
                            'brand' => $method->card->brand,
                            'last4' => $method->card->last4,
                            'exp_month' => $method->card->exp_month,
                            'exp_year' => $method->card->exp_year,
                        ] : null,
                    ];
                })
            ]);

        } catch (Exception $e) {
            Log::error('Error fetching payment methods: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Unable to fetch payment methods'
            ], 500);
        }
    }

    /**
     * Add payment method
     */
    public function addPaymentMethod(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_method_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = auth()->user();

            if (!$user->hasStripeId()) {
                $user->createAsStripeCustomer([
                    'name' => $user->name,
                    'email' => $user->email,
                ]);
            }

            $user->addPaymentMethod($request->payment_method_id);

            return response()->json([
                'success' => true,
                'message' => 'Payment method added successfully'
            ]);

        } catch (Exception $e) {
            Log::error('Error adding payment method: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Unable to add payment method'
            ], 500);
        }
    }

    /**
     * Remove payment method
     */
    public function removePaymentMethod(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_method_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = auth()->user();
            $paymentMethod = $user->findPaymentMethod($request->payment_method_id);

            if (!$paymentMethod) {
                return response()->json([
                    'success' => false,
                    'error' => 'Payment method not found'
                ], 404);
            }

            $paymentMethod->delete();

            return response()->json([
                'success' => true,
                'message' => 'Payment method removed successfully'
            ]);

        } catch (Exception $e) {
            Log::error('Error removing payment method: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Unable to remove payment method'
            ], 500);
        }
    }

    /**
     * Calculate pricing with discounts
     */
    public function calculatePricing(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan_id' => 'required|exists:subscription_plans,id',
            'referral_code' => 'nullable|string|exists:referral_codes,code',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $plan = SubscriptionPlan::findOrFail($request->plan_id);
            $originalPrice = $plan->price;
            $finalPrice = $originalPrice;
            $discount = 0;
            $discountAmount = 0;

            // Calculate referral discount
            if ($request->referral_code) {
                $discount = $this->paymentService->calculateReferralDiscount($request->referral_code);
                if ($discount > 0) {
                    $discountAmount = $originalPrice * ($discount / 100);
                    $finalPrice = $originalPrice - $discountAmount;
                }
            }

            return response()->json([
                'success' => true,
                'pricing' => [
                    'original_price' => $originalPrice,
                    'final_price' => $finalPrice,
                    'discount_percentage' => $discount,
                    'discount_amount' => $discountAmount,
                    'currency' => config('payment.gateways.stripe.currency', 'USD'),
                    'trial_days' => $plan->trial_days,
                ]
            ]);

        } catch (Exception $e) {
            Log::error('Error calculating pricing: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Unable to calculate pricing'
            ], 500);
        }
    }
}

/**
 * Stripe Webhook Controller
 */
class StripeWebhookController extends CashierController
{
    /**
     * Handle invoice payment succeeded
     */
    public function handleInvoicePaymentSucceeded($payload)
    {
        Log::info('Stripe invoice payment succeeded', $payload);
        
        // Update subscription status
        $invoice = $payload['data']['object'];
        $customerId = $invoice['customer'];
        
        $user = \App\Models\User::where('stripe_id', $customerId)->first();
        if ($user) {
            $user->updateSubscriptionStatus('active');
            // Send confirmation email
            \App\Jobs\SendSubscriptionConfirmationEmail::dispatch($user);
        }
    }

    /**
     * Handle invoice payment failed
     */
    public function handleInvoicePaymentFailed($payload)
    {
        Log::warning('Stripe invoice payment failed', $payload);
        
        $invoice = $payload['data']['object'];
        $customerId = $invoice['customer'];
        
        $user = \App\Models\User::where('stripe_id', $customerId)->first();
        if ($user) {
            // Handle payment failure (retry, grace period, etc.)
            \App\Jobs\HandlePaymentFailure::dispatch($user, $invoice);
        }
    }

    /**
     * Handle customer subscription deleted
     */
    public function handleCustomerSubscriptionDeleted($payload)
    {
        Log::info('Stripe customer subscription deleted', $payload);
        
        $subscription = $payload['data']['object'];
        $customerId = $subscription['customer'];
        
        $user = \App\Models\User::where('stripe_id', $customerId)->first();
        if ($user) {
            $user->updateSubscriptionStatus('cancelled');
            // Send cancellation email
            \App\Jobs\SendSubscriptionCancellationEmail::dispatch($user);
        }
    }
}
