<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\Responses\ApiJsonResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class RequireJsonMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('api/*') && ! $request->wantsJson())
        {
            return ApiJsonResponse::error(Response::HTTP_NOT_ACCEPTABLE, __('response.general.request-with-json'));
        }

        return $next($request);
    }
}
