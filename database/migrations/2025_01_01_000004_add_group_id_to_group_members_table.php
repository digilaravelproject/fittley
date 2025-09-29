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
        if (Schema::hasTable('group_members')) {
            Schema::table('group_members', function (Blueprint $table) {
                if (!Schema::hasColumn('group_members', 'group_id')) {
                    $table->unsignedBigInteger('group_id')->nullable()->after('id');
                    $table->index('group_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('group_members')) {
            Schema::table('group_members', function (Blueprint $table) {
                if (Schema::hasColumn('group_members', 'group_id')) {
                    $table->dropIndex(['group_id']);
                    $table->dropColumn('group_id');
                }
            });
        }
    }
};