<?php

namespace Database\Factories;

use App\Enums\MenuPosition;
use App\Models\Content\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
            'parent_id' => $this->faker->boolean ? Menu::factory() : null,
            'status' => $this->faker->boolean,
        ];
    }
}
