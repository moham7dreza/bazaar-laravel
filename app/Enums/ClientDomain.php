<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Concerns\EnumDataListTrait;
use RuntimeException;

enum ClientDomain: string
{
    use EnumDataListTrait;

    case Staging                = 'https://bazaar.dev';
    case ProdIR                 = 'https://www.bazaar.ir';
    case ProdApp                = 'https://bazaar.app';
    case Local                  = 'http://localhost:3000';
    case LocalAdminPanel        = 'http://localhost:3000/admin';
    case LocalSuperAdminPanel   = 'http://bazaar.local/super-admin';

    public const array NUMBER_MAP = [
        1  => self::Staging,
        10 => self::ProdIR,
        11 => self::ProdApp,
        20 => self::Local,
        21 => self::LocalAdminPanel,
        22 => self::LocalSuperAdminPanel,
    ];

    public static function fromNumber(int $number): ?self
    {
        return self::NUMBER_MAP[$number];
    }

    public function toNumber(): int
    {
        $key = array_search($this, self::NUMBER_MAP, true);

        return false !== $key ? $key : throw new RuntimeException('Case is missing in NUMBER_MAP: ' . $this->value);
    }

    public function backendUrl(): string
    {
        return match ($this)
        {
            self::Local   => 'http://bazaar.local',
            self::Staging => 'http://staging.bazaar.dev',
            default       => 'https://api.bazaar.ir',
        };
    }

    public function backendApi(): string
    {
        return $this->backendUrl() . '/api';
    }
}
