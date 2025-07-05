<?php

declare(strict_types=1);

namespace App\Http\Routing;

use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

        $router = app(Registrar::class);

        $route = (clone $route)->bind($request);

        try
        {
            $router->substituteBindings($route);
            $router->substituteImplicitBindings($route);
        } catch (ModelNotFoundException $e)
        {
            return false;
        }

        return true;
    }
}
