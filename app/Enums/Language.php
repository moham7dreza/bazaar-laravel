<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;

enum Language: string
{
    use EnumDataListTrait;

    case FA = 'fa';
    case EN = 'en';

    public function timezone(): string
    {
        return match ($this) {
            self::FA => 'Asia\Tehran',
            self::EN => 'UTC',
        };
    }

    public function flag(): string
    {
        return match ($this) {
            self::FA => asset('images/flags/ir.svg'),
            self::EN => asset('images/flags/usa.svg'),
        };
    }
}
