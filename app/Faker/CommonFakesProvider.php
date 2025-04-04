<?php

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
}
