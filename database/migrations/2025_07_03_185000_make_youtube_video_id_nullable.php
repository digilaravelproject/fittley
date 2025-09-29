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
        Schema::table('homepage_heroes', function (Blueprint $table) {
            $table->string('youtube_video_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('homepage_heroes', function (Blueprint $table) {
            $table->string('youtube_video_id')->nullable(false)->change();
        });
    }
}; 