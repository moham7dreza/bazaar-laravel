<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Contracts\MustVerifyMobile;
use App\Http\Responses\ApiJsonResponse;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

final class EnsureMobileIsVerified
{
    public static function redirectTo($route): string
    {
        return self::class . ':' . $route;
    }

    public function handle(Request $request, Closure $next, ?string $redirectToRoute = null): JsonResponse|RedirectResponse|Response
    {
        if ( ! $request->user() ||
            ($request->user() instanceof MustVerifyMobile &&
                ! $request->user()->hasVerifiedMobile()))
        {
            return $request->expectsJson()
                ? ApiJsonResponse::error(Response::HTTP_FORBIDDEN, 'Your mobile number is not verified.')
                : Redirect::guest(URL::route($redirectToRoute ?: 'verification.notice'));
        }

        return $next($request);
    }
}
