<?php

namespace Database\Factories\Advertise;

use App\Models\Advertise\State;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Advertise\State>
 */
class StateFactory extends Factory
{
    protected $model = State::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'description' => fake()->text,
            'icon' => 'fa fa-car',
            'parent_id' => null,
            'status' => true,
        ];
    }
}
