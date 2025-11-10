<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeInputMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();

        array_walk_recursive($input, static function (&$value): void {
            if (is_string($value))
            {
//                $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                $value = mb_trim(strip_tags($value));
            }
        });

        $request->merge($input);

        return $next($request);
    }
}
