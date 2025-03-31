<?php

namespace App\Http\Middleware;

use App\Http\Responses\ApiJsonResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BanUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = getUser();
        if ($user && $user->is_banned) {
            auth()->logout();

            return ApiJsonResponse::error(trans('response.general.unauthorized'), code: Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
