<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\Responses\ApiJsonResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class OnlyAllowDevelopersMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if ($user && in_array($user->mobile, config('developer.backends'), true))
        {
            return $next($request);
        }

        return ApiJsonResponse::error(Response::HTTP_NOT_FOUND, __('response.general.not-found'));
    }
}
