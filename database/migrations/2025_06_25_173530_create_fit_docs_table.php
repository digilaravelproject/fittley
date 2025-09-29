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
        Schema::create('fit_docs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('type', ['single', 'series']);
            $table->text('description');
            $table->string('language', 50);
            $table->decimal('cost', 10, 2)->default(0);
            $table->date('release_date');
            $table->integer('duration_minutes')->nullable(); // For single videos
            $table->integer('total_episodes')->nullable(); // For series
            $table->decimal('feedback', 3, 2)->nullable();
            $table->string('banner_image_path')->nullable();

            // Trailer Video Options
            $table->enum('trailer_type', ['youtube', 's3', 'upload'])->nullable();
            $table->string('trailer_url')->nullable();
            $table->string('trailer_file_path')->nullable();

            // Main Video Options (for single videos only)
            $table->enum('video_type', ['youtube', 's3', 'upload'])->nullable();
            $table->string('video_url')->nullable();
            $table->string('video_file_path')->nullable();

            $table->integer('views_count')->default(0);
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('shares_count')->default(0);

            $table->boolean('is_published')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('slug');
            $table->index('type');
            $table->index('is_published');
            $table->index('release_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fit_docs');
    }
};
