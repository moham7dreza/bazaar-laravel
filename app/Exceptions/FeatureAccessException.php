<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Cache\RateLimiting\Limit;

class FeatureAccessException extends Exception implements HasCustomizedThrottling
{
    public function getLimit(): Limit
    {
        return Limit::perMinute(1);
    }
}
