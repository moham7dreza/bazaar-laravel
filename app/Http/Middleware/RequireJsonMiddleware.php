<?php

namespace App\Http\Middleware;

use App\Http\Responses\ApiNewJsonResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireJsonMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('api/*') && ! $request->wantsJson()) {

            return ApiNewJsonResponse::error(Response::HTTP_NOT_ACCEPTABLE, __('response.general.request-with-json'));
        }

        return $next($request);
    }
}
