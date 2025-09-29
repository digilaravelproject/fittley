<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CommissionTier;

class CommissionTiersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing tiers (delete instead of truncate to handle foreign keys)
        CommissionTier::where('id', '>', 0)->delete();

        // Bronze Tier - Default for new influencers
        CommissionTier::create([
            'name' => 'Bronze',
            'description' => 'Entry level tier for new influencers',
            'min_visits' => 0,
            'min_conversions' => 0,
            'min_revenue' => 0,
            'min_active_days' => 0,
            'commission_percentage' => 5.00,
            'bonus_percentage' => 0.00,
            'has_priority_support' => false,
            'can_create_custom_links' => true,
            'max_custom_links' => 5,
            'gets_analytics_access' => true,
            'maintain_visits_per_month' => null,
            'maintain_conversions_per_month' => null,
            'maintain_revenue_per_month' => null,
            'is_active' => true,
            'sort_order' => 1,
            'color_code' => '#CD7F32',
            'icon' => 'bronze_medal'
        ]);

        // Silver Tier - 50 people signups = 10% commission
        CommissionTier::create([
            'name' => 'Silver',
            'description' => 'Tier for influencers with 50+ successful referrals',
            'min_visits' => 200,
            'min_conversions' => 50,
            'min_revenue' => 15000,
            'min_active_days' => 30,
            'commission_percentage' => 10.00,
            'bonus_percentage' => 2.00,
            'has_priority_support' => false,
            'can_create_custom_links' => true,
            'max_custom_links' => 10,
            'gets_analytics_access' => true,
            'maintain_visits_per_month' => 50,
            'maintain_conversions_per_month' => 10,
            'maintain_revenue_per_month' => 3000,
            'is_active' => true,
            'sort_order' => 2,
            'color_code' => '#C0C0C0',
            'icon' => 'silver_medal'
        ]);

        // Gold Tier - 51-100 people signups = 12% commission
        CommissionTier::create([
            'name' => 'Gold',
            'description' => 'Tier for influencers with 51-100 successful referrals',
            'min_visits' => 500,
            'min_conversions' => 51,
            'min_revenue' => 30000,
            'min_active_days' => 60,
            'commission_percentage' => 12.00,
            'bonus_percentage' => 3.00,
            'has_priority_support' => true,
            'can_create_custom_links' => true,
            'max_custom_links' => 20,
            'gets_analytics_access' => true,
            'maintain_visits_per_month' => 100,
            'maintain_conversions_per_month' => 15,
            'maintain_revenue_per_month' => 5000,
            'is_active' => true,
            'sort_order' => 3,
            'color_code' => '#FFD700',
            'icon' => 'gold_medal'
        ]);

        // Platinum Tier - 100+ people signups = 15% commission
        CommissionTier::create([
            'name' => 'Platinum',
            'description' => 'Premium tier for influencers with 100+ successful referrals',
            'min_visits' => 1000,
            'min_conversions' => 100,
            'min_revenue' => 60000,
            'min_active_days' => 90,
            'commission_percentage' => 15.00,
            'bonus_percentage' => 5.00,
            'has_priority_support' => true,
            'can_create_custom_links' => true,
            'max_custom_links' => null, // Unlimited
            'gets_analytics_access' => true,
            'maintain_visits_per_month' => 200,
            'maintain_conversions_per_month' => 25,
            'maintain_revenue_per_month' => 10000,
            'is_active' => true,
            'sort_order' => 4,
            'color_code' => '#E5E4E2',
            'icon' => 'platinum_medal'
        ]);

        $this->command->info('Created 4 commission tiers with the specified percentages');
    }
}
