<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Classes\ContextItem;
use App\Services\Contexts\RequestContext;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final readonly class ApiRequestLoggerMiddleware
{
    public function __construct(
        private RequestContext $requestContext,
    ) {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $this->requestContext->addBasicContexts();
        $this->requestContext->addUserContext();

        if ($request->filled('per_page') && is_numeric($request->get('per_page')))
        {
            context()->add(ContextItem::PerPage, $request->integer('per_page'));
        }

        // Add performance metrics
        $startTime = microtime(true);

        $response = $next($request);

        context()->add(ContextItem::ResponseTime, round((microtime(true) - $startTime) * 1000, 2));
        context()->add(ContextItem::StatusCode, $response->getStatusCode());

        info('API request processed');

        return $response;
    }
}
