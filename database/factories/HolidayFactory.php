<?php

namespace Database\Factories;

use App\Models\Holiday;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Holiday>
 */
class HolidayFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->title,
            'date' => $this->faker->dateTime,
            'started_at' => $this->faker->dateTime,
            'ended_at' => $this->faker->dateTime,
        ];
    }
}
