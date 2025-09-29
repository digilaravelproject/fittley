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
        Schema::table('post_likes', function (Blueprint $table) {
            $table->string('post_type')->default('App\\Models\\CommunityPost')->after('user_id');
            $table->unsignedBigInteger('post_id')->after('post_type');
            
            // Add index for polymorphic relationship
            $table->index(['post_type', 'post_id']);
            $table->index(['user_id', 'post_type', 'post_id']);
        });
        
        // Migrate existing data to use new polymorphic structure
        DB::table('post_likes')->update([
            'post_type' => 'App\\Models\\CommunityPost',
            'post_id' => DB::raw('community_post_id')
        ]);
        
        Schema::table('post_likes', function (Blueprint $table) {
            // Drop old foreign key constraint and column
            $table->dropForeign(['community_post_id']);
            $table->dropColumn('community_post_id');
            
            // Update unique constraint to use new columns
            $table->dropUnique(['user_id', 'community_post_id']);
            $table->unique(['user_id', 'post_type', 'post_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_likes', function (Blueprint $table) {
            // Drop new indexes and constraints
            $table->dropIndex(['post_type', 'post_id']);
            $table->dropIndex(['user_id', 'post_type', 'post_id']);
            $table->dropUnique(['user_id', 'post_type', 'post_id']);
            
            // Add back old column
            $table->foreignId('community_post_id')->after('user_id')->constrained()->onDelete('cascade');
        });
        
        // Migrate data back
        DB::table('post_likes')
            ->where('post_type', 'App\\Models\\CommunityPost')
            ->update(['community_post_id' => DB::raw('post_id')]);
        
        Schema::table('post_likes', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn(['post_type', 'post_id']);
            
            // Restore original unique constraint
            $table->unique(['user_id', 'community_post_id']);
        });
    }
};