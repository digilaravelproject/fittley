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
        Schema::create('fitlive_chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fitlive_session_id')->constrained('fitlive_sessions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('body');
            $table->timestamp('sent_at')->useCurrent();
            $table->timestamps();
            
            $table->index(['fitlive_session_id', 'sent_at']);
            $table->index(['user_id', 'sent_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fitlive_chat_messages');
    }
};
