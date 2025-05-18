<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\Responses\ApiJsonResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class UserCheckSuspendedMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = getUser();
        if ($user?->isSuspended())
        {
            auth()->logout();

            return ApiJsonResponse::error(Response::HTTP_FORBIDDEN, __('response.general.suspended'));
        }

        return $next($request);
    }
}
