<?php

declare(strict_types=1);

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
            'title'      => fake()->title,
            'date'       => fake()->dateTime,
            'started_at' => fake()->dateTime,
            'ended_at'   => fake()->dateTime,
        ];
    }
}
