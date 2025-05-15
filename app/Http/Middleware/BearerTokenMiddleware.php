<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\Responses\ApiJsonResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class BearerTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $bearerToken = $request->bearerToken();

        if ($bearerToken !== config('prometheus.token'))
        {
            return ApiJsonResponse::error(Response::HTTP_UNAUTHORIZED, __('response.general.unauthorized'));
        }

        return $next($request);
    }
}
