<?php

declare(strict_types=1);

namespace Modules\Advertise\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Advertise\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Advertise\Models\Category>
 */
final class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => fake()->name(),
            'description' => fake()->text(),
            'icon'        => 'fa fa-car',
            'parent_id'   => null,
            'status'      => true,
        ];
    }

    public function configure(): self
    {
        return $this->afterMaking(function (Category $category): void {

        })->afterCreating(function (Category $category): void {

        });
    }
}
