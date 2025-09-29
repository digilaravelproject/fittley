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
        Schema::create('referral_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referral_code_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User who used the code
            $table->foreignId('subscription_id')->nullable()->constrained('user_subscriptions')->onDelete('set null');
            $table->decimal('discount_amount', 10, 2);
            $table->decimal('discount_percentage', 5, 2);
            $table->timestamp('used_at');
            $table->timestamps();

            // Indexes
            $table->index(['referral_code_id', 'user_id']);
            $table->index('used_at');
            $table->index('subscription_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_usages');
    }
};
