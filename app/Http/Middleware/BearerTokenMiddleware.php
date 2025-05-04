<?php

namespace App\Http\Middleware;

use App\Http\Responses\ApiJsonResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BearerTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $bearerToken = $request->bearerToken();

        if ($bearerToken !== getenv('BEARER_TOKEN')) {
            return ApiJsonResponse::error(Response::HTTP_UNAUTHORIZED, __('response.general.unauthorized'));
        }

        return $next($request);
    }
}
