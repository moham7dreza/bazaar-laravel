<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Enums\ExceptionCode;
use Throwable;

class AuthorizationBusinessException extends BaseBusinessException
{
    public function __construct(
        ExceptionCode $code = ExceptionCode::Forbidden,
        ?string $message = null,
        array $context = [],
        ?Throwable $previous = null
    ) {
        parent::__construct($code, $message, $context, $previous);
    }
}
