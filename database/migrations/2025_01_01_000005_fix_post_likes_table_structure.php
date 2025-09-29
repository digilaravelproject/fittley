<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if community_post_id column exists and remove it
        if (Schema::hasColumn('post_likes', 'community_post_id')) {
            Schema::table('post_likes', function (Blueprint $table) {
                // Drop the column directly (no foreign key constraint exists)
                $table->dropColumn('community_post_id');
            });
        }
        
        // Ensure the unique constraint exists for polymorphic fields
        try {
            Schema::table('post_likes', function (Blueprint $table) {
                $table->unique(['user_id', 'post_type', 'post_id'], 'unique_user_post_like');
            });
        } catch (Exception $e) {
            // Constraint might already exist, ignore
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_likes', function (Blueprint $table) {
            // Add back the community_post_id column
            $table->foreignId('community_post_id')->after('user_id')->constrained()->onDelete('cascade');
            
            // Drop the polymorphic unique constraint
            $table->dropUnique('unique_user_post_like');
        });
        
        // Migrate data back to community_post_id
        DB::table('post_likes')
            ->where('post_type', 'App\\Models\\CommunityPost')
            ->update(['community_post_id' => DB::raw('post_id')]);
    }
};