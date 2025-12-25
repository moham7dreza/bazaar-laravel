<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\NotificationChannelInterface;
use App\Services\Notifications\EmailNotification;
use App\Services\Notifications\PushNotification;
use App\Services\Notifications\SmsNotification;
use Illuminate\Support\Arr;

class NotificationService
{
    protected array $channels = [];

    public function __construct(
        public readonly EmailNotification $emailNotification,
        public readonly SmsNotification $smsNotification,
        public readonly PushNotification $pushNotification,
    ) {
        $this->channels = [
            'email' => $emailNotification,
            'sms'   => $smsNotification,
            'push'  => $pushNotification,
        ];
    }

    public function sendVia(string $channel, string $recipient, string $message): bool
    {
        throw_unless(Arr::has($this->channels, $channel));

        /** @var NotificationChannelInterface $channel */
        $channel = Arr::get($this->channels, $channel);

        return $channel->send($recipient, $message);
    }

    public function broadcast(string $recipient, string $message): void
    {
        /** @var NotificationChannelInterface $channel */
        foreach ($this->channels as $channel)
        {
            $channel->send($recipient, $message);
        }
    }
}
