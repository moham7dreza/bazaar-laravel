<?php

namespace Database\Factories\Advertise;

use App\Enums\Advertisement\ValueType;
use App\Models\Advertise\CategoryAttribute;
use App\Models\Advertise\CategoryValue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Advertise\CategoryValue>
 */
class CategoryValueFactory extends Factory
{
    protected $model = CategoryValue::class;

    public function definition(): array
    {
        return [
            'category_attribute_id' => CategoryAttribute::factory(),
            'value' => fake()->jobTitle,
            'type' => ValueType::random(),
            'status' => true,
        ];
    }
}
