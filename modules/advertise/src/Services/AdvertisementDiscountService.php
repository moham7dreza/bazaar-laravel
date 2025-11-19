<?php

declare(strict_types=1);

namespace Modules\Advertise\Services;

use Cknow\Money\Money;

class AdvertisementDiscountService
{
    public function getDiscount(
        Money $advertisementPrice,
        int $couponPercentage,
    ): Money {
        return $advertisementPrice
            ->multiply($couponPercentage)
            ->divide(100);
    }

    public function getFinalPrice(
        Money $advertisementPrice,
        int $couponPercentage,
    ): Money {
        $discount = $this->getDiscount($advertisementPrice, $couponPercentage);

        return $advertisementPrice
            ->subtract($discount);
    }
}
