<?php

namespace App\Http\Middleware;

use App\Http\Responses\ApiNewJsonResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = getUser();
        if (! $user?->isAdmin()) {
            return ApiNewJsonResponse::error(Response::HTTP_FORBIDDEN, __('response.general.forbidden'));
        }

        return $next($request);
    }
}
