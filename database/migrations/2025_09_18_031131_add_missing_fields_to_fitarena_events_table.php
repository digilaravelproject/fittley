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
        Schema::table('fitarena_events', function (Blueprint $table) {
            $table->string('event_type')->nullable()->after('location');
            $table->text('rules')->nullable()->after('event_type');
            $table->text('prizes')->nullable()->after('rules');
            $table->text('sponsors')->nullable()->after('prizes');
            $table->integer('max_participants')->nullable()->after('sponsors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fitarena_events', function (Blueprint $table) {
            $table->dropColumn([
                'event_type',
                'rules', 
                'prizes',
                'sponsors',
                'max_participants'
            ]);
        });
    }
};