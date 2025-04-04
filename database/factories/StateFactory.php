<?php

namespace Database\Factories;

use App\Models\Advertise\State;
use Illuminate\Database\Eloquent\Factories\Factory;

class StateFactory extends Factory
{
    protected $model = State::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'icon' => 'fa fa-car',
            'parent_id' => $this->faker->boolean ? State::factory() : null,
            'status' => $this->faker->boolean,
        ];
    }
}
