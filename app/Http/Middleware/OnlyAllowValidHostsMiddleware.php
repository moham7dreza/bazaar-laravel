<?php

namespace App\Http\Middleware;

use App\Http\Responses\ApiJsonResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnlyAllowValidHostsMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $trustedHosts = [
            'http://bazaar.local',
            'http://localhost:3000',
        ];

        if (! in_array($request->getSchemeAndHttpHost(), $trustedHosts, true)) {

            return ApiJsonResponse::error(Response::HTTP_NOT_FOUND, __('response.general.not-found'));
        }

        return $next($request);
    }
}
