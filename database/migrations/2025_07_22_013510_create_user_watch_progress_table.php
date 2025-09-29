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
        Schema::create('user_watch_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('watchable'); // watchable_type, watchable_id
            $table->integer('progress_seconds')->default(0); // Progress in seconds
            $table->integer('duration_seconds')->default(0); // Total duration in seconds
            $table->decimal('progress_percentage', 5, 2)->default(0.00); // Percentage completed
            $table->boolean('completed')->default(false);
            $table->timestamp('last_watched_at');
            $table->timestamps();

            $table->unique(['user_id', 'watchable_type', 'watchable_id']);
            $table->index(['user_id', 'last_watched_at']);
            $table->index(['user_id', 'completed']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_watch_progress');
    }
};
