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
        Schema::create('commission_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // "Bronze", "Silver", "Gold", "Platinum"
            $table->text('description')->nullable();
            
            // Tier Requirements (OR conditions - any one can trigger tier)
            $table->integer('min_visits')->nullable(); // Minimum visits to achieve this tier
            $table->integer('min_conversions')->nullable(); // Minimum conversions to achieve this tier
            $table->decimal('min_revenue', 12, 2)->nullable(); // Minimum revenue generated
            $table->integer('min_active_days')->nullable(); // Minimum days active
            
            // Commission Rates
            $table->decimal('commission_percentage', 5, 2); // e.g., 10.00 for 10%
            $table->decimal('bonus_percentage', 5, 2)->default(0); // Additional bonus on top
            
            // Special Tier Features
            $table->boolean('has_priority_support')->default(false);
            $table->boolean('can_create_custom_links')->default(false);
            $table->integer('max_custom_links')->nullable();
            $table->boolean('gets_analytics_access')->default(false);
            
            // Tier Maintenance Requirements (to keep the tier)
            $table->integer('maintain_visits_per_month')->nullable();
            $table->integer('maintain_conversions_per_month')->nullable();
            $table->decimal('maintain_revenue_per_month', 10, 2)->nullable();
            
            // Status & Ordering
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0); // For tier hierarchy
            $table->string('color_code', 7)->nullable(); // Hex color for UI
            $table->string('icon')->nullable(); // Icon class or path
            
            $table->timestamps();
            
            // Indexes
            $table->index(['is_active', 'sort_order']);
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_tiers');
    }
};
