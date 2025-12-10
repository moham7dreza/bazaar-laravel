<?php

declare(strict_types=1);

namespace App\Concerns\Enums;

use BackedEnum;

trait EnumWrappable
{
    public static function wrap(BackedEnum|string|null $enum, bool $strict = true): ?BackedEnum
    {
        if (blank($enum))
        {
            return null;
        }

        if ($enum instanceof BackedEnum)
        {
            return $enum;
        }

        return $strict ? static::from($enum) : static::tryFrom($enum);
    }
}
