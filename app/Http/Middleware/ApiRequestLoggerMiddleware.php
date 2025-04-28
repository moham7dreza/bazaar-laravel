<?php

namespace App\Http\Middleware;

use App\Http\Contexts\RequestContext;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiRequestLoggerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $logger = app(RequestContext::class);

        $logger->addBasicContexts();
        $logger->addUserContext();

        // Add performance metrics
        $startTime = microtime(true);

        $response = $next($request);

        context()->add('response_time', round((microtime(true) - $startTime) * 1000, 2));
        context()->add('status_code', $response->getStatusCode());

        info('API request processed');

        return $next($request);
    }
}
