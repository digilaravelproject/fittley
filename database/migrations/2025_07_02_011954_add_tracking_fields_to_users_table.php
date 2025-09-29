<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Referral Tracking
            $table->string('referral_source')->nullable(); // 'influencer', 'referral_code', 'organic', 'ads'
            $table->foreignId('referred_by_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('referral_code_id')->nullable()->constrained('referral_codes')->onDelete('set null');
            $table->foreignId('influencer_link_id')->nullable()->constrained('influencer_links')->onDelete('set null');
            
            // Signup Tracking
            $table->string('signup_session_id')->nullable(); // Links to visit session
            $table->ipAddress('signup_ip')->nullable();
            $table->string('signup_user_agent', 500)->nullable();
            $table->json('signup_utm_params')->nullable(); // UTM parameters at signup
            
            // Attribution
            $table->string('first_touch_source')->nullable(); // First marketing channel they came from
            $table->string('last_touch_source')->nullable(); // Last marketing channel before signup
            $table->timestamp('first_visit_at')->nullable();
            $table->integer('visits_before_signup')->default(0);
            
            // Referral Bonus Tracking
            $table->decimal('referral_bonus_earned', 10, 2)->default(0);
            $table->decimal('referral_bonus_given', 10, 2)->default(0); // Bonus given to people they referred
            
            // Influencer Performance (if user becomes influencer)
            $table->foreignId('current_commission_tier_id')->nullable()->constrained('commission_tiers')->onDelete('set null');
            $table->timestamp('tier_achieved_at')->nullable();
            $table->decimal('lifetime_commission_earned', 12, 2)->default(0);
            $table->integer('total_referrals_made')->default(0);
            
            // Indexes for performance
            $table->index(['referral_source', 'created_at']);
            $table->index(['referred_by_user_id', 'created_at']);
            $table->index('current_commission_tier_id');
            $table->index('signup_session_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['referred_by_user_id']);
            $table->dropForeign(['referral_code_id']);
            $table->dropForeign(['influencer_link_id']);
            $table->dropForeign(['current_commission_tier_id']);
            
            $table->dropColumn([
                'referral_source',
                'referred_by_user_id',
                'referral_code_id',
                'influencer_link_id',
                'signup_session_id',
                'signup_ip',
                'signup_user_agent',
                'signup_utm_params',
                'first_touch_source',
                'last_touch_source',
                'first_visit_at',
                'visits_before_signup',
                'referral_bonus_earned',
                'referral_bonus_given',
                'current_commission_tier_id',
                'tier_achieved_at',
                'lifetime_commission_earned',
                'total_referrals_made'
            ]);
        });
    }
};
