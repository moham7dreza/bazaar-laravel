<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\User;

class PasswordChangedNotification
{
    /**
     * @param  User  $user
     */
    public function __construct(User $user)
    {
    }
}
