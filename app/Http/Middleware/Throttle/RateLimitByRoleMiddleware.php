<?php

declare(strict_types=1);

namespace App\Http\Middleware\Throttle;

use App\Enums\UserRole as R;
use App\Http\Responses\ApiJsonResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class RateLimitByRoleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (blank($user))
        {
            return $next($request);
        }

        [$role, $maxAttempts] = match (true)
        {
            $user->hasRole(R::Admin)  => [R::Admin->value, R::Admin->rateLimit()],
            $user->hasRole(R::Writer) => [R::Writer->value, R::Writer->rateLimit()],
            default                   => ['guest', 20],
        };
        $key = "rate:{$role}:" . $request->user()->id;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts))
        {
            return ApiJsonResponse::error(Response::HTTP_TOO_MANY_REQUESTS, __('response.general.too-many-attempts'));
        }

        RateLimiter::hit($key);

        return $next($request);
    }
}
