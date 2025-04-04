<?php

namespace Database\Factories;

use App\Models\Advertise\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'icon' => 'fa fa-car',
            'parent_id' => $this->faker->boolean ? Category::factory() : null,
            'status' => $this->faker->boolean,
        ];
    }
}
