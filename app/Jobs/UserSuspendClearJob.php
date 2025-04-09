<?php

namespace App\Jobs;

use App\Enums\Queue;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Collection;

class UserSuspendClearJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Collection $ids,
    ) {
        $this->onQueue(Queue::LOW);
    }

    public function handle(): void
    {
        User::query()
            ->whereIn('id', $this->ids->toArray())
            ->update([
                'suspended_until' => null,
            ]);
    }

    public function tags(): array
    {
        return [
            'user-suspend-clear',
        ];
    }
}
