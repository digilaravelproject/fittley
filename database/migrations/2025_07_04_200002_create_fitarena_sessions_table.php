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
        Schema::create('fitarena_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('fitarena_events')->onDelete('cascade');
            $table->foreignId('stage_id')->constrained('fitarena_stages')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->foreignId('sub_category_id')->nullable()->constrained('sub_categories')->onDelete('set null');
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('speakers')->nullable(); // Array of speaker information
            $table->datetime('scheduled_start');
            $table->datetime('scheduled_end');
            $table->datetime('actual_start')->nullable();
            $table->datetime('actual_end')->nullable();
            $table->enum('status', ['scheduled', 'live', 'ended', 'cancelled'])->default('scheduled');
            $table->string('session_type')->default('presentation'); // presentation, workshop, panel, etc.
            $table->string('recording_url')->nullable();
            $table->boolean('recording_enabled')->default(true);
            $table->string('recording_status')->default('pending'); // pending, recording, completed, failed
            $table->integer('recording_duration')->nullable(); // in seconds
            $table->bigInteger('recording_file_size')->nullable(); // in bytes
            $table->integer('viewer_count')->default(0);
            $table->integer('peak_viewers')->default(0);
            $table->text('materials_url')->nullable(); // Links to presentation materials
            $table->integer('views_count')->default(0);
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('shares_count')->default(0);
            $table->boolean('replay_available')->default(true);
            $table->timestamps();
            
            $table->index(['event_id', 'stage_id', 'scheduled_start']);
            $table->index(['status', 'scheduled_start']);
            $table->index(['event_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fitarena_sessions');
    }
}; 