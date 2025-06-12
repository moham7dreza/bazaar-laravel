<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\User;

class UserUpdatedEvent
{
    public array $changes;

    public function __construct(
        public readonly User $user,
    ) {
        $this->changes = $user->getChanges();
    }
}
