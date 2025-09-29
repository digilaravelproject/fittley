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
        Schema::create('referral_usage', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referral_code_id')->constrained()->onDelete('cascade');
            $table->foreignId('referrer_id')->constrained('users')->onDelete('cascade'); // User who owns the code
            $table->foreignId('referred_user_id')->constrained('users')->onDelete('cascade'); // User who used the code
            $table->foreignId('subscription_id')->constrained('user_subscriptions')->onDelete('cascade');
            $table->decimal('discount_amount', 10, 2);
            $table->decimal('discount_percentage', 5, 2)->nullable();
            $table->string('status')->default('pending'); // pending, applied, expired
            $table->timestamps();

            $table->index(['referrer_id', 'status']);
            $table->index(['referred_user_id', 'status']);
            $table->index('referral_code_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_usage');
    }
}; 