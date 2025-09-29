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
        Schema::create('influencer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('pending'); // pending, approved, rejected, suspended
            $table->string('application_status')->default('draft'); // draft, submitted, under_review, approved, rejected
            $table->text('bio')->nullable();
            $table->string('social_instagram')->nullable();
            $table->string('social_youtube')->nullable();
            $table->string('social_facebook')->nullable();
            $table->string('social_twitter')->nullable();
            $table->string('social_tiktok')->nullable();
            $table->integer('followers_count')->default(0);
            $table->string('niche')->nullable(); // fitness, wellness, lifestyle, etc.
            $table->text('previous_work')->nullable();
            $table->decimal('total_commission_earned', 12, 2)->default(0);
            $table->decimal('total_commission_paid', 12, 2)->default(0);
            $table->decimal('pending_commission', 12, 2)->default(0);
            $table->json('commission_settings')->nullable(); // Custom commission rates if any
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'status']);
            $table->index(['status', 'application_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('influencer_profiles');
    }
}; 