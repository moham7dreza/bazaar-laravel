<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Responses\ApiJsonResponse;
use App\Services\DomainRouter;
use Illuminate\Http\Request;

final class DomainRouterController
{
    public function __invoke(Request $request)
    {
        $routes = app(DomainRouter::class)->generateRoutes($request);

        return ApiJsonResponse::success($routes);
    }
}
