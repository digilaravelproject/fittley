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
        Schema::table('fg_series', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['fg_sub_category_id']);
            
            // Modify the column to be nullable
            $table->unsignedBigInteger('fg_sub_category_id')->nullable()->change();
            
            // Re-add the foreign key constraint with nullable support
            $table->foreign('fg_sub_category_id')->references('id')->on('fg_sub_categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fg_series', function (Blueprint $table) {
            // Drop the nullable foreign key constraint
            $table->dropForeign(['fg_sub_category_id']);
            
            // Modify the column back to not nullable (this might fail if there are null values)
            $table->unsignedBigInteger('fg_sub_category_id')->nullable(false)->change();
            
            // Re-add the original foreign key constraint
            $table->foreign('fg_sub_category_id')->references('id')->on('fg_sub_categories')->onDelete('cascade');
        });
    }
};
