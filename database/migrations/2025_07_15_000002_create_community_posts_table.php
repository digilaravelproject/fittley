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
        Schema::create('community_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('community_category_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('community_group_id')->nullable();
            $table->text('content');
            $table->json('images')->nullable(); // Array of image paths
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('shares_count')->default(0);
            $table->boolean('is_achievement')->default(false);
            $table->boolean('is_challenge')->default(false);
            $table->enum('visibility', ['public', 'friends', 'group'])->default('public');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['community_category_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index(['community_group_id', 'created_at']);
            $table->index(['is_active', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_posts');
    }
}; 