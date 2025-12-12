<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\EnumDataListTrait;
use RuntimeException;

enum ClientDomain: string
{
    use EnumDataListTrait;

    case Staging                = 'https://adhub.dev';

    case ProdIR                 = 'https://www.adhub.ir';

    case ProdApp                = 'https://adhub.app';

    case Local                  = 'http://localhost:3000';

    case LocalAdminPanel        = 'http://localhost:3000/admin';

    case LocalSuperAdminPanel   = 'http://adhub.local/super-admin';

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
            self::Local   => 'http://adhub.local',
            self::Staging => 'http://staging.adhub.dev',
            default       => 'https://api.adhub.ir',
        };
    }

    public function backendApi(): string
    {
        return $this->backendUrl() . '/api';
    }
}
