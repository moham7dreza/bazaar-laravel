<?php

namespace Database\Factories\Geo;

use App\Models\Geo\City;
use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    protected $model = City::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->city,
            'status' => true,
        ];
    }
}
