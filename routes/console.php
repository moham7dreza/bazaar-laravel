<?php

declare(strict_types=1);

use Cmsmaxinc\FilamentSystemVersions\Commands\CheckDependencyVersions;
use Cog\Laravel\Ban\Console\Commands\DeleteExpiredBans;
use DirectoryTree\Metrics\Commands\CommitMetrics;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Queue;
use Modules\Monitoring\Commands\CheckVulnerabilitiesCommand;
use Spatie\Backup\Commands\BackupCommand;
use Spatie\Health\Commands\DispatchQueueCheckJobsCommand;
use Spatie\Health\Commands\RunHealthChecksCommand;
use Spatie\Health\Commands\ScheduleCheckHeartbeatCommand;

Artisan::command('inspire', fn () => $this->comment(Inspiring::quote()));

$commandOutputLogPath = storage_path('logs/command_output.log');

Schedule::command(DeleteExpiredBans::class)->everyMinute();
Schedule::command(CommitMetrics::class)->hourly();
Schedule::command(RunHealthChecksCommand::class)->everyMinute();
Schedule::command(DispatchQueueCheckJobsCommand::class)->everyMinute();
Schedule::command(ScheduleCheckHeartbeatCommand::class)->everyMinute();
Schedule::command(BackupCommand::class)->daily()
    ->appendOutputTo($commandOutputLogPath);
Schedule::command('telescope:prune --hours=48')->daily();
Schedule::command('sanctum:prune-expired --hours=48')->daily();
Schedule::command('horizon:snapshot')->everyFiveMinutes();
Schedule::command('cache:prune-stale-tags ')->weekly();
Schedule::command(CheckDependencyVersions::class)->everyFiveMinutes();
Schedule::command(CheckVulnerabilitiesCommand::class)->everySixHours()
    ->appendOutputTo($commandOutputLogPath);
//  ->emailOutputOnFailure(admin()->email);
Schedule::command('model:prune')->daily();
Schedule::command('spy:clean', ['--days' => 30])->daily();

/*
Schedule::command('queue:work --tries=2 --stop-when-empty')
    ->before(fn () => cache()->increment('queue:work'))
    ->after(fn () => cache()->decrement('queue:work'))
    ->when(fn () => cache('queue:work') <= 20);
*/

Schedule::call(function (): void {
    Queue::pause(connection: 'redis', queue: App\Enums\Queue::Backup->value);
})->at('02:00');

Schedule::call(function (): void {
    Queue::resume(connection: 'redis', queue: App\Enums\Queue::Backup->value);
})->at('02:30');
