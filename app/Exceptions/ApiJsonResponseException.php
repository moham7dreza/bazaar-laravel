<?php

namespace App\Exceptions;

use App\Http\Responses\ApiJsonResponse;
use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

final class ApiJsonResponseException extends Exception implements Responsable
{
    private readonly int $status;
    private readonly array $messages;

    public function __construct(int $status, array $messages)
    {
        $this->status = $status;

        if (empty($messages)) {
            $this->messages = $this->getDefaultMessageForStatus($status);
        } else {
            $this->messages = $messages;
        }

        parent::__construct($this->messages[0] ?? '');
    }

    public function toResponse($request): JsonResponse
    {
        return ApiJsonResponse::error($this->status, $this->messages);
    }

    private function getDefaultMessageForStatus(int $status): array
    {
        $message = match ($status) {
            403     => trans('response.general.forbidden'),
            404     => trans('response.general.not-found'),
            default => null,
        };

        return [$message] ?? [];
    }
}
