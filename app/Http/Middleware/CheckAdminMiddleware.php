<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\Responses\ApiJsonResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class CheckAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if ($user && ! $user->isAdmin())
        {
            return ApiJsonResponse::error(Response::HTTP_FORBIDDEN, __('response.general.forbidden'));
        }

        return $next($request);
    }
}
