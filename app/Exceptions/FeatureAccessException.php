<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Enums\ExceptionCode;
use Illuminate\Cache\RateLimiting\Limit;
use Throwable;

class FeatureAccessException extends BaseBusinessException implements HasCustomizedThrottling
{
    public function __construct(
        ?string $message = null,
        array $context = [],
        ?Throwable $previous = null
    ) {
        parent::__construct(
            exceptionCode: ExceptionCode::FeatureNotAvailable,
            message: $message,
            context: $context,
            previous: $previous
        );
    }

    public function getLimit(): Limit
    {
        return Limit::perMinute(1);
    }
}
