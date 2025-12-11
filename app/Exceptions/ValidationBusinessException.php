<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Enums\ExceptionCode;
use Throwable;

class ValidationBusinessException extends BaseBusinessException
{
    public function __construct(
        ?string $message = null,
        array $context = [],
        ?Throwable $previous = null
    ) {
        parent::__construct(
            exceptionCode: ExceptionCode::ValidationError,
            message: $message,
            context: $context,
            previous: $previous
        );
    }
}
