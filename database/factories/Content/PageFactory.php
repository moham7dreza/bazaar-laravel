<?php

namespace Database\Factories\Content;

use App\Models\Content\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content\Page>
 */
class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition(): array
    {
        return [
            'title' => fake()->title,
            'body' => fake()->randomHtml,
            'status' => true,
        ];
    }
}
