<?php

namespace App\Http\Middleware;

use App\Http\Responses\ApiNewJsonResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserCheckSuspendedMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = getUser();
        if ($user?->isSuspended()) {
            auth()->logout();

            return ApiNewJsonResponse::error(Response::HTTP_FORBIDDEN, __('response.general.suspended'));
        }

        return $next($request);
    }
}
