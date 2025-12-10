<?php

declare(strict_types=1);

namespace Database\Factories\Geo;

use App\Models\Geo\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<City>
 */
class CityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'   => persian_faker()->city(),
            'status' => true,
        ];
    }
}
