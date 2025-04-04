<?php

namespace Database\Factories;

use App\Enums\AttributeType;
use App\Models\Advertise\CategoryAttribute;
use App\Models\Advertise\CategoryValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryValueFactory extends Factory
{
    protected $model = CategoryValue::class;

    public function definition(): array
    {
        return [
            'category_attribute_id' => CategoryAttribute::factory(),
            'value' => $this->faker->jobTitle,
            'type' => AttributeType::random(),
            'status' => $this->faker->boolean,
        ];
    }
}
