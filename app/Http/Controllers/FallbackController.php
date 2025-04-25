<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class FallbackController extends Controller
{
    public function __invoke()
    {
        Log::error('error 404 '.date('Y-m-d H:i:s')."\r\ncurrent: ".url()->current()."\r\nprevious: ".url()->previous()."\r\n\r\n");

        return response()->view('errors.404', [], 404);
    }
}
