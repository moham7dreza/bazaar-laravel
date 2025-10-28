<?php

declare(strict_types=1);

namespace Modules\Advertise\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Advertise\Enums\AttributeType;
use Modules\Advertise\Enums\Unit;
use Modules\Advertise\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Advertise\Models\CategoryAttribute>
 */
final class CategoryAttributeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => fake()->name,
            'unit'        => Unit::random(),
            'type'        => AttributeType::random(),
            'category_id' => Category::factory(),
            'status'      => true,
        ];
    }
}
