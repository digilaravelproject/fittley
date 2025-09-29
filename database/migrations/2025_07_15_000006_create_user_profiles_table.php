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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Body Stats
            $table->decimal('height', 5, 2)->nullable(); // in cm
            $table->decimal('weight', 5, 2)->nullable(); // in kg
            $table->decimal('body_fat_percentage', 5, 2)->nullable();
            $table->decimal('chest_measurement', 5, 2)->nullable(); // in cm
            $table->decimal('waist_measurement', 5, 2)->nullable(); // in cm
            $table->decimal('hips_measurement', 5, 2)->nullable(); // in cm
            $table->decimal('arms_measurement', 5, 2)->nullable(); // in cm
            $table->decimal('thighs_measurement', 5, 2)->nullable(); // in cm
            
            // Interests and Goals
            $table->json('interests')->nullable(); // Array of interest categories
            $table->json('fitness_goals')->nullable(); // weight_loss, muscle_gain, body_fat_reduction, etc.
            $table->enum('activity_level', ['sedentary', 'lightly_active', 'moderately_active', 'very_active', 'extremely_active'])->nullable();
            $table->text('bio')->nullable();
            $table->string('location')->nullable();
            $table->date('date_of_birth')->nullable();
            
            // Privacy Settings
            $table->boolean('show_body_stats')->default(false);
            $table->boolean('show_goals')->default(true);
            $table->boolean('show_interests')->default(true);
            $table->enum('profile_visibility', ['public', 'friends', 'private'])->default('public');
            
            $table->timestamps();
            
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
}; 