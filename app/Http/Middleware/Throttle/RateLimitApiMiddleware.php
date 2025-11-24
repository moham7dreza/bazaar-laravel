<?php

declare(strict_types=1);

namespace App\Http\Middleware\Throttle;

use App\Http\Responses\ApiJsonResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Symfony\Component\HttpFoundation\Response;

final class RateLimitApiMiddleware
{
    public function handle(Request $request, Closure $next, int $maxAttempts = 60): Response
    {
        $key      = 'rate-limit:' . $request->ip();
        $attempts = cache($key, 0);

        if ($attempts >= $maxAttempts)
        {
            return ApiJsonResponse::error(Response::HTTP_TOO_MANY_REQUESTS, __('response.general.too-many-attempts'));
        }

        cache()->put($key, $attempts + 1, Date::now()->addMinute());

        $response = $next($request);

        $response->headers->set('X-RateLimit-Limit', $maxAttempts);
        $response->headers->set('X-RateLimit-Remaining', $maxAttempts - $attempts - 1);

        return $response;
    }
}
