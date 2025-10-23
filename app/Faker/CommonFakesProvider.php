<?php

declare(strict_types=1);

namespace App\Faker;

use Faker\Provider\Base;

class CommonFakesProvider extends Base
{
    /**
     * Generate tags in string format.
     */
    public function tags(): string
    {
        return collect(range(1, $this->generator->numberBetween(5, 10)))
            ->map(fn () => $this->generator->jobTitle)
            ->implode(',');
    }

    public function random_array(int $count = 5): array
    {
        return collect()
            ->times($count)
            ->map(fn () => fake()->name)
            ->all();
    }
}
