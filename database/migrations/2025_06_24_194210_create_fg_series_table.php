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
        Schema::create('fg_series', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fg_category_id')->constrained()->onDelete('cascade');
            $table->foreignId('fg_sub_category_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('language', 50);
            $table->decimal('cost', 10, 2)->default(0);
            $table->date('release_date');
            $table->integer('total_episodes')->default(0);
            $table->decimal('feedback', 3, 2)->nullable();
            $table->string('banner_image_path')->nullable();
            $table->integer('views_count')->default(0);
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('shares_count')->default(0);

            // Trailer Video Options
            $table->enum('trailer_type', ['youtube', 's3', 'upload'])->nullable();
            $table->string('trailer_url')->nullable();
            $table->string('trailer_file_path')->nullable();

            $table->boolean('is_published')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('slug');
            $table->index('is_published');
            $table->index('fg_category_id');
            $table->index('fg_sub_category_id');
            $table->index('release_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fg_series');
    }
};
