<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Enums\ClientLocale;
use App\Models\User;

class ClientLocaleService
{
    public static function getUserLocaleWithFallback(User $user): ClientLocale
    {
        return $user->getLocale() ?? ClientLocale::EN->value;
    }
}
