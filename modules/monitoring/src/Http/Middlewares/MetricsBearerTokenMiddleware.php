<?php

declare(strict_types=1);

namespace Modules\Monitoring\Http\Middlewares;

use App\Http\Responses\ApiJsonResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Monitoring\Support\Config\PrometheusConfig;

final class MetricsBearerTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $bearerToken = $request->bearerToken();

        $enabled = PrometheusConfig::isEnabled() && PrometheusConfig::isConfigured();

        if ($enabled && $bearerToken !== PrometheusConfig::getToken())
        {
            return ApiJsonResponse::error(Response::HTTP_UNAUTHORIZED, __('response.general.unauthorized'));
        }

        return $next($request);
    }
}
