<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Enums\ExceptionCode;
use Throwable;

class SystemException extends BaseBusinessException
{
    public function __construct(
        ExceptionCode $code = ExceptionCode::InternalServerError,
        ?string $message = null,
        array $context = [],
        ?Throwable $previous = null
    ) {
        parent::__construct($code, $message, $context, $previous);
    }
}
