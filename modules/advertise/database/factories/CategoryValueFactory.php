<?php

declare(strict_types=1);

namespace Modules\Advertise\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Advertise\Enums\ValueType;
use Modules\Advertise\Models\CategoryAttribute;
use Modules\Advertise\Models\CategoryValue;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Advertise\Models\CategoryValue>
 */
final class CategoryValueFactory extends Factory
{
    protected $model = CategoryValue::class;

    public function definition(): array
    {
        return [
            'category_attribute_id' => CategoryAttribute::factory(),
            'value'                 => fake()->jobTitle,
            'type'                  => ValueType::random(),
            'status'                => true,
        ];
    }
}
