<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Monitoring\Enums\CommandLoggingStatus;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('command_performance_logs', static function (Blueprint $table) {

            $table->dropIndex('command_performance_logs_started_at_index');
            $table->dropIndex('command_performance_logs_memory_usage_index');

            // move started_at -> created_at
            // move created_at -> updated_at
            $table->renameColumn('created_at', 'created_at_temp');
            $table->renameColumn('started_at', 'created_at');
            $table->renameColumn('created_at_temp', 'updated_at');

            $table->enum('status', CommandLoggingStatus::values())->default(CommandLoggingStatus::Completed->value)->after('command');
            $table->json('inputs')->nullable()->after('memory_usage');
        });
    }

    public function down(): void
    {
        Schema::table('command_performance_logs', static function (Blueprint $table) {

            $table->renameColumn('updated_at', 'created_at_temp');
            $table->renameColumn('created_at', 'started_at');
            $table->renameColumn('created_at_temp', 'created_at');

            $table->index('started_at');
            $table->index('memory_usage');

            $table->dropColumn([
                'status',
                'inputs',
            ]);
        });
    }
};
