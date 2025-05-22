<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Number;

final class NotificationFormatter
{
    public function formatInventoryAlert($product): string
    {
        return 'INVENTORY ALERT: Only ' . Number::spell($product['stock_remaining'], until: 5) .
            ' units of ' . $product['name'] . ' remain in stock. The minimum threshold is ' .
            Number::spell($product['min_threshold'], until: 5) . ' units.';
    }
}
