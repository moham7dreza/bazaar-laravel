<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum ClientLocale: string
{
    use EnumDataListTrait;

    case FA = 'fa';
    case EN = 'en';

    public const array NUMBER_MAP = [
        1  => self::FA,
        2  => self::EN,
    ];

    public static function fromNumber(int $number): ?self
    {
        return self::NUMBER_MAP[$number];
    }

    public static function default(): array
    {
        return match (app()->getLocale())
        {

            self::FA->value => [
                'timezone' => self::FA->timezone(),
                'country'  => self::FA->country(),
                'currency' => self::FA->currency(),
                'flag'     => self::FA->flag(),
            ],
            self::EN->value => [
                'timezone' => self::EN->timezone(),
                'country'  => self::EN->country(),
                'currency' => self::EN->currency(),
                'flag'     => self::EN->flag(),
            ],
            default => [],
        };
    }

    public function toNumber(): int
    {
        $key = array_search($this, self::NUMBER_MAP, true);

        return false !== $key ? $key : throw new RuntimeException('Case is missing in NUMBER_MAP: ' . $this->value);
    }

    public function timezone(): string
    {
        return match ($this)
        {
            self::FA => 'Asia\Tehran',
            self::EN => 'UTC',
        };
    }

    public function country(): string
    {
        return match ($this)
        {
            self::FA => 'IR',
            self::EN => 'US',
        };
    }

    public function currency(): string
    {
        return match ($this)
        {
            self::FA => 'IRT',
            self::EN => 'USD',
        };
    }

    public function flag(): string
    {
        return match ($this)
        {
            self::FA => asset('images/flags/ir.svg'),
            self::EN => asset('images/flags/usa.svg'),
        };
    }

    public function label(): string
    {
        return match ($this)
        {
            self::FA => 'fa_IR',
            self::EN => 'en_US',
        };
    }
}
