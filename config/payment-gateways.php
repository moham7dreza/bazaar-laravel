<?php

declare(strict_types=1);

use App\Enums\PaymentGateways;

return [
    'keys' => [
        PaymentGateways::ZarrinPal->value => [
            'merchant_id' => [
                'label' => 'merchant_id',
                'rules' => ['string', 'required'],
            ],
        ],
        PaymentGateways::AsanPardakht->value => [
            'username' => [
                'rules' => ['string', 'required'],
            ],
            'password' => [
                'rules' => ['string', 'required'],
            ],
            'merchantConfigID' => [
                'rules' => ['string', 'required'],
            ],
        ],
        PaymentGateways::BehPardakht->value => [
            'terminalId' => [],
            'username'   => [],
            'password'   => [],
        ],
    ],
];
