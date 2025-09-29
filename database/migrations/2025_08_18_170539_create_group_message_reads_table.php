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
        Schema::create('group_message_reads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->constrained('group_messages')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('read_at');
            $table->timestamps();
            
            // Ensure unique combination of message and user
            $table->unique(['message_id', 'user_id']);
            
            // Indexes for better performance
            $table->index(['user_id', 'read_at']);
            $table->index(['message_id', 'read_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_message_reads');
    }
};
