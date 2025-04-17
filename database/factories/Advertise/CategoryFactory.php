<?php

namespace Database\Factories\Advertise;

use App\Models\Advertise\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'icon' => 'fa fa-car',
            'parent_id' => null,
            'status' => $this->faker->boolean,
        ];
    }

    public function parent(Category|Factory|null $category = null): static
    {
        if ($category instanceof Factory) {
            $category = $category->create();
        }

        return $this->state(function (array $attributes) use ($category) {
            return [
                'parent_id' => $category?->id,
            ];
        });
    }
}
