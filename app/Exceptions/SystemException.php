<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Enums\ExceptionCode;
use Throwable;

class SystemException extends BaseBusinessException
{
    public function __construct(
        ExceptionCode $exceptionCode = ExceptionCode::InternalServerError,
        ?string $message = null,
        array $context = [],
        ?Throwable $previous = null
    ) {
        parent::__construct($exceptionCode, $message, $context, $previous);
    }
}
