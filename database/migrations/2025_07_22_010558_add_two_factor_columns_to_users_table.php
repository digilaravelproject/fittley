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
            $table->string('google2fa_secret')->nullable()->after('remember_token');
            $table->boolean('google2fa_enabled')->default(false)->after('google2fa_secret');
            $table->json('recovery_codes')->nullable()->after('google2fa_enabled');
            $table->timestamp('two_factor_confirmed_at')->nullable()->after('recovery_codes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['google2fa_secret', 'google2fa_enabled', 'recovery_codes', 'two_factor_confirmed_at']);
        });
    }
};
