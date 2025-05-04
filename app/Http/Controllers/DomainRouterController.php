<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiJsonResponse;
use App\Http\Services\DomainRouter;
use Illuminate\Http\Request;

class DomainRouterController
{
    public function __invoke(Request $request)
    {
        $routes = app(DomainRouter::class)->generateRoutes($request);

        return ApiJsonResponse::success($routes);
    }
}
