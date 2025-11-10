<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\Responses\ApiJsonResponse;
use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if ( ! $user
            || ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail())
        ) {
            return ApiJsonResponse::error(Response::HTTP_CONFLICT, __('response.general.unverified-email'));
        }

        return $next($request);
    }
}
