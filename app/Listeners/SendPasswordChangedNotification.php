<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Enums\Queue;
use App\Events\UserUpdatedEvent;
use App\Notifications\PasswordChangedNotification;
use Illuminate\Queue\Middleware\Skip;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Date;

class SendPasswordChangedNotification extends QueuedListener
{
    public function __construct()
    {
        $this->onQueue(Queue::MAIL);
    }

    public function middleware(UserUpdatedEvent $event)
    {
        return [
            Skip::when(fn (): bool => null !== ! Arr::get($event->changes, 'password')),
        ];
    }

    public function shouldQueue(UserUpdatedEvent $event): bool
    {
        return true;
    }

    public function retryUntil()
    {
        return Date::now()->addMinutes(5);
    }

    public function handle(UserUpdatedEvent $event): void
    {
        $event->user->notify(new PasswordChangedNotification($event->user));
    }
}
