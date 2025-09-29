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
        Schema::create('fitlive_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('sub_category_id')->nullable()->constrained('sub_categories')->onDelete('set null');
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->enum('status', ['scheduled', 'live', 'ended'])->default('scheduled');
            $table->enum('chat_mode', ['during', 'after', 'off'])->default('during');
            $table->enum('session_type', ['daily', 'one_time'])->default('during');
            $table->string('livekit_room')->nullable()->unique();
            $table->string('hls_url')->nullable();
            $table->string('mp4_path')->nullable();
            $table->string('banner_image')->nullable();
            $table->integer('viewer_peak')->default(0);
            $table->integer('views_count')->default(0);
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('shares_count')->default(0);
            $table->enum('visibility', ['public', 'private'])->default('public');
            $table->timestamps();
            
            $table->index(['status', 'visibility', 'scheduled_at']);
            $table->index(['category_id', 'status']);
            $table->index(['instructor_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fitlive_sessions');
    }
};
