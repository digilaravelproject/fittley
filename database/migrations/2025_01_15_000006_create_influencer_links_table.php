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
        Schema::create('influencer_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('influencer_profile_id')->constrained()->onDelete('cascade');
            $table->string('link_code', 50)->unique();
            $table->string('campaign_name')->nullable();
            $table->text('description')->nullable();
            $table->string('target_url')->default('/subscription'); // Where the link redirects
            $table->integer('clicks_count')->default(0);
            $table->integer('conversions_count')->default(0);
            $table->decimal('conversion_rate', 5, 2)->default(0); // Calculated field
            $table->boolean('is_active')->default(true);
            $table->timestamp('expires_at')->nullable();
            $table->json('tracking_params')->nullable(); // UTM parameters, etc.
            $table->timestamps();

            $table->index(['link_code', 'is_active']);
            $table->index(['influencer_profile_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('influencer_links');
    }
}; 