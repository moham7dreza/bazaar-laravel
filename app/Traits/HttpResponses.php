<?php


namespace App\Traits;


trait HttpResponses
{


    protected function success($data, $message = null, $code = 200)
    {
        return response()->json([
            'statusTxt' => 'Request Was Successful',
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }


    protected function error($data, $message = null, $code = 400)
    {
        return response()->json([
            'statusTxt' => 'Request Error!!',
            'status' => false,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
