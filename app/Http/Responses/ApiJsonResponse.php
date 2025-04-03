<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ApiJsonResponse
{
    public static function success($message, $data = [], $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'statusTxt' => 'Request Was Successful',
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public static function error($message, $data = [], $code = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return response()->json([
            'statusTxt' => 'Request Error!!',
            'status' => false,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
