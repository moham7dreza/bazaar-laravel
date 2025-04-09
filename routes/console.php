<?php

use App\Console\Commands;
use App\Models\Monitor\CommandPerformanceLog;
use App\Models\Monitor\JobPerformanceLog;
use Cmsmaxinc\FilamentSystemVersions\Commands\CheckDependencyVersions;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Spatie\Backup\Commands\BackupCommand;
use Spatie\Health\Commands as SpatieHealthCommands;
use Spatie\ScheduleMonitor\Models\MonitoredScheduledTaskLogItem;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command(SpatieHealthCommands\RunHealthChecksCommand::class)->everyMinute();
Schedule::command(SpatieHealthCommands\DispatchQueueCheckJobsCommand::class)->everyMinute();
Schedule::command(SpatieHealthCommands\ScheduleCheckHeartbeatCommand::class)->everyMinute();
Schedule::command(BackupCommand::class)->daily();

Schedule::command('telescope:prune --hours=48')->daily();
Schedule::command('horizon:snapshot')->everyFiveMinutes();
Schedule::command(CheckDependencyVersions::class)->daily();

Schedule::command('model:prune --pretend', [
    '--model' => [
        JobPerformanceLog::class,
        CommandPerformanceLog::class,
        MonitoredScheduledTaskLogItem::class,
    ],
])->daily();

Schedule::command(Commands\UserSuspendClearCommand::class)->everyFiveMinutes();
