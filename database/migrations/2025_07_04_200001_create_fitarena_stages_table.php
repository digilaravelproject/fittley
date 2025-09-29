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
        Schema::create('fitarena_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('fitarena_events')->onDelete('cascade');
            $table->string('name'); // e.g., "Main Stage", "Yoga Stage", "Nutrition Stage"
            $table->text('description')->nullable();
            $table->string('color_code', 7)->default('#d4ab00'); // Hex color for UI
            $table->integer('capacity')->nullable(); // Max concurrent viewers
            $table->string('livekit_room')->nullable()->unique();
            $table->string('stream_key')->nullable();
            $table->string('rtmp_url')->nullable();
            $table->string('hls_url')->nullable();
            $table->enum('status', ['scheduled', 'live', 'ended', 'break'])->default('scheduled');
            $table->boolean('is_primary')->default(false); // Main stage indicator
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['event_id', 'status']);
            $table->index(['event_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fitarena_stages');
    }
}; 