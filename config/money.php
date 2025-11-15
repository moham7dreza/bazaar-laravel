<?php

declare(strict_types=1);

return [
    /*
     |--------------------------------------------------------------------------
     | Laravel money
     |--------------------------------------------------------------------------
     */
    'locale'            => config('app.locale'),
    'defaultCurrency'   => config('app.currency'),
    'defaultFormatter'  => null,
    'defaultSerializer' => null,
    'isoCurrenciesPath' => is_dir(__DIR__ . '/../vendor')
        ? __DIR__ . '/../vendor/moneyphp/money/resources/currency.php'
        : __DIR__ . '/../../../moneyphp/money/resources/currency.php',
    'currencies' => [
        'iso'     => 'all',
        'bitcoin' => 'all',
        'custom'  => [
            // 'MY1' => 2,
            // 'MY2' => 3
        ],
    ],
];
