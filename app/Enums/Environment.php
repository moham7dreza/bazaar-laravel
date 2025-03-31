<?php

namespace App\Enums;

enum Environment: string
{
    case PRODUCTION = 'production';
    case DEMO = 'demo';
    case TESTING = 'testing';
    case LOCAL = 'local';
    case LOCALHOST = 'localhost';

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
