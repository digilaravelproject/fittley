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
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->json('specializations')->nullable()->after('fitness_goals');
            $table->decimal('hourly_rate', 8, 2)->nullable()->after('specializations');
            $table->integer('years_experience')->nullable()->after('hourly_rate');
            $table->json('languages')->nullable()->after('years_experience');
            $table->json('education')->nullable()->after('languages');
            $table->json('certifications')->nullable()->after('education');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'specializations',
                'hourly_rate',
                'years_experience',
                'languages',
                'education',
                'certifications'
            ]);
        });
    }
};
