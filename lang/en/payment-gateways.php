<?php

declare(strict_types=1);

use App\Enums\PaymentGateways;

return [
    PaymentGateways::ZarrinPal->value    => 'Zarrin Pal',
    PaymentGateways::AsanPardakht->value => 'Asan Pardakht',
    PaymentGateways::BehPardakht->value  => 'Beh Pardakht',
];
