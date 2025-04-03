<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnableDebugForDeveloper
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = getUser();
        if ($user && in_array($user->mobile, config(''), true)) {
            config(['app.debug' => true]);
        }

        return $next($request);
    }
}
