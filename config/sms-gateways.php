<?php

use App\Enums\SMSGateways;

return [
    'keys' => [
        SMSGateways::KAVEHNEGAR->value => [
            'api_key' => [
                'label' => 'api_key',
                'rules' => ['string', 'required'],
            ],
        ],
        SMSGateways::SMS_IR->value => [
            'api_key' => [
                'rules' => ['string', 'required'],
            ],
            'secret_key' => [
                'rules' => ['string', 'required'],
            ],
        ],
    ],
];
