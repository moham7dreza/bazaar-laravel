<?php

declare(strict_types=1);

use App\Enums\PaymentGateways;

return [
    PaymentGateways::ZARRIN_PAL->value    => 'Zarrin Pal',
    PaymentGateways::ASAN_PARDAKHT->value => 'Asan Pardakht',
    PaymentGateways::BEH_PARDAKHT->value  => 'Beh Pardakht',
];
