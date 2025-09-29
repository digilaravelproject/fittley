<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use App\Models\InfluencerProfile;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class FittellyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure roles exist
        $this->createRoles();
        
        // Create users with different profiles
        $users = $this->createUsers();
        
        // Allocate subscription plans to users
        $this->allocateSubscriptionPlans($users);
        
        // Create influencer profiles
        $this->createInfluencers($users);
        
        // Create instructor users
        $this->createInstructors();
    }
    
    /**
     * Create necessary roles if they don't exist
     */
    private function createRoles(): void
    {
        $roles = ['admin', 'instructor', 'influencer', 'user'];
        
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }
    }
    
    /**
     * Create test users with different profiles
     */
    private function createUsers(): array
    {
        $users = [];
        
        // Basic User
        $users['basic'] = User::updateOrCreate(
            ['email' => 'basic.user@fittelly.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password123'),
                'phone' => '+91-9876543210',
                'date_of_birth' => '1990-05-15',
                'gender' => 'male',
                'preferences' => ['yoga', 'cardio'],
                'email_verified_at' => now(),
            ]
        );
        $users['basic']->assignRole('user');
        
        // Premium User
        $users['premium'] = User::updateOrCreate(
            ['email' => 'premium.user@fittelly.com'],
            [
                'name' => 'Jane Smith',
                'password' => Hash::make('password123'),
                'phone' => '+91-9876543211',
                'date_of_birth' => '1985-08-22',
                'gender' => 'female',
                'preferences' => ['pilates', 'strength_training'],
                'email_verified_at' => now(),
            ]
        );
        $users['premium']->assignRole('user');
        
        // Future Influencer User
        $users['influencer1'] = User::updateOrCreate(
            ['email' => 'influencer1@fittelly.com'],
            [
                'name' => 'Alex Johnson',
                'password' => Hash::make('password123'),
                'phone' => '+91-9876543212',
                'date_of_birth' => '1992-03-10',
                'gender' => 'male',
                'preferences' => ['weightlifting', 'crossfit'],
                'email_verified_at' => now(),
            ]
        );
        $users['influencer1']->assignRole(['user', 'influencer']);
        
        // Future Influencer User 2
        $users['influencer2'] = User::updateOrCreate(
            ['email' => 'influencer2@fittelly.com'],
            [
                'name' => 'Sarah Wilson',
                'password' => Hash::make('password123'),
                'phone' => '+91-9876543213',
                'date_of_birth' => '1988-11-05',
                'gender' => 'female',
                'preferences' => ['yoga', 'pilates'],
                'email_verified_at' => now(),
            ]
        );
        $users['influencer2']->assignRole(['user', 'influencer']);
        
        // Admin User
        $users['admin'] = User::updateOrCreate(
            ['email' => 'admin@fittelly.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'),
                'phone' => '+91-9876543214',
                'date_of_birth' => '1980-01-01',
                'gender' => 'male',
                'preferences' => ['all'],
                'email_verified_at' => now(),
            ]
        );
        $users['admin']->assignRole('admin');
        
        return $users;
    }
    
    /**
     * Allocate subscription plans to users
     */
    private function allocateSubscriptionPlans(array $users): void
    {
        // Get existing subscription plans
        $plans = SubscriptionPlan::active()->orderBy('sort_order')->get();
        
        if ($plans->isEmpty()) {
            echo "No subscription plans found. Please run SubscriptionPlanSeeder first.\n";
            return;
        }
        
        // Use existing plans
        $basicPlan = $plans->where('slug', 'basic-monthly')->first() ?? $plans->first();
        $premiumPlan = $plans->where('slug', 'premium-monthly')->first() ?? $plans->skip(1)->first() ?? $basicPlan;
        $proPlan = $plans->where('slug', 'pro-quarterly')->first() ?? $premiumPlan;
        $annualPlan = $plans->where('slug', 'annual-pro')->first() ?? $proPlan;
        
        // Allocate Basic Plan to Basic User
        UserSubscription::updateOrCreate(
            [
                'user_id' => $users['basic']->id,
                'subscription_plan_id' => $basicPlan->id,
            ],
            [
                'status' => 'active',
                'amount_paid' => $basicPlan->price,
                'payment_method' => 'credit_card',
                'transaction_id' => 'TXN_BASIC_' . time(),
                'started_at' => now(),
                'ends_at' => now()->addMonth(),
                'trial_ends_at' => now()->addDays(7),
            ]
        );
        
        // Allocate Premium Plan to Premium User
        UserSubscription::updateOrCreate(
            [
                'user_id' => $users['premium']->id,
                'subscription_plan_id' => $premiumPlan->id,
            ],
            [
                'status' => 'active',
                'amount_paid' => $premiumPlan->price,
                'payment_method' => 'upi',
                'transaction_id' => 'TXN_PREMIUM_' . time(),
                'started_at' => now(),
                'ends_at' => now()->addMonth(),
                'trial_ends_at' => now()->addDays(14),
            ]
        );
        
        // Allocate Pro Plan to Influencer 1
        UserSubscription::updateOrCreate(
            [
                'user_id' => $users['influencer1']->id,
                'subscription_plan_id' => $proPlan->id,
            ],
            [
                'status' => 'active',
                'amount_paid' => $proPlan->price,
                'payment_method' => 'net_banking',
                'transaction_id' => 'TXN_PRO_' . time(),
                'started_at' => now(),
                'ends_at' => now()->addMonths(3),
                'trial_ends_at' => now()->addDays(14),
            ]
        );
        
        // Allocate Annual Plan to Influencer 2
        UserSubscription::updateOrCreate(
            [
                'user_id' => $users['influencer2']->id,
                'subscription_plan_id' => $annualPlan->id,
            ],
            [
                'status' => 'active',
                'amount_paid' => $annualPlan->price,
                'payment_method' => 'credit_card',
                'transaction_id' => 'TXN_ANNUAL_' . time(),
                'started_at' => now(),
                'ends_at' => now()->addYear(),
                'trial_ends_at' => now()->addDays(30),
            ]
        );
    }
    
    /**
     * Create influencer profiles
     */
    private function createInfluencers(array $users): void
    {
        // Create Influencer Profile 1
        InfluencerProfile::updateOrCreate(
            ['user_id' => $users['influencer1']->id],
            [
                'status' => 'approved',
                'application_status' => 'approved',
                'bio' => 'Fitness enthusiast with 5+ years of experience in strength training and CrossFit. Helping people achieve their fitness goals through proper form and motivation.',
                'social_instagram' => 'https://instagram.com/alexjohnson_fit',
                'social_youtube' => 'https://youtube.com/c/AlexJohnsonFitness',
                'social_facebook' => 'https://facebook.com/alexjohnsonfit',
                'followers_count' => 25000,
                'niche' => 'strength_training,crossfit,muscle_building',
                'previous_work' => 'Personal trainer at Gold\'s Gym, Fitness influencer on Instagram',
                'total_commission_earned' => 5000.00,
                'total_commission_paid' => 3000.00,
                'pending_commission' => 2000.00,
                'commission_settings' => [
                    'rate' => 10,
                    'payment_method' => 'bank_transfer',
                    'minimum_payout' => 1000
                ],
                'approved_at' => now()->subDays(30),
                'approved_by' => $users['admin']->id,
            ]
        );
        
        // Create Influencer Profile 2
        InfluencerProfile::updateOrCreate(
            ['user_id' => $users['influencer2']->id],
            [
                'status' => 'approved',
                'application_status' => 'approved',
                'bio' => 'Certified yoga instructor and wellness coach. Specializing in mindful movement, flexibility, and holistic health approaches.',
                'social_instagram' => 'https://instagram.com/sarahwilson_yoga',
                'social_youtube' => 'https://youtube.com/c/SarahWilsonYoga',
                'social_tiktok' => 'https://tiktok.com/@sarahwilsonyoga',
                'followers_count' => 18000,
                'niche' => 'yoga,pilates,flexibility,wellness',
                'previous_work' => 'Certified yoga instructor (RYT-500), Wellness coach, Studio owner',
                'total_commission_earned' => 3500.00,
                'total_commission_paid' => 2500.00,
                'pending_commission' => 1000.00,
                'commission_settings' => [
                    'rate' => 12,
                    'payment_method' => 'upi',
                    'minimum_payout' => 500
                ],
                'approved_at' => now()->subDays(45),
                'approved_by' => $users['admin']->id,
            ]
        );
    }
    
    /**
     * Create instructor users
     */
    private function createInstructors(): void
    {
        // Instructor 1
        $instructor1 = User::updateOrCreate(
            ['email' => 'instructor1@fittelly.com'],
            [
                'name' => 'Mike Rodriguez',
                'password' => Hash::make('instructor123'),
                'phone' => '+91-9876543215',
                'date_of_birth' => '1985-07-12',
                'gender' => 'male',
                'preferences' => ['strength_training', 'cardio', 'functional_fitness'],
                'email_verified_at' => now(),
            ]
        );
        $instructor1->assignRole(['user', 'instructor']);
        
        // Instructor 2
        $instructor2 = User::updateOrCreate(
            ['email' => 'instructor2@fittelly.com'],
            [
                'name' => 'Lisa Chen',
                'password' => Hash::make('instructor123'),
                'phone' => '+91-9876543216',
                'date_of_birth' => '1990-02-28',
                'gender' => 'female',
                'preferences' => ['yoga', 'pilates', 'meditation', 'nutrition'],
                'email_verified_at' => now(),
            ]
        );
        $instructor2->assignRole(['user', 'instructor']);
    }
}