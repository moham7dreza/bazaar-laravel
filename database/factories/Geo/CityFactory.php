<?php

declare(strict_types=1);

namespace Database\Factories\Geo;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Geo\City>
 */
class CityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'   => fake()->city(),
            'status' => true,
        ];
    }
}
