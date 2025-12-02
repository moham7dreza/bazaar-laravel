<?php

declare(strict_types=1);

namespace App\Http\Routing;

use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Http\Request;
use Illuminate\Routing\Matching\ValidatorInterface;
use Illuminate\Routing\Route;

class IgnoreBindingValidator implements ValidatorInterface
{
    public function matches(Route $route, Request $request): bool
    {
        if ( ! $route->getAction('ignoreMissingBindings') || $route->getMissing())
        {
            return true;
        }

        $router = resolve(Registrar::class);

        $route = (clone $route)->bind($request);

        rescue(function () use ($router, $route): void {
            $router->substituteBindings($route);
            $router->substituteImplicitBindings($route);
        }, false);

        return true;
    }
}
