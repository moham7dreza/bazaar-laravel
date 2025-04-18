<?php

namespace Database\Factories\Advertise;

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
            'parent_id' => null,
            'status' => true,
        ];
    }
}
