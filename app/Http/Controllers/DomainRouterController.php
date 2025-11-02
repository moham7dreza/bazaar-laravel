<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\DomainRouter;
use App\Http\Responses\ApiJsonResponse;
use Illuminate\Http\Request;

final class DomainRouterController extends Controller
{
    public function __invoke(Request $request, DomainRouter $domainRouter)
    {
        $routes = $domainRouter->generateRoutes($request);

        return ApiJsonResponse::success($routes);
    }
}
