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
        // TODO: handle with cookie or header
        if ( ! $request->route()->hasParameter('lang'))
        {
            return $next($request);
        }

        $lang = ClientLocale::tryFrom($request->route('lang'));

        config()->set('app.timezone', $lang->timezone()->value);

        $request->route()->forgetParameter('lang');

        if (blank($lang))
        {
            app()->setLocale(
                config()->string('app.locale', ClientLocale::Farsi->value)
            );

            return $next($request);
        }

        app()->setLocale($lang->value);

        $user = $request->user();

        if (blank($user))
        {
            return $next($request);
        }

        if ($user->locale !== $lang->toNumber())
        {
            $user->locale = $lang->toNumber();
            $user->saveQuietly();
        }

        return $next($request);
    }
}
