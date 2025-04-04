<?php

namespace App\Http\Middleware;

use App\Http\Interfaces\MustVerifyMobile;
use App\Http\Responses\ApiJsonResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMobileIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() ||
            ($request->user() instanceof MustVerifyMobile &&
                ! $request->user()->hasVerifiedMobile())) {
            return ApiJsonResponse::error(trans('response.general.unverified-mobile'), code: Response::HTTP_CONFLICT);
        }

        return $next($request);
    }
}
