<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Enums\ExceptionCode;
use App\Http\Responses\ApiJsonResponse;
use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Throwable;

class BaseBusinessException extends Exception implements Responsable
{
    public function __construct(
        protected ExceptionCode $exceptionCode,
        ?string $message = null,
        protected array $context = [],
        ?Throwable $previous = null
    ) {
        // Use custom message or fall back to the client message from enum
        $message ??= $this->exceptionCode->clientMessage();

        parent::__construct($message, 0, $previous);
    }

    public function getExceptionCode(): ExceptionCode
    {
        return $this->exceptionCode;
    }

    public function getContext(): array
    {
        return $this->context;
    }

    public function toResponse($request): JsonResponse
    {
        $messages = [$this->getMessage()];

        // Add developer message if not in production
        if ( ! app()->isProduction() && config('app.debug'))
        {
            $messages['developer'] = $this->exceptionCode->developerMessage();
            $messages['code']      = $this->exceptionCode->value;

            if (filled($this->context))
            {
                $messages['context'] = $this->context;
            }
        }

        return ApiJsonResponse::error(
            httpStatus: $this->exceptionCode->httpStatus(),
            message: $messages,
            metaStatus: $this->exceptionCode->httpStatus(),
        );
    }

    public function report(): bool
    {
        // Return false to prevent reporting if shouldReport is false
        return $this->exceptionCode->shouldReport();
    }

    public function context(): array
    {
        return array_merge([
            'exception_code' => $this->exceptionCode->value,
            'severity'       => $this->exceptionCode->severity(),
        ], $this->context);
    }
}
