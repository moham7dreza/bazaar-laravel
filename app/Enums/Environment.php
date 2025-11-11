<?php

declare(strict_types=1);

namespace App\Enums;

enum Environment: string
{
    case Production = 'production';
    case Staging    = 'staging';
    case Testing    = 'testing';
    case Local      = 'local';
    case Localhost  = 'localhost';

    public static function local(): array
    {
        return [
            self::Local->value,
            self::Localhost->value,
        ];
    }

    public static function localOrTesting(): array
    {
        return [
            self::Local->value,
            self::Localhost->value,
            self::Testing->value,
        ];
    }
}
