<?php

declare(strict_types=1);

namespace Modules\Advertise\Notifications;

use App\Enums\Queue;
use App\Http\Middleware\EmailRateLimit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class NewAdPostedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public $id,
    ) {
        $this->onQueue(Queue::Low);
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return new MailMessage()
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        return [

        ];
    }

    public function middleware(): array
    {
        $this->release();

        return [
            new EmailRateLimit(),
        ];
    }
}
