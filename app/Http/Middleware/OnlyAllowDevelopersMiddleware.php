<?php

namespace App\Http\Middleware;

use App\Http\Responses\ApiJsonResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnlyAllowDevelopersMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $mobile = getUser()?->mobile;
        if ($mobile && in_array($mobile, config(''), true)) {
            return $next($request);
        }

        return ApiJsonResponse::error(trans('response.general.not-found'), code: Response::HTTP_NOT_FOUND);
    }
}
