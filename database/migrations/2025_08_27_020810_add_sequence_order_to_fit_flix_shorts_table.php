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
        Schema::table('fit_flix_shorts', function (Blueprint $table) {
            if (!Schema::hasColumn('fit_flix_shorts', 'sequence_order')) {
                $table->integer('sequence_order')->default(0)->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fit_flix_shorts', function (Blueprint $table) {
            if (Schema::hasColumn('fit_flix_shorts', 'sequence_order')) {
                $table->dropColumn('sequence_order');
            }
        });
    }
};
