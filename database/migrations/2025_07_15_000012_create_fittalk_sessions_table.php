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
        Schema::create('fittalk_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('session_title');
            $table->text('session_description')->nullable();
            $table->enum('session_type', ['chat', 'voice_call', 'video_call'])->default('chat');
            $table->enum('status', ['scheduled', 'active', 'completed', 'cancelled'])->default('scheduled');
            
            // Pricing & Duration
            $table->decimal('chat_rate_per_minute', 8, 2)->default(0); // Rate for chat
            $table->decimal('call_rate_per_minute', 8, 2)->default(0); // Rate for voice/video calls
            $table->integer('free_minutes')->default(5); // Free minutes before payment required
            $table->integer('duration_minutes')->default(0); // Actual session duration
            $table->decimal('total_amount', 8, 2)->default(0); // Total amount charged
            
            // Session Details
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->string('agora_channel')->nullable(); // For voice/video calls
            $table->string('recording_url')->nullable(); // For recorded sessions
            
            // Payment
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->string('payment_intent_id')->nullable();
            
            $table->timestamps();
            
            $table->index(['instructor_id', 'status']);
            $table->index(['user_id', 'status']);
            $table->index(['status', 'scheduled_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fittalk_sessions');
    }
}; 