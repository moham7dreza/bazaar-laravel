<?php

declare(strict_types=1);

namespace Modules\Content\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Content\Models\Page;

/**
 * @extends Factory<Page>
 */
final class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition(): array
    {
        return [
            'title'  => fake()->title,
            'body'   => fake()->randomHtml,
            'status' => true,
        ];
    }
}
