<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\ClientLocale;
use Closure;
use Illuminate\Http\Request;

class SetClientLocaleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->route()?->hasParameter('lang'))
        {
            $lang = ClientLocale::tryFrom($request->route('lang'));

            $request->route()->forgetParameter('lang');

            if (blank($lang))
            {
                app()->setLocale(config()->string('app.locale', ClientLocale::FA->value));

                return $next($request);
            }

            app()->setLocale($lang->value);

            $user = getUser();

            if (blank($user))
            {
                return $next($request);
            }

            if ($user->locale !== $lang->toNumber())
            {
                $user->locale = $lang->toNumber();
                $user->saveQuietly();
            }
        }

        return $next($request);
    }
}
