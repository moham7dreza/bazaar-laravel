<?php

declare(strict_types=1);

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Queue;

Artisan::command('inspire', fn () => $this->comment(Inspiring::quote()));

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
