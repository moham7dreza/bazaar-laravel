<?php

declare(strict_types=1);

namespace Database\Factories\Advertise;

use App\Enums\Advertisement\AttributeType;
use App\Enums\Advertisement\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Advertise\Models\Category;
use Modules\Advertise\Models\CategoryAttribute;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Advertise\Models\CategoryAttribute>
 */
final class CategoryAttributeFactory extends Factory
{
    protected $model = CategoryAttribute::class;

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
