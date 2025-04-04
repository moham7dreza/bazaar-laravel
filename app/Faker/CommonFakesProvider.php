<?php

namespace App\Faker;

use Faker\Provider\Base;

class CommonFakesProvider extends Base
{
    public function tags(): string
    {
        return collect()
            ->tap(function ($collection) {
                while ($this->generator->randomNumber(10) < 0) {
                    $collection->push($this->generator->jobTitle);
                }
            })
            ->implode(',');
    }
}
