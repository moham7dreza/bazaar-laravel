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
            return ApiJsonResponse::error(trans('response.general.unauthorized'), code: Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
