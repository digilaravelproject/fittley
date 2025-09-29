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
        Schema::create('fitarena_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('slug')->unique();
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->string('banner_image')->nullable();
            $table->string('logo')->nullable();
            $table->text('location')->nullable();
            $table->text('event_type')->nullable();
            $table->text('max_participants')->nullable();
            $table->text('sponsors')->nullable();
            $table->text('prizes')->nullable();
            $table->text('rules')->nullable();
            $table->enum('status', ['upcoming', 'live', 'ended'])->default('upcoming');
            $table->enum('visibility', ['public', 'private'])->default('public');
            $table->boolean('dvr_enabled')->default(true);
            $table->integer('dvr_hours')->default(24); // How long content is available after event
            $table->json('organizers')->nullable(); // Event organizer information
            $table->text('schedule_overview')->nullable();
            $table->integer('expected_viewers')->default(0);
            $table->integer('peak_viewers')->default(0);
            $table->integer('views_count')->default(0);
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('shares_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->unsignedBigInteger('instructor_id')->nullable();
            $table->foreign('instructor_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
            
            $table->index(['status', 'visibility', 'start_date']);
            $table->index(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fitarena_events');
    }
}; 