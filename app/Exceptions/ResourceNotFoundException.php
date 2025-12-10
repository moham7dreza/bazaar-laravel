<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Enums\ExceptionCode;
use Throwable;

class ResourceNotFoundException extends BaseBusinessException
{
    public function __construct(
        ?string $resourceName = null,
        ?string $message = null,
        array $context = [],
        ?Throwable $previous = null
    ) {
        $code = ExceptionCode::ResourceNotFound;

        if ($resourceName)
        {
            $context['resource'] = $resourceName;
            $message ??= trans('exception_codes.client.RES_3001', ['resource' => $resourceName]);
        }

        parent::__construct($code, $message, $context, $previous);
    }
}
