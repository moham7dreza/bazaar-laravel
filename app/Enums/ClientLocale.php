<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Concerns\EnumDataListTrait;
use RuntimeException;

enum ClientLocale: string
{
    use EnumDataListTrait;

    case Farsi   = 'fa';
    case English = 'en';

    public const array NUMBER_MAP = [
        1  => self::Farsi,
        2  => self::English,
    ];

    public static function fromNumber(int $number): ?self
    {
        return self::NUMBER_MAP[$number];
    }

    public static function default(): array
    {
        return match (app()->getLocale())
        {

            self::Farsi->value => [
                'timezone' => self::Farsi->timezone(),
                'country'  => self::Farsi->country(),
                'currency' => self::Farsi->currency(),
                'flag'     => self::Farsi->flag(),
            ],
            self::English->value => [
                'timezone' => self::English->timezone(),
                'country'  => self::English->country(),
                'currency' => self::English->currency(),
                'flag'     => self::English->flag(),
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
            self::Farsi   => 'Asia\Tehran',
            self::English => 'UTC',
        };
    }

    public function country(): string
    {
        return match ($this)
        {
            self::Farsi   => 'IR',
            self::English => 'US',
        };
    }

    public function currency(): string
    {
        return match ($this)
        {
            self::Farsi   => 'IRR',
            self::English => 'USD',
        };
    }

    public function flag(): string
    {
        return match ($this)
        {
            self::Farsi   => asset('images/flags/ir.svg'),
            self::English => asset('images/flags/usa.svg'),
        };
    }

    public function label(): string
    {
        return match ($this)
        {
            self::Farsi   => 'fa_IR',
            self::English => 'en_US',
        };
    }
}
