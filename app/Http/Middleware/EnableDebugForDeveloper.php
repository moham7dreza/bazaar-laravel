<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class EnableDebugForDeveloper
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = getUser();
        if ($user && in_array($user->mobile, config('developer.backends'), true))
        {
            config()?->set('app.debug', true);
        }

        return $next($request);
    }
}
