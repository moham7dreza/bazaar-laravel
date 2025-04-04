<?php

namespace Database\Factories;

use App\Enums\Unit;
use App\Models\Advertise\Category;
use App\Models\Advertise\CategoryAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryAttributeFactory extends Factory
{
    protected $model = CategoryAttribute::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'unit' => Unit::random(),
            'type' => $this->faker->jobTitle,
            'category_id' => Category::factory(),
            'status' => $this->faker->boolean,
        ];
    }
}
