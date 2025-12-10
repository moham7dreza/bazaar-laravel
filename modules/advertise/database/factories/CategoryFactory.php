<?php

declare(strict_types=1);

namespace Modules\Advertise\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Advertise\Models\Category;
use Override;

/**
 * @extends Factory<Category>
 */
final class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => persian_faker()->word(),
            'description' => persian_faker()->text(),
            'icon'        => 'fa fa-car',
            'parent_id'   => null,
            'status'      => true,
        ];
    }

    #[Override]
    public function configure(): self
    {
        return $this->afterMaking(function (Category $category): void {

        })->afterCreating(function (Category $category): void {

        });
    }
}
