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
        Schema::create('fitarena_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('fitarena_session_id')->constrained('fitarena_sessions')->onDelete('cascade');
            $table->timestamp('joined_at');
            $table->timestamp('left_at')->nullable();
            $table->integer('duration_seconds')->default(0);
            $table->boolean('completed')->default(false);
            $table->timestamps();
            
            $table->unique(['user_id', 'fitarena_session_id']);
            $table->index(['user_id', 'joined_at']);
            $table->index(['fitarena_session_id', 'joined_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fitarena_participants');
    }
};