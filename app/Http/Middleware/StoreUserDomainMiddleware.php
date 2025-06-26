<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\ClientDomain;
use App\Enums\RequestHeader;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StoreUserDomainMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = getUser();

        if ( ! $user)
        {
            return $next($request);
        }

        $baseUrl = $request->header(RequestHeader::REFERER->value) ?: $request->header(RequestHeader::ORIGIN->value);

        if ( ! $baseUrl)
        {
            return $next($request);
        }

        $baseUrl = rtrim($baseUrl, '/');

        $domain = ClientDomain::tryFrom($baseUrl)?->toNumber();

        if (null === $domain)
        {
            return $next($request);
        }

        if ($user->domain !== $domain)
        {
            $user->domain = $domain;
            $user->saveQuietly();
        }

        return $next($request);
    }
}
