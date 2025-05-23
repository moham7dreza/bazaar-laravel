<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Number;

final class OrderSummaryService
{
    public function generateEmailSummary($orderData): string
    {
        // Spell out small numbers, use digits for larger ones
        return 'Your order contains ' . Number::spell($orderData['item_count'], until: 10) .
            ' items from ' . Number::spell($orderData['vendor_count'], until: 10) .
            ' different sellers. Delivery is expected in ' . Number::spell($orderData['delivery_days'], until: 10) .
            ' days. Your loyalty account has been credited with ' . Number::spell($orderData['reward_points']) .
            ' points for this purchase.';
    }
}
