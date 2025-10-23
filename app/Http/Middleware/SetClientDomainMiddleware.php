<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\ClientDomain;
use App\Enums\RequestHeader;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetClientDomainMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = getUser();

        if (blank($user))
        {
            return $next($request);
        }

        $baseUrl = $request->header(RequestHeader::REFERER->value) ?: $request->header(RequestHeader::ORIGIN->value);

        if (blank($baseUrl))
        {
            return $next($request);
        }

        $baseUrl = mb_rtrim($baseUrl, '/');

        $domain = ClientDomain::tryFrom($baseUrl)?->toNumber();

        if (blank($domain))
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
