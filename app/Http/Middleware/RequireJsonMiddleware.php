<?php

namespace App\Http\Middleware;

use App\Http\Responses\ApiJsonResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireJsonMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('api/*') && ! $request->wantsJson()) {
            return ApiJsonResponse::error(trans('response.general.request-with-json'), code: Response::HTTP_NOT_ACCEPTABLE);
        }

        return $next($request);
    }
}
