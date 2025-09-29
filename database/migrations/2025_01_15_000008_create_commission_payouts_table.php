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
        Schema::create('commission_payouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('influencer_profile_id')->constrained()->onDelete('cascade');
            $table->string('payout_id')->unique(); // Internal payout reference
            $table->decimal('amount', 12, 2);
            $table->string('status')->default('pending'); // pending, approved, processing, completed, failed, cancelled
            $table->string('payment_method')->nullable(); // bank_transfer, paypal, etc.
            $table->json('payment_details')->nullable(); // Bank details, PayPal email, etc.
            $table->timestamp('requested_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->foreignId('processed_by')->nullable()->constrained('users');
            $table->text('admin_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->string('external_transaction_id')->nullable(); // Bank/PayPal transaction ID
            $table->json('payout_metadata')->nullable(); // Additional processing data
            $table->timestamps();

            $table->index(['influencer_profile_id', 'status']);
            $table->index(['status', 'requested_at']);
            $table->index('payout_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_payouts');
    }
}; 