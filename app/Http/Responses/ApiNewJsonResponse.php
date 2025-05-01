<?php

namespace App\Http\Responses;

use App\Exceptions\ApiJsonResponseException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

final class ApiNewJsonResponse
{
    public static function success(
        array|Arrayable|null $data = null,
        int $metaStatus = 200,
        array|string $messages = []
    ): JsonResponse {

        if ($data instanceof Arrayable) {
            $data = $data->toArray();
        }

        return self::base(
            data: $data,
            httpStatus: 200,
            metaStatus: $metaStatus,
            messages: $messages,
        );
    }

    public static function error(
        int $httpStatus,
        array|string $messages = [],
        ?int $metaStatus = null,
    ): JsonResponse {

        return self::base(
            data: null,
            httpStatus: $httpStatus,
            metaStatus: $metaStatus ?? $httpStatus,
            messages: $messages,
        );
    }

    /**
     * Creates a response with the same structure as a response that Laravel generates when a validation error occurs.
     */
    public static function validationError(
        string $fieldName,
        string $message,
    ): JsonResponse {

        return self::base(
            data: null,
            httpStatus: Response::HTTP_UNPROCESSABLE_ENTITY,
            metaStatus: Response::HTTP_UNPROCESSABLE_ENTITY,
            messages: [$fieldName => [$message]],
        );
    }

    /**
     * Throw an exception that will be rendered by the exception handler.
     *
     * @throws ApiJsonResponseException
     */
    public static function throwException(
        int $status,
        array|string $messages = [],
    ): never {

        if (is_string($messages)) {
            $messages = [$messages];
        }

        throw new ApiJsonResponseException($status, $messages);
    }

    private static function base(
        ?array $data,
        int $httpStatus,
        int $metaStatus,
        array|string $messages = [],
    ): JsonResponse {

        if (is_string($messages)) {
            $messages = [$messages];
        }

        return response()->json([
            'data' => $data,
            'meta' => [
                'status' => $metaStatus,
                'messages' => $messages,
            ],
        ], $httpStatus);
    }
}
