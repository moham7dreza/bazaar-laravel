<?php

declare(strict_types=1);

namespace App\Contracts;

interface NotificationChannelInterface
{
    public function send(string $recipient, string $message): bool;
}
