<?php

declare(strict_types=1);

use App\Enums\SMSGateways;

return [
    'keys' => [
        SMSGateways::Kavehnegar->value => [
            'api_key' => [
                'label' => 'api_key',
                'rules' => ['string', 'required'],
            ],
        ],
        SMSGateways::SmsIr->value => [
            'api_key' => [
                'rules' => ['string', 'required'],
            ],
            'secret_key' => [
                'rules' => ['string', 'required'],
            ],
        ],
    ],
];
