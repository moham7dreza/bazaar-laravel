<?php

namespace App\Enums;

use App\Enums\Concerns\EnumDataListTrait;
use RuntimeException;

enum ClientDomain: string
{
    use EnumDataListTrait;

    public const array NUMBER_MAP = [
        1 => self::Staging,
        10 => self::ProdIR,
        11 => self::ProdApp,
        20 => self::Local,
    ];

    // staging
    case Staging = 'https://bazaar.dev';
    // prod
    case ProdIR = 'https://www.bazaar.ir';
    case ProdApp = 'https://bazaar.app';
    // local
    case Local = 'http://localhost:3000';

    public static function fromNumber(int $number): ?self
    {
        return self::NUMBER_MAP[$number];
    }

    public function toNumber(): int
    {
        $key = array_search($this, self::NUMBER_MAP, true);
        return $key !== false ? $key : throw new RuntimeException('Case is missing in NUMBER_MAP: ' . $this->value);
    }
}
