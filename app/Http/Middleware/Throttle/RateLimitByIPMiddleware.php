<?php

declare(strict_types=1);

namespace App\Http\Middleware\Throttle;

use App\Http\Responses\ApiJsonResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class RateLimitByIPMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $ip  = $request->ip();
        $key = 'rate_limit:ip:' . $ip;

        if (RateLimiter::tooManyAttempts($key, 60))
        {
            return ApiJsonResponse::error(Response::HTTP_TOO_MANY_REQUESTS, __('response.general.too-many-attempts'));
        }

        RateLimiter::hit($key);

        return $next($request);
    }
}
