<?php

namespace App\Http\Middleware;

use App\Http\Responses\ApiJsonResponse;
use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = getUser();
        if (! $user ||
            ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail())
        ) {
            return ApiJsonResponse::error(Response::HTTP_CONFLICT, __('response.general.unverified-email'));
        }

        return $next($request);
    }
}
