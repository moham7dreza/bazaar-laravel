<?php

declare(strict_types=1);

namespace Modules\Content\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Content\Models\Page;

/**
 * @extends Factory<Page>
 */
final class PageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'  => persian_faker()->sentence(),
            'body'   => fake()->randomHtml(),
            'status' => true,
            'slug'   => fn (array $attributes) => Str::slug(Arr::get($attributes, 'title')),
        ];
    }
}
