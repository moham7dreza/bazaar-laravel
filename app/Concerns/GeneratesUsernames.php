<?php

declare(strict_types=1);

namespace App\Concerns;

use Illuminate\Support\Str;

trait GeneratesUsernames
{
    /*
    public static function bootGeneratesUsernames(): void
    {
        self::creating(static fn ($model) => $model->username = mb_strtolower(str_replace(' ', '.', $model->name)));
    }
    */

    public static function generateUsername(?string $username): string
    {
        if (null === $username)
        {
            $username = Str::lower(Str::random(8));
        }

        if (self::query()->where('username', $username)->exists())
        {
            $newUsername = $username . Str::lower(Str::random(3));
            $username    = self::username($newUsername);
        }

        return $username;
    }
}
