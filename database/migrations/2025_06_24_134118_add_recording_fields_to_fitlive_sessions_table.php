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
        Schema::table('fitlive_sessions', function (Blueprint $table) {
            $table->boolean('recording_enabled')->default(false)->after('visibility');
            $table->string('recording_id')->nullable()->after('recording_enabled');
            $table->string('recording_url')->nullable()->after('recording_id');
            $table->string('recording_status')->nullable()->after('recording_url'); // 'recording', 'completed', 'failed'
            $table->integer('recording_duration')->nullable()->after('recording_status'); // in seconds
            $table->bigInteger('recording_file_size')->nullable()->after('recording_duration'); // in bytes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fitlive_sessions', function (Blueprint $table) {
            $table->dropColumn([
                'recording_enabled',
                'recording_id', 
                'recording_url',
                'recording_status',
                'recording_duration',
                'recording_file_size'
            ]);
        });
    }
};
