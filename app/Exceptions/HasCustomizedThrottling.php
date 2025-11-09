<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Cache\RateLimiting\Limit;

interface HasCustomizedThrottling
{
    public function getLimit(): Limit;
}
