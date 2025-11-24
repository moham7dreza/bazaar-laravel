<?php

declare(strict_types=1);

namespace App\Http\Middleware\Throttle;

use App\Http\Responses\ApiJsonResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class RateLimitByTokenMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        $key   = 'rate_limit:token:' . ($token ?? $request->ip());

        if (RateLimiter::tooManyAttempts($key, 100))
        {
            return ApiJsonResponse::error(Response::HTTP_TOO_MANY_REQUESTS, __('response.general.too-many-attempts'));
        }

        RateLimiter::hit($key);

        return $next($request);
    }
}
