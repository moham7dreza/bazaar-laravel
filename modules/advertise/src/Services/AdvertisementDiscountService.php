<?php

declare(strict_types=1);

namespace Modules\Advertise\Services;

use Cknow\Money\Money;
use Modules\Advertise\Models\Advertisement;

class AdvertisementDiscountService
{
    public function getDiscount(
        int $advertisementId,
        int $couponPercentage,
    ): Money {
        return money($this->getAdvertisementPrice($advertisementId))
            ->multiply($couponPercentage)
            ->divide(100);
    }

    public function getFinalPrice(
        int $advertisementId,
        int $couponPercentage,
    ): Money {
        $advertisementPrice = $this->getAdvertisementPrice($advertisementId);

        $discount = $this->getDiscount($advertisementId, $couponPercentage);

        return money($advertisementPrice)
            ->subtract($discount);
    }

    private function getAdvertisementPrice(int $advertisementId): int
    {
        return once(fn () => Advertisement::query()
            ->whereKey($advertisementId)
            ->value('price'));
    }
}
