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
        Schema::create('homepage_heroes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('youtube_video_id'); // YouTube video ID
            $table->string('play_button_text')->default('PLAY NOW');
            $table->string('play_button_link')->nullable();
            $table->string('trailer_button_text')->default('WATCH TRAILER');
            $table->string('trailer_button_link')->nullable();
            $table->string('category')->nullable(); // e.g., "ABS", "CARDIO", etc.
            $table->string('duration')->nullable(); // e.g., "20 min"
            $table->integer('year')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homepage_heroes');
    }
};
