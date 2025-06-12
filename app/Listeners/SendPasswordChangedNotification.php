<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Enums\Queue;
use App\Events\UserUpdatedEvent;
use Carbon\CarbonImmutable;
use Illuminate\Queue\Middleware\Skip;

class SendPasswordChangedNotification extends QueuedListener
{
    public function __construct()
    {
        $this->onQueue(Queue::MAIL);
    }

    public function middleware(UserUpdatedEvent $event)
    {
        return [
            Skip::when(fn (): bool => ! isset($event->changes['password'])),
        ];
    }

    public function shouldQueue(UserUpdatedEvent $event): bool
    {
        return true;
    }

    public function retryUntil(): CarbonImmutable
    {
        return now()->addMinutes(5);
    }

    public function handle(UserUpdatedEvent $event): void
    {
        $event->user->notify(new \App\Notifications\PasswordChangedNotification($event->user));
    }
}
