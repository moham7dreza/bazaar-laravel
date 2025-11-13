<?php

declare(strict_types=1);

namespace Modules\Advertise\Jobs;

use App\Jobs\Contracts\ShouldNotifyOnFailures;
use App\Models\User;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Queue\Middleware\ThrottlesExceptions;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Support\Facades\Notification;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Notifications\NewAdPostedNotification;

final class ProcessNewAdvertisementJob implements ShouldQueue, ShouldNotifyOnFailures, ShouldDispatchAfterCommit
{
    use Queueable;

    private Advertisement $advertisement;

    public function __construct(
        public readonly int $id,
    ) {
        $this->advertisement = Advertisement::query()->find($this->id);
    }

    public function middleware(): array
    {
        return [
            new WithoutOverlapping('ad-processing-' . $this->id),
            new RateLimited('ad-notifications'),
            new ThrottlesExceptions(3, 60)->backoff(30),
        ];
    }

    public function handle(): void
    {
//        $followers = $this->advertisement->user->followers;

        $followers = User::all();

        Notification::send($followers, new NewAdPostedNotification($this->id));
    }

    public function tags(): array
    {
        return [
            'process-new-ad',
        ];
    }
}
