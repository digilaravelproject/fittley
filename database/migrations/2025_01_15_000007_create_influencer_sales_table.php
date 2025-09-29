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
        Schema::create('influencer_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('influencer_profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('influencer_link_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('user_subscription_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->decimal('sale_amount', 10, 2);
            $table->decimal('commission_rate', 5, 2);
            $table->decimal('commission_amount', 10, 2);
            $table->string('status')->default('pending'); // pending, confirmed, cancelled
            $table->string('commission_status')->default('pending'); // pending, calculated, paid
            $table->timestamp('sale_date')->nullable();
            $table->json('sale_metadata')->nullable(); // Additional tracking data
            $table->timestamps();

            $table->index(['influencer_profile_id', 'status']);
            $table->index(['influencer_profile_id', 'commission_status']);
            $table->index(['sale_date', 'status']);
            $table->index('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('influencer_sales');
    }
}; 