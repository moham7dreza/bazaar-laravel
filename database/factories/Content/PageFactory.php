<?php

namespace Database\Factories\Content;

use App\Models\Content\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->title,
            'body' => $this->faker->randomHtml,
            'status' => $this->faker->boolean,
        ];
    }
}
