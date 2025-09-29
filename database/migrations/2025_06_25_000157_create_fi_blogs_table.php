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
        Schema::create('fi_blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fi_category_id')->constrained('fi_categories')->onDelete('cascade');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            
            // Basic Content Fields
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable(); // Short description
            $table->longText('content'); // Main blog content (HTML)
            $table->string('featured_image_path')->nullable(); // Banner/featured image
            $table->text('featured_image_alt')->nullable(); // Alt text for featured image
            
            // SEO Fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();
            $table->text('social_image_path')->nullable(); // Open Graph image
            $table->text('social_title')->nullable(); // Open Graph title
            $table->text('social_description')->nullable(); // Open Graph description
            
            // Publishing & Status
            $table->enum('status', ['draft', 'published', 'scheduled', 'archived'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            
            // Engagement & Analytics
            $table->integer('views_count')->default(0);
            $table->integer('likes_count')->default(0);
            $table->integer('shares_count')->default(0);
            $table->decimal('reading_time', 5, 2)->nullable(); // Estimated reading time in minutes
            
            // Content Settings
            $table->boolean('allow_comments')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_trending')->default(false);
            $table->integer('sort_order')->default(0);
            
            // Tags (JSON field for flexibility)
            $table->json('tags')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for performance
            $table->index(['fi_category_id', 'status', 'published_at']);
            $table->index(['status', 'is_featured', 'published_at']);
            $table->index(['status', 'is_trending', 'published_at']);
            $table->index('slug');
            $table->index('published_at');
            $table->index('author_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fi_blogs');
    }
};
