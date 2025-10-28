<?php

declare(strict_types=1);

namespace App\Console\Commands\User;

use App\Jobs\UserUpdateJob;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Sleep;
use Symfony\Component\Console\Attribute\AsCommand;

use function Laravel\Prompts\info;

#[AsCommand(name: 'user:batch-update', description: 'batch update users')]
final class UserBatchUpdateCommand extends Command
{
    public function handle(): int
    {
        $jobs = User::query()
            ->select('id')
            ->lazyById(100, 'id') // Get 100 users at a time from DB
            ->chunk(100) // Group into chunks of 100 users
            ->map(fn ($chunk) => new UserUpdateJob($chunk->pluck('id')->toArray()))
            ->chunk(200); // Group jobs into batches of 200

        // Now dispatch each batch of 200 jobs
        $jobs->each(function ($jobBatch): void {
            Bus::batch($jobBatch)
                ->name('User Processing Batch')
                ->allowFailures()
                ->dispatch();

            info('Dispatched batch of 200 jobs');

            Sleep::sleep(1);
        });

        info('All job batches dispatched successfully');

        return self::SUCCESS;
    }
}
