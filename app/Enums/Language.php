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
            self::FA => asset('img/flags/ir.svg'),
            self::EN => asset('img/flags/usa.svg'),
        };
    }

    public static function flagsList(): array
    {
        return [
            self::FA->value => asset('img/flags/ir.svg'),
            self::EN->value => asset('img/flags/usa.svg'),
        ];
    }
}
