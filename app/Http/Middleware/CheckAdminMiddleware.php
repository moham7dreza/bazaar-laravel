<?php

namespace App\Http\Middleware;

use App\Http\Responses\ApiJsonResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return ApiJsonResponse::error(trans('response.general.unauthorized'), code: Response::HTTP_UNAUTHORIZED);
        }
        $user = auth()->user();
        if ($user->user_type !== 1 || is_null($user->mobile_verified_at)) {
            return ApiJsonResponse::error(trans('response.general.forbidden'), code: Response::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
