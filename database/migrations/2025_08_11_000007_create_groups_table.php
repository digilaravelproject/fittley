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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('creator_id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->boolean('is_private')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('max_members')->nullable();
            $table->integer('member_count')->default(0);
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('community_categories')->onDelete('set null');
            
            $table->index(['is_active']);
            $table->index(['is_private']);
            $table->index(['creator_id']);
            $table->index(['category_id']);
            $table->index(['last_activity_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};