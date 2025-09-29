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
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('image_path');
            $table->string('icon')->nullable();
            $table->string('color', 7)->default('#3B82F6');
            $table->json('criteria'); // Achievement criteria (posts count, days active, etc.)
            $table->enum('type', ['achievement', 'milestone', 'participation', 'special'])->default('achievement');
            $table->integer('points')->default(0); // Point value for gamification
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['is_active', 'type']);
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badges');
    }
}; 