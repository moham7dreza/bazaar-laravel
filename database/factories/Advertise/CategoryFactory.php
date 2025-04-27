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
            'status' => true,
        ];
    }

    public function configure(): self
    {
        return $this->afterMaking(function (Category $category): void {
            //
        })->afterCreating(function (Category $category): void {
            //
        });
    }
}
