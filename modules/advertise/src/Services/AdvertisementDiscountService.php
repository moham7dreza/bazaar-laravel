<?php

declare(strict_types=1);

namespace Modules\Advertise\Services;

use Modules\Advertise\Models\Advertisement;

class AdvertisementDiscountService
{
    public function getFormattedDiscount(
        int $advertisementId,
        int $couponPercentage,
    ): string {
        $advertisement = Advertisement::query()
            ->find($advertisementId, ['price']);

        return money($advertisement->price)
            ->multiply($couponPercentage)
            ->divide(100)
            ->format();
    }
}
