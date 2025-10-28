<?php

declare(strict_types=1);

namespace App\Broadcasting;

use App\Models\User;

class WhatsappChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {

    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user): array|bool
    {
        return [];
    }
}
