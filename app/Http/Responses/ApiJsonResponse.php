<?php


namespace App\Http\Responses;


use Illuminate\Http\JsonResponse;

class ApiJsonResponse
{
    public static function success($message, $data = [],  $code = 200): JsonResponse
    {
        return response()->json([
            'statusTxt' => 'Request Was Successful',
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }


    public static function error($message, $data = [],  $code = 422): JsonResponse
    {
        return response()->json([
            'statusTxt' => 'Request Error!!',
            'status' => false,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
