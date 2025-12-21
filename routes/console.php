<?php

declare(strict_types=1);

use App\Console\Commands\User\UserSuspendClearCommand;
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

Artisan::call(DeleteExpiredBans::class)->everyMinute();
Artisan::call(CommitMetrics::class)->hourly();
Artisan::call(RunHealthChecksCommand::class)->everyMinute();
Artisan::call(DispatchQueueCheckJobsCommand::class)->everyMinute();
Artisan::call(ScheduleCheckHeartbeatCommand::class)->everyMinute();
Artisan::call(BackupCommand::class)->daily()
    ->appendOutputTo($commandOutputLogPath);
Artisan::call('telescope:prune --hours=48')->daily();
Artisan::call('sanctum:prune-expired --hours=48')->daily();
Artisan::call('horizon:snapshot')->everyFiveMinutes();
Artisan::call('cache:prune-stale-tags ')->weekly();
Artisan::call(CheckDependencyVersions::class)->everyFiveMinutes();
Artisan::call(CheckVulnerabilitiesCommand::class)->everySixHours()
    ->appendOutputTo($commandOutputLogPath);
//  ->emailOutputOnFailure(admin()->email);
Artisan::call('model:prune')->daily();
// @todo:high: remove
Artisan::call(UserSuspendClearCommand::class)->everyFiveMinutes();
Artisan::call('spy:clean', ['--days' => 30])->daily();

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
