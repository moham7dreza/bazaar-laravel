<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Enums\ExceptionCode;
use Throwable;

class AuthorizationBusinessException extends BaseBusinessException
{
    public function __construct(
        ExceptionCode $exceptionCode = ExceptionCode::Forbidden,
        ?string $message = null,
        array $context = [],
        ?Throwable $previous = null
    ) {
        parent::__construct($exceptionCode, $message, $context, $previous);
    }
}
