<?php

namespace App\Console\Commands;

use App\Jobs\UserSuspendClearJob;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class UserSuspendClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:suspend-clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically lift expired suspensions';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        User::query()
            ->whereNotNull('suspended_until')
            ->where('suspended_until', '<=', now())
            ->chunkById(100, function (Collection $users) {
                UserSuspendClearJob::dispatch($users->pluck('id'));
            });

        $this->info('Expired suspensions have been lifted.');

        return self::SUCCESS;
    }
}
