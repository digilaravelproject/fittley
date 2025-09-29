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
        Schema::table('community_posts', function (Blueprint $table) {
            if (!Schema::hasColumn('community_posts', 'is_flagged')) {
                $table->boolean('is_flagged')->default(false)->after('is_active');
                $table->timestamp('flagged_at')->nullable()->after('is_flagged');
                $table->text('flag_reason')->nullable()->after('flagged_at');
                $table->unsignedBigInteger('flagged_by')->nullable()->after('flag_reason');
                $table->boolean('is_featured')->default(false)->after('flagged_by');
                $table->boolean('is_published')->default(true)->after('is_featured');
                
                $table->index(['is_flagged', 'created_at']);
                $table->index(['is_featured', 'created_at']);
                $table->index(['is_published', 'created_at']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('community_posts', function (Blueprint $table) {
            $columns = ['is_flagged', 'flagged_at', 'flag_reason', 'flagged_by', 'is_featured', 'is_published'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('community_posts', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
