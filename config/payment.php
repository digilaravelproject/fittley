<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Payment Gateway
    |--------------------------------------------------------------------------
    */
    'default' => env('PAYMENT_GATEWAY', 'stripe'),

    /*
    |--------------------------------------------------------------------------
    | Payment Gateways
    |--------------------------------------------------------------------------
    */
    'gateways' => [
        'stripe' => [
            'key' => env('STRIPE_KEY'),
            'secret' => env('STRIPE_SECRET'),
            'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
            'currency' => env('CASHIER_CURRENCY', 'USD'),
            'currency_locale' => env('CASHIER_CURRENCY_LOCALE', 'en_US'),
        ],
        
        'paypal' => [
            'client_id' => env('PAYPAL_CLIENT_ID'),
            'client_secret' => env('PAYPAL_CLIENT_SECRET'),
            'mode' => env('PAYPAL_MODE', 'sandbox'), // sandbox or live
            'currency' => env('PAYPAL_CURRENCY', 'USD'),
        ],
        
        'razorpay' => [
            'key_id' => env('RAZORPAY_KEY_ID'),
            'key_secret' => env('RAZORPAY_KEY_SECRET'),
            'currency' => env('RAZORPAY_CURRENCY', 'INR'),
            'webhook_secret' => env('RAZORPAY_WEBHOOK_SECRET'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment URLs
    |--------------------------------------------------------------------------
    */
    'urls' => [
        'success' => env('PAYMENT_SUCCESS_URL', '/subscription/success'),
        'cancel' => env('PAYMENT_CANCEL_URL', '/subscription/cancel'),
        'webhook' => [
            'stripe' => '/webhooks/stripe',
            'paypal' => '/webhooks/paypal',
            'razorpay' => '/webhooks/razorpay',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Subscription Configuration
    |--------------------------------------------------------------------------
    */
    'subscription' => [
        'grace_period_days' => 3, // Grace period after payment failure
        'trial_days' => [
            'default' => 7,
            'premium' => 14,
        ],
        'proration_behavior' => 'create_prorations', // How to handle plan changes
    ],

    /*
    |--------------------------------------------------------------------------
    | Referral Configuration
    |--------------------------------------------------------------------------
    */
    'referral' => [
        'discount_tiers' => [
            2 => 20, // 2 referrals = 20% discount
            3 => 25, // 3 referrals = 25% discount
            4 => 30, // 4+ referrals = 30% discount
        ],
        'max_discount' => 30, // Maximum discount percentage
    ],

    /*
    |--------------------------------------------------------------------------
    | Influencer Configuration
    |--------------------------------------------------------------------------
    */
    'influencer' => [
        'commission_tiers' => [
            50 => 10,   // 0-50 sales = 10% commission
            100 => 12,  // 51-100 sales = 12% commission
            999999 => 15, // 101+ sales = 15% commission
        ],
        'minimum_payout' => 50, // Minimum amount for payout ($50)
        'payout_schedule' => 'monthly', // monthly, weekly, bi-weekly
    ],
]; 