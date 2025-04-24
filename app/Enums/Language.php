<?php

namespace App\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum Language: string
{
    use EnumDataListTrait;

    case FA = 'fa';
    case EN = 'en';

    public static function default(): array
    {
        return match (app()->getLocale()) {

            self::FA->value => [
                'timezone' => self::FA->timezone(),
                'country' => self::FA->country(),
                'currency' => self::FA->currency(),
                'flag' => self::FA->flag(),
            ],
            self::EN->value => [
                'timezone' => self::EN->timezone(),
                'country' => self::EN->country(),
                'currency' => self::EN->currency(),
                'flag' => self::EN->flag(),
            ],
            default => [],
        };
    }

    public function timezone(): string
    {
        return match ($this) {
            self::FA => 'Asia\Tehran',
            self::EN => 'UTC',
        };
    }

    public function country(): string
    {
        return match ($this) {
            self::FA => 'IR',
            self::EN => 'US',
        };
    }

    public function currency(): string
    {
        return match ($this) {
            self::FA => 'IRT',
            self::EN => 'USD',
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
