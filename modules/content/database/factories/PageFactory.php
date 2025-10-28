<?php

declare(strict_types=1);

namespace Modules\Content\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Content\Models\Page>
 */
final class PageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'  => fake()->title,
            'body'   => fake()->randomHtml,
            'status' => true,
        ];
    }
}
