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
        Schema::create('influencer_link_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('influencer_link_id')->constrained('influencer_links')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Set after signup
            
            // Tracking Information
            $table->string('session_id')->index(); // Track unique sessions
            $table->ipAddress('ip_address');
            $table->text('user_agent')->nullable();
            $table->string('referrer_url', 500)->nullable();
            $table->json('utm_parameters')->nullable(); // UTM source, medium, campaign, etc.
            
            // Geographic/Device Info
            $table->string('country', 2)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('device_type', 50)->nullable(); // mobile, desktop, tablet
            $table->string('browser', 100)->nullable();
            $table->string('os', 100)->nullable();
            
            // Conversion Tracking
            $table->boolean('is_converted')->default(false); // Did they sign up?
            $table->timestamp('converted_at')->nullable();
            $table->foreignId('subscription_id')->nullable()->constrained('user_subscriptions')->onDelete('set null');
            $table->decimal('conversion_value', 10, 2)->nullable(); // Value of conversion
            
            // Visit Details
            $table->integer('page_views')->default(1); // How many pages they viewed in this session
            $table->integer('time_on_site')->nullable(); // Seconds spent on site
            $table->timestamp('last_activity')->nullable();
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['influencer_link_id', 'created_at']);
            $table->index(['session_id', 'ip_address']);
            $table->index(['is_converted', 'converted_at']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('influencer_link_visits');
    }
};
