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
        Schema::create('content_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('ratable'); // ratable_type, ratable_id
            $table->tinyInteger('rating')->unsigned(); // 1-5 stars
            $table->text('review')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->json('helpful_votes')->nullable(); // Array of user IDs who found it helpful
            $table->integer('helpful_count')->default(0);
            $table->timestamps();

            $table->unique(['user_id', 'ratable_type', 'ratable_id']);
            $table->index(['ratable_type', 'ratable_id', 'rating']);
            $table->index(['rating']);
            $table->index(['is_featured']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_ratings');
    }
};
