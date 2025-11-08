<?php

declare(strict_types=1);

use App\Console\Commands;
use Cmsmaxinc\FilamentSystemVersions\Commands\CheckDependencyVersions;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use MeShaon\RequestAnalytics\Models\RequestAnalytics;
use Modules\Monitoring\Commands\CheckVulnerabilitiesCommand;
use Spatie\Backup\Commands\BackupCommand;
use Spatie\Health\Commands as SpatieHealthCommands;

$commandOutputLogPath = storage_path('logs/command_output.log');

Artisan::command('inspire', fn () => $this->comment(Inspiring::quote()));

Schedule::command(SpatieHealthCommands\RunHealthChecksCommand::class)->everyMinute();
Schedule::command(SpatieHealthCommands\DispatchQueueCheckJobsCommand::class)->everyMinute();
Schedule::command(SpatieHealthCommands\ScheduleCheckHeartbeatCommand::class)->everyMinute();
Schedule::command(BackupCommand::class)->daily()
    ->appendOutputTo($commandOutputLogPath);

Schedule::command('telescope:prune --hours=48')->daily();
Schedule::command('sanctum:prune-expired --hours=48')->daily();
Schedule::command('horizon:snapshot')->everyFiveMinutes();
Schedule::command('cache:prune-stale-tags ')->weekly();
Schedule::command(CheckDependencyVersions::class)->everyFiveMinutes();
Schedule::command(CheckVulnerabilitiesCommand::class)->everySixHours()
    ->appendOutputTo($commandOutputLogPath);
//    ->emailOutputOnFailure(admin()->email ?? 'admin@admin.com');

Schedule::command('model:prune')->daily();

Schedule::command(Commands\User\UserSuspendClearCommand::class)->everyFiveMinutes();
/*
Schedule::command('queue:work --tries=2 --stop-when-empty')
    ->before(fn () => cache()->increment('queue:work'))
    ->after(fn () => cache()->decrement('queue:work'))
    ->when(fn () => cache('queue:work') <= 20);
*/

Schedule::command('metrics:commit')->hourly();
Schedule::command('spy:clean', ['--days' => 30])->daily();
Schedule::command('model:prune', [
    '--model' => RequestAnalytics::class,
])->monthly();
