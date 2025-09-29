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
        Schema::create('fg_series_episodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fg_series_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->integer('episode_number');
            $table->integer('duration_minutes')->nullable();

            // Video Options
            $table->enum('video_type', ['youtube', 's3', 'upload']);
            $table->string('video_url')->nullable();
            $table->string('video_file_path')->nullable();

            $table->boolean('is_published')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['fg_series_id', 'episode_number']);
            $table->index('is_published');
            $table->index('slug');
            $table->unique(['fg_series_id', 'episode_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fg_series_episodes');
    }
};
