<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Http\Responses\ApiJsonResponse;
use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

final class ApiJsonResponseException extends Exception implements Responsable
{
    private readonly array $messages;

    public function __construct(private readonly int $status, array $messages)
    {
        if (blank($messages))
        {
            $this->messages = $this->getDefaultMessageForStatus($this->status);
        } else
        {
            $this->messages = $messages;
        }

        parent::__construct(\Illuminate\Support\Arr::get($this->messages, 0, ''));
    }

    public function toResponse($request): JsonResponse
    {
        return ApiJsonResponse::error($this->status, $this->messages);
    }

    private function getDefaultMessageForStatus(int $status): array
    {
        $message = match ($status)
        {
            403     => trans('response.general.forbidden'),
            404     => trans('response.general.not-found'),
            default => null,
        };

        return [$message] ?? [];
    }
}
