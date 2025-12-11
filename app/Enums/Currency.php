<?php

declare(strict_types=1);

namespace App\Enums;

enum Currency: string
{
    case Irr = 'IRR';
    case Usd = 'USD';

    public static function currentCurrency(): Currency
    {
        $currency = config()->string('app.currency');

        return $currency ? self::tryFrom($currency) : self::getCurrencyFromClientLocale();
    }

    private static function getCurrencyFromClientLocale(): Currency
    {
        return match (ClientLocale::from(app()->currentLocale()))
        {
            ClientLocale::Farsi   => self::Irr,
            ClientLocale::English => self::Usd,
        };
    }
}
