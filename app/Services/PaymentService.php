<?php

namespace App\Services;

use App\Models\User;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use App\Models\ReferralCode;
use App\Models\InfluencerSale;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class PaymentService
{
    protected $gateway;
    
    public function __construct($gateway = null)
    {
        $this->gateway = $gateway ?: config('payment.default');
    }

    /**
     * Create subscription with payment
     */
    public function createSubscription(User $user, SubscriptionPlan $plan, array $options = [])
    {
        try {
            DB::beginTransaction();

            $subscriptionData = [
                'user_id' => $user->id,
                'subscription_plan_id' => $plan->id,
                'status' => 'pending',
                'starts_at' => now(),
                'ends_at' => $this->calculateEndDate($plan),
                'trial_ends_at' => $plan->trial_days > 0 ? now()->addDays($plan->trial_days) : null,
            ];

            // Apply referral discount if provided
            $finalPrice = $plan->price;
            if (isset($options['referral_code'])) {
                $discount = $this->calculateReferralDiscount($options['referral_code']);
                if ($discount > 0) {
                    $finalPrice = $plan->price * (1 - $discount / 100);
                    $subscriptionData['referral_code'] = $options['referral_code'];
                    $subscriptionData['discount_amount'] = $plan->price - $finalPrice;
                    $subscriptionData['discount_percentage'] = $discount;
                }
            }

            $subscriptionData['amount'] = $finalPrice;

            // Create subscription record
            $subscription = UserSubscription::create($subscriptionData);

            // Process payment based on gateway
            $paymentResult = $this->processPayment($user, $finalPrice, $plan, $options);

            if ($paymentResult['success']) {
                $subscription->update([
                    'status' => 'active',
                    'payment_method' => $this->gateway,
                    'payment_id' => $paymentResult['payment_id'],
                    'payment_data' => $paymentResult['payment_data'] ?? null,
                ]);

                // Update user subscription status
                $user->updateSubscriptionStatus('active', $subscription->ends_at);

                // Process referral if applicable
                if (isset($options['referral_code'])) {
                    $this->processReferralUsage($options['referral_code'], $user, $subscription);
                }

                // Track influencer sale if applicable
                if (isset($options['influencer_code'])) {
                    $this->trackInfluencerSale($options['influencer_code'], $user, $subscription);
                }

                DB::commit();
                return ['success' => true, 'subscription' => $subscription, 'payment_data' => $paymentResult];
            } else {
                $subscription->update([
                    'status' => 'failed',
                    'payment_error' => $paymentResult['error'] ?? 'Payment failed',
                ]);
                
                DB::rollBack();
                return ['success' => false, 'error' => $paymentResult['error']];
            }

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Subscription creation failed: ' . $e->getMessage());
            return ['success' => false, 'error' => 'Payment processing failed'];
        }
    }

    /**
     * Process payment based on gateway
     */
    protected function processPayment(User $user, $amount, SubscriptionPlan $plan, array $options = [])
    {
        switch ($this->gateway) {
            case 'stripe':
                return $this->processStripePayment($user, $amount, $plan, $options);
            case 'paypal':
                return $this->processPayPalPayment($user, $amount, $plan, $options);
            case 'razorpay':
                return $this->processRazorpayPayment($user, $amount, $plan, $options);
            default:
                return ['success' => false, 'error' => 'Unsupported payment gateway'];
        }
    }

    /**
     * Process Stripe payment
     */
    protected function processStripePayment(User $user, $amount, SubscriptionPlan $plan, array $options = [])
    {
        try {
            // Create or update customer in Stripe
            if (!$user->hasStripeId()) {
                $user->createAsStripeCustomer([
                    'name' => $user->name,
                    'email' => $user->email,
                ]);
            }

            // Create payment intent
            $paymentIntent = $user->charge(
                $amount * 100, // Convert to cents
                $options['payment_method_id'] ?? null,
                [
                    'metadata' => [
                        'subscription_plan_id' => $plan->id,
                        'user_id' => $user->id,
                        'plan_name' => $plan->name,
                    ],
                ]
            );

            return [
                'success' => true,
                'payment_id' => $paymentIntent->id,
                'payment_data' => [
                    'stripe_payment_intent_id' => $paymentIntent->id,
                    'amount' => $amount,
                    'currency' => config('payment.gateways.stripe.currency'),
                ],
            ];

        } catch (Exception $e) {
            Log::error('Stripe payment failed: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Process PayPal payment (placeholder)
     */
    protected function processPayPalPayment(User $user, $amount, SubscriptionPlan $plan, array $options = [])
    {
        // Implement PayPal integration
        return ['success' => false, 'error' => 'PayPal integration pending'];
    }

    /**
     * Process Razorpay payment (placeholder)
     */
    protected function processRazorpayPayment(User $user, $amount, SubscriptionPlan $plan, array $options = [])
    {
        // Implement Razorpay integration
        return ['success' => false, 'error' => 'Razorpay integration pending'];
    }

    /**
     * Calculate subscription end date
     */
    protected function calculateEndDate(SubscriptionPlan $plan)
    {
        switch ($plan->billing_cycle) {
            case 'monthly':
                return now()->addMonths($plan->billing_cycle_count);
            case 'quarterly':
                return now()->addMonths(3 * $plan->billing_cycle_count);
            case 'yearly':
                return now()->addYears($plan->billing_cycle_count);
            default:
                return now()->addMonth();
        }
    }

    /**
     * Calculate referral discount
     */
    protected function calculateReferralDiscount($referralCode)
    {
        $code = ReferralCode::where('code', $referralCode)->first();
        if (!$code) return 0;

        $referralCount = $code->user->referralsMade()->count();
        $discountTiers = config('payment.referral.discount_tiers');

        foreach ($discountTiers as $count => $discount) {
            if ($referralCount >= $count) {
                $applicableDiscount = $discount;
            }
        }

        return $applicableDiscount ?? 0;
    }

    /**
     * Process referral usage
     */
    protected function processReferralUsage($referralCode, User $referredUser, UserSubscription $subscription)
    {
        $code = ReferralCode::where('code', $referralCode)->first();
        if (!$code) return;

        $code->referralUsage()->create([
            'referred_user_id' => $referredUser->id,
            'referrer_id' => $code->user_id,
            'subscription_id' => $subscription->id,
            'discount_amount' => $subscription->discount_amount,
            'discount_percentage' => $subscription->discount_percentage,
        ]);

        $code->increment('usage_count');
    }

    /**
     * Track influencer sale
     */
    protected function trackInfluencerSale($influencerCode, User $customer, UserSubscription $subscription)
    {
        $link = \App\Models\InfluencerLink::where('tracking_code', $influencerCode)->first();
        if (!$link) return;

        $commissionRate = $this->calculateInfluencerCommission($link->influencerProfile);
        $commissionAmount = $subscription->amount * ($commissionRate / 100);

        InfluencerSale::create([
            'influencer_profile_id' => $link->influencer_profile_id,
            'influencer_link_id' => $link->id,
            'customer_id' => $customer->id,
            'subscription_id' => $subscription->id,
            'sale_amount' => $subscription->amount,
            'commission_rate' => $commissionRate,
            'commission_amount' => $commissionAmount,
            'status' => 'pending_confirmation',
        ]);

        $link->increment('conversion_count');
    }

    /**
     * Calculate influencer commission based on tier
     */
    protected function calculateInfluencerCommission($influencerProfile)
    {
        $salesCount = $influencerProfile->sales()->where('status', 'confirmed')->count();
        $commissionTiers = config('payment.influencer.commission_tiers');

        foreach ($commissionTiers as $salesThreshold => $rate) {
            if ($salesCount <= $salesThreshold) {
                return $rate;
            }
        }

        return 10; // Default rate
    }
}
