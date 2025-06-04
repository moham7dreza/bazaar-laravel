<?php

declare(strict_types=1);

namespace App\Console\Commands\User;

use App\Jobs\UserSuspendClearJob;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class UserSuspendClearCommand extends Command
{
    protected $signature = 'user:suspend-clear';

    protected $description = 'Automatically lift expired suspensions';

    public function handle(): int
    {
        // lazy collection allow you to process large datasets with minimal memory usage
        // as they load data only when needed
        LazyCollection::make(static function () {

            yield from User::cursor()
                ->whereNotNull('suspended_until')
                ->where('suspended_until', '<=', now());

        })->each(function (User $user): void {

            UserSuspendClearJob::dispatch($user->pluck('id'));
        });

        //        User::query()
        //            ->whereNotNull('suspended_until')
        //            ->where('suspended_until', '<=', now())
        //            ->chunkById(100, function (Collection $users): void {
        //                UserSuspendClearJob::dispatch($users->pluck('id'));
        //            });

        $this->info('Expired suspensions have been lifted.');

        return self::SUCCESS;
    }
}
