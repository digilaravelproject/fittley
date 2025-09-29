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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('subscription_required')->default(true)->after('password');
            $table->timestamp('subscription_ends_at')->nullable()->after('subscription_required');
            $table->string('subscription_status')->default('inactive')->after('subscription_ends_at'); // active, inactive, trial, expired
            $table->string('phone')->nullable()->after('email');
            $table->date('date_of_birth')->nullable()->after('phone');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('date_of_birth');
            $table->json('preferences')->nullable()->after('avatar'); // User preferences for content
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'subscription_required',
                'subscription_ends_at', 
                'subscription_status',
                'phone',
                'date_of_birth',
                'gender',
                'preferences'
            ]);
        });
    }
}; 