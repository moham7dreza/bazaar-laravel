<?php

declare(strict_types=1);

namespace Modules\Advertise\Services\Price;

use App\Enums\Currency;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Models\AdvertisementPrice;

final readonly class AdvertisementPriceCreateService
{
    public function handle(Advertisement $advertisement, int $price): AdvertisementPrice
    {
        return $advertisement
            ->prices()
            ->create([
                'price'    => $price,
                'currency' => Currency::currentCurrency(),
            ]);
    }
}
