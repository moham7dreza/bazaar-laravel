<?php

declare(strict_types=1);

namespace Modules\Monitoring\Support\Config;

use RuntimeException;

final class PrometheusConfig
{
    public static function isEnabled(): bool
    {
        return (bool) config()?->boolean('prometheus.enabled');
    }

    public static function getToken(): ?string
    {
        return config()?->string('prometheus.token');
    }

    public static function isConfigured(): bool
    {
        return (bool) self::getToken();
    }

    public static function ensureConfigured(): void
    {
        if ( ! self::isConfigured())
        {
            throw new RuntimeException('Prometheus is not configured');
        }
    }
}
