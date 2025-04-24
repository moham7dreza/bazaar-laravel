<?php

namespace Database\Factories\Advertise;

use App\Enums\Advertisement\AttributeType;
use App\Enums\Advertisement\Unit;
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
            'type' => AttributeType::random(),
            'category_id' => Category::factory(),
            'status' => true,
        ];
    }
}
