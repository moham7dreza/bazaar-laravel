<?php

namespace App\Http\Middleware;

use App\Http\Responses\ApiJsonResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = getUser();
        if (! $user?->isAdmin()) {
            return ApiJsonResponse::error(trans('response.general.forbidden'), code: Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
