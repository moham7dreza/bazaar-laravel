<?php

declare(strict_types=1);

namespace Modules\Advertise\Database\Factories;

use App\Enums\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Models\AdvertisementPrice;

/**
 * @extends Factory<AdvertisementPrice>
 */
class AdvertisementPriceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'advertisement_id' => Advertisement::factory(),
            'price'            => fake()->numberBetween(100000, 999999) * 1000, // convert to IRR
            'currency'         => Currency::currentCurrency(),
        ];
    }
}
