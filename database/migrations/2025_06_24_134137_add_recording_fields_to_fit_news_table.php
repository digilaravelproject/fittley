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
        Schema::table('fit_news', function (Blueprint $table) {
            $table->string('recording_id')->nullable()->after('recording_url');
            $table->string('recording_status')->nullable()->after('recording_id'); // 'recording', 'completed', 'failed'
            $table->integer('recording_duration')->nullable()->after('recording_status'); // in seconds
            $table->bigInteger('recording_file_size')->nullable()->after('recording_duration'); // in bytes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fit_news', function (Blueprint $table) {
            $table->dropColumn([
                'recording_id',
                'recording_status',
                'recording_duration',
                'recording_file_size'
            ]);
        });
    }
};
