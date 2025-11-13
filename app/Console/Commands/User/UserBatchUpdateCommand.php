<?php

declare(strict_types=1);

namespace App\Console\Commands\User;

use App\Jobs\UserUpdateJob;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\LazyCollection;
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
            ->map(fn (LazyCollection $users): UserUpdateJob => new UserUpdateJob($users->pluck('id')->all()))
            ->chunk(200); // Group jobs into batches of 200

        // Now dispatch each batch of 200 jobs
        $jobs->each(function (LazyCollection $jobBatch): void {
            Bus::batch($jobBatch)
                ->name('User Processing Batch')
                ->allowFailures()
                ->dispatch();

            info('Dispatched batch of 200 jobs');
        });

        info('All job batches dispatched successfully');

        return self::SUCCESS;
    }
}
