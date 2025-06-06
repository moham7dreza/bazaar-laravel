<?php

declare(strict_types=1);

namespace App\Concerns;

trait GeneratesUsernames
{
    public static function bootGeneratesUsernames(): void
    {
        self::creating(static fn ($model) => $model->username = mb_strtolower(str_replace(' ', '.', $model->name)));
    }
}
