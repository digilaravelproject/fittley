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
        Schema::create('community_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('rules')->nullable();
            $table->string('tags');
            $table->string('cover_image')->nullable();
            $table->foreignId('community_category_id')->constrained()->onDelete('cascade');
            $table->foreignId('admin_user_id')->constrained('users')->onDelete('cascade'); // Group admin
            $table->integer('max_members')->default(1000);
            $table->integer('members_count')->default(0);
            $table->enum('join_type', ['open', 'approval_required', 'invite_only'])->default('open');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['community_category_id', 'is_active']);
            $table->index(['admin_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_groups');
    }
}; 