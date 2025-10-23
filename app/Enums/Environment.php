<?php

declare(strict_types=1);

namespace App\Enums;

enum Environment: string
{
    case PRODUCTION = 'production';
    case STAGING    = 'staging';
    case TESTING    = 'testing';
    case LOCAL      = 'local';
    case LOCALHOST  = 'localhost';

    public static function local(): array
    {
        return [
            self::LOCAL->value,
            self::LOCALHOST->value,
        ];
    }

    public static function localOrTesting(): array
    {
        return [
            self::LOCAL->value,
            self::LOCALHOST->value,
            self::TESTING->value,
        ];
    }
}
