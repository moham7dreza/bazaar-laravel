<?php

declare(strict_types=1);

namespace App\Services\Notifications;

use App\Contracts\NotificationChannelInterface;
use Override;

class SmsNotification implements NotificationChannelInterface
{
    #[Override]
    public function send(string $recipient, string $message): bool
    {
        return true;
    }
}
