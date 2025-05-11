<?php

declare(strict_types=1);

namespace Modules\Content\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Content\Enums\MenuPosition;
use Modules\Content\Models\Menu;

/**
 * @extends Factory<Menu>
 */
final class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'     => fake()->title,
            'url'       => fake()->url,
            'icon'      => 'fa fa-car',
            'position'  => MenuPosition::random(),
            'parent_id' => null,
            'status'    => true,
        ];
    }
}
