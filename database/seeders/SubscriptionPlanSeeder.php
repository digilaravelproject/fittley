<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Basic Monthly Plan
        SubscriptionPlan::updateOrCreate(
            ['slug' => 'basic-monthly'],
            [
                'name' => 'Basic Plan',
                'description' => 'Perfect for individuals starting their fitness journey',
                'price' => 299.00,
                'billing_cycle' => 'monthly',
                'billing_cycle_count' => 1,
                'trial_days' => 7,
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 1,
                'features' => [
                    'Access to all workout videos',
                    'Basic nutrition guides',
                    'Community access',
                    'Mobile app access'
                ],
                'restrictions' => [
                    'max_devices' => 2,
                    'max_downloads' => 10,
                    'max_concurrent_streams' => 1
                ]
            ]
        );

        // Premium Monthly Plan (Popular)
        SubscriptionPlan::updateOrCreate(
            ['slug' => 'premium-monthly'],
            [
                'name' => 'Premium Plan',
                'description' => 'Most popular choice with unlimited access and premium features',
                'price' => 599.00,
                'billing_cycle' => 'monthly',
                'billing_cycle_count' => 1,
                'trial_days' => 14,
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 2,
                'features' => [
                    'All Basic plan features',
                    'Live streaming sessions',
                    'Personal trainer consultations',
                    'Premium nutrition plans',
                    'Fitness tracking integration',
                    'Priority customer support'
                ],
                'restrictions' => [
                    'max_devices' => 5,
                    'max_downloads' => 50,
                    'max_concurrent_streams' => 3
                ]
            ]
        );

        // Pro Quarterly Plan
        SubscriptionPlan::updateOrCreate(
            ['slug' => 'pro-quarterly'],
            [
                'name' => 'Pro Quarterly',
                'description' => 'Save more with quarterly billing - best value for committed users',
                'price' => 1599.00,
                'billing_cycle' => 'monthly',
                'billing_cycle_count' => 3,
                'trial_days' => 14,
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 3,
                'features' => [
                    'All Premium plan features',
                    'Advanced analytics',
                    'Custom workout plans',
                    'Meal planning system',
                    'Progress tracking reports',
                    'Exclusive content access'
                ],
                'restrictions' => [
                    'max_devices' => 8,
                    'max_downloads' => 100,
                    'max_concurrent_streams' => 5
                ]
            ]
        );

        // Annual Plan (Best Value)
        SubscriptionPlan::updateOrCreate(
            ['slug' => 'annual-pro'],
            [
                'name' => 'Annual Pro',
                'description' => 'Ultimate fitness companion with maximum savings and unlimited access',
                'price' => 4999.00,
                'billing_cycle' => 'yearly',
                'billing_cycle_count' => 1,
                'trial_days' => 30,
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 4,
                'features' => [
                    'All Pro plan features',
                    'Unlimited downloads',
                    'Family sharing (up to 4 members)',
                    'VIP community access',
                    'One-on-one sessions with experts',
                    'Wearable device integration',
                    'Exclusive workshops and events'
                ],
                'restrictions' => [
                    'max_devices' => null, // Unlimited
                    'max_downloads' => null, // Unlimited
                    'max_concurrent_streams' => 10,
                    'family_sharing_limit' => 4
                ]
            ]
        );

        // Create Commission Tiers for Influencers
        $this->call(CommissionTiersSeeder::class);
    }
}
