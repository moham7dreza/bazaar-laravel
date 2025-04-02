<?php

namespace App\Enums;

enum Language: string
{
    case FA = 'fa';
    case EN = 'en';

    public function timezone(): string
    {
        return match ($this) {
            self::FA => 'Asia\Tehran',
            self::EN => 'UTC',
        };
    }
}
