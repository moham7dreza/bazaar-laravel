<?php

namespace App\Http\Responses;

use App\Exceptions\ApiJsonResponseException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

final class ApiJsonResponse
{
    public static function success(
        array|Arrayable|null $data = null,
        int $metaStatus = 200,
        array|string $message = []
    ): JsonResponse {

        if ($data instanceof Arrayable) {
            $data = $data->toArray();
        }

        return self::base(
            data: $data,
            httpStatus: 200,
            metaStatus: $metaStatus,
            message: $message,
        );
    }

    public static function error(
        int $httpStatus,
        array|string $message = [],
        ?int $metaStatus = null,
    ): JsonResponse {

        return self::base(
            data: null,
            httpStatus: $httpStatus,
            metaStatus: $metaStatus ?? $httpStatus,
            message: $message,
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
            message: [$fieldName => [$message]],
        );
    }

    /**
     * Throw an exception that will be rendered by the exception handler.
     *
     * @throws ApiJsonResponseException
     */
    public static function throwException(
        int $status,
        array|string $message = [],
    ): never {

        if (is_string($message)) {
            $message = [$message];
        }

        throw new ApiJsonResponseException($status, $message);
    }

    private static function base(
        ?array $data,
        int $httpStatus,
        int $metaStatus,
        array|string $message = [],
    ): JsonResponse {

        if (is_string($message)) {
            $message = [$message];
        }

        return response()->json([
            'data' => $data,
            'meta' => [
                'status'   => $metaStatus,
                'messages' => $message,
            ],
        ], $httpStatus);
    }
}
