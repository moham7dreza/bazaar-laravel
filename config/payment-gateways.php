<?php

use App\Enums\PaymentGateways;

return [
    'keys' => [
        PaymentGateways::ZARRIN_PAL->value => [
            'merchant_id' => [
                'label' => 'merchant_id',
                'rules' => ['string', 'required'],
            ],
        ],
        PaymentGateways::ASAN_PARDAKHT->value => [
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
        PaymentGateways::BEH_PARDAKHT->value => [
            'terminalId' => [],
            'username' => [],
            'password' => [],
        ],
    ],
];
