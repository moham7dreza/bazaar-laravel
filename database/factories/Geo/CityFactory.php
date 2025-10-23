<?php

declare(strict_types=1);

namespace Database\Factories\Geo;

use App\Models\Geo\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Geo\City>
 */
class CityFactory extends Factory
{
    protected $model = City::class;

    public function definition(): array
    {
        return [
            'name'   => fake()->city,
            'status' => true,
        ];
    }
}
