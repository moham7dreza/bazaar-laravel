<?php

namespace Database\Factories\Content;

use App\Enums\MenuPosition;
use App\Models\Content\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->title,
            'url' => $this->faker->url,
            'icon' => 'fa fa-car',
            'position' => MenuPosition::random(),
            'parent_id' => null,
            'status' => $this->faker->boolean,
        ];
    }
}
