<?php

namespace Database\Factories\Advertise;

use App\Enums\ValueType;
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
            'type' => ValueType::random(),
            'status' => true,
        ];
    }
}
