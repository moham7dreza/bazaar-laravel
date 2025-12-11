<?php

declare(strict_types=1);

namespace App\Enums;

use Illuminate\Support\Arr;

enum Currency: string
{
    case Irr = 'IRR';
    case Usd = 'USD';

    public static function currentCurrency(): Currency
    {
        return Arr::get(ClientLocale::default(), 'currency');
    }
}
