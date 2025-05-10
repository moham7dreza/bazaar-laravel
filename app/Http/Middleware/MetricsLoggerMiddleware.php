<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Context;
use Illuminate\Http\Request;
use Log;
use Symfony\Component\HttpFoundation\Response;

final class MetricsLoggerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $this->logMetrics();

        return $response;
    }

    private function logMetrics(): void
    {
        $attempts   = Context::get('metrics.login_otp_attempts', 0);
        $successful = Context::get('metrics.login_otp_successful', 0);
        $rejections = Context::get('metrics.login_otp_rejections', 0);
        $errors     = Context::get('metrics.login_otp_errors', 0);

        Log::info('Metrics', [
            'attempts'   => $attempts,
            'successful' => $successful,
            'rejections' => $rejections,
            'errors'     => $errors,
        ]);
    }
}
