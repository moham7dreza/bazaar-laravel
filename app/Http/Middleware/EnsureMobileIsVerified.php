<?php

namespace App\Http\Middleware;

use App\Contracts\MustVerifyMobile;
use App\Http\Responses\ApiJsonResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMobileIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = getUser();
        if (! $user ||
            ($user instanceof MustVerifyMobile && ! $user->hasVerifiedMobile())) {

            return ApiJsonResponse::error(Response::HTTP_CONFLICT, __('response.general.unverified-mobile'));
        }

        return $next($request);
    }
}
