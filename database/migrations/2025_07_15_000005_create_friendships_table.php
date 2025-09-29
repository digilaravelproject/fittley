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
        Schema::create('friendships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Who sent the request
            $table->foreignId('friend_id')->constrained('users')->onDelete('cascade'); // Who received the request
            $table->enum('status', ['pending', 'accepted', 'declined', 'blocked'])->default('pending');
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'friend_id']);
            $table->index(['user_id', 'status']);
            $table->index(['friend_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friendships');
    }
}; 