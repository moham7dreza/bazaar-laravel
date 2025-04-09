<?php

namespace App\Http\Middleware;

use App\Http\Responses\ApiJsonResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserCheckSuspendedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->isSuspended()) {
            auth()->logout();

            return ApiJsonResponse::error(trans('response.general.suspended'), code: Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
