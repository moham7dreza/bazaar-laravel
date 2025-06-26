<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\Language;
use Closure;
use Illuminate\Http\Request;

class SetLocaleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->route()->hasParameter('lang'))
        {
            $lang = $request->route('lang');
            $request->route()->forgetParameter('lang');

            if (in_array($lang, config()->array('app.available_locales'), true))
            {
                app()->setLocale($lang);
            } else
            {
                app()->setLocale(config()->string('app.locale', Language::FA->value));
            }
        }

        return $next($request);
    }
}
