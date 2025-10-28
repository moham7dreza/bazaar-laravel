<?php

declare(strict_types=1);

namespace Modules\Advertise\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Advertise\Enums\ValueType;
use Modules\Advertise\Models\CategoryAttribute;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Advertise\Models\CategoryValue>
 */
final class CategoryValueFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_attribute_id' => CategoryAttribute::factory(),
            'value'                 => fake()->jobTitle(),
            'type'                  => ValueType::random(),
            'status'                => true,
        ];
    }
}
