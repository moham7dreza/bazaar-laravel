<?php

use App\Console\Commands;
use App\Console\Commands\System\CheckVulnerabilitiesCommand;
use Cmsmaxinc\FilamentSystemVersions\Commands\CheckDependencyVersions;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Spatie\Backup\Commands\BackupCommand;
use Spatie\Health\Commands as SpatieHealthCommands;

Artisan::command('inspire', fn () => $this->comment(Inspiring::quote()));

Schedule::command(SpatieHealthCommands\RunHealthChecksCommand::class)->everyMinute();
Schedule::command(SpatieHealthCommands\DispatchQueueCheckJobsCommand::class)->everyMinute();
Schedule::command(SpatieHealthCommands\ScheduleCheckHeartbeatCommand::class)->everyMinute();
Schedule::command(BackupCommand::class)->daily();

Schedule::command('telescope:prune --hours=48')->daily();
Schedule::command('sanctum:prune-expired --hours=48')->daily();
Schedule::command('horizon:snapshot')->everyFiveMinutes();
Schedule::command('cache:prune-stale-tags ')->weekly();
Schedule::command(CheckDependencyVersions::class)->everyFiveMinutes();
Schedule::command(CheckVulnerabilitiesCommand::class)->everySixHours();

Schedule::command('model:prune')->daily();

Schedule::command(Commands\User\UserSuspendClearCommand::class)->everyFiveMinutes();

Schedule::command('queue:work --tries=2 --stop-when-empty')
    ->before(fn () => cache()->increment('queue:work'))
    ->after(fn () => cache()->decrement('queue:work'))
    ->when(fn () => cache('queue:work') <= 20);
