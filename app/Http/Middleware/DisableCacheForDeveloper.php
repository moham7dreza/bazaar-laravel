<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\RequestHeader;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class DisableCacheForDeveloper
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = request()->user();
        if (
            $user
            && $request->hasHeader(RequestHeader::DISABLE_CACHE->value)
            && in_array($user->mobile, config('developer.backends'), true)
        ) {
            config()?->set('cache.default');
        }

        return $next($request);
    }
}
