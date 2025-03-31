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
        Schema::create('command_performance_logs', function (Blueprint $table) {
            $table->id();
            $table->string('command');
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
        Schema::dropIfExists('command_performance_logs');
    }
};
