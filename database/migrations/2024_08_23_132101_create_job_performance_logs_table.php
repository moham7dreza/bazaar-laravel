<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_performance_logs', function (Blueprint $table) {
            $table->id();
            $table->string('job');
            $table->string('connection', 99);
            $table->string('queue', 99);
            $table->tinyInteger('attempts')->unsigned();
            $table->unsignedInteger('query_count');
            $table->float('query_time')->unsigned();
            $table->float('runtime')->unsigned()->index();
            $table->unsignedBigInteger('memory_usage')->index();
            $table->dateTime('started_at')->nullable()->index();
            $table->timestamp('created_at')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_performance_logs');
    }
};
