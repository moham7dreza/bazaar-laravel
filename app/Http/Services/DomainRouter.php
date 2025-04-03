<?php

namespace App\Http\Services;

use Illuminate\Http\Request;

readonly class DomainRouter
{
    public function __construct(private Request $request)
    {
    }

    public function generateRoutes(): array
    {
        $baseHost = $this->request->host();
        $scheme = $this->request->schemeAndHttpHost();

        return match($this->getEnvironment($baseHost)) {
            'production' => [
                'api' => "{$scheme}/api/v1",
                'web' => $this->request->httpHost(),
                'assets' => str_replace('api', 'cdn', $scheme),
                'environment' => 'production'
            ],
            'staging' => [
                'api' => "{$scheme}/api/v1",
                'web' => str_replace('api', 'staging', $this->request->httpHost()),
                'assets' => str_replace('api', 'staging-cdn', $scheme),
                'environment' => 'staging'
            ],
            default => [
                'api' => 'http://localhost:8000/api/v1',
                'web' => 'http://localhost:3000',
                'assets' => 'http://localhost:9000',
                'environment' => 'local'
            ]
        };
    }

    private function getEnvironment(string $host): string
    {
        if (str_contains($host, 'prod')) {
            return 'production';
        }

        if (str_contains($host, 'staging')) {
            return 'staging';
        }

        return 'local';
    }
}
