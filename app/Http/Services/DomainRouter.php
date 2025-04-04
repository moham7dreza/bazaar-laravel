<?php

namespace App\Http\Services;

use App\Enums\Environment;
use Illuminate\Http\Request;

readonly class DomainRouter
{
    public function __construct(private Request $request) {}

    public function generateRoutes(): array
    {
        $baseHost = $this->request->host();
        $scheme = $this->request->schemeAndHttpHost();

        return match ($this->getEnvironment($baseHost)) {
            Environment::PRODUCTION => [
                'api' => "{$scheme}/api/v1",
                'web' => $this->request->httpHost(),
                'assets' => str_replace('api', 'cdn', $scheme),
                'environment' => Environment::PRODUCTION->value,
            ],
            Environment::STAGING => [
                'api' => "{$scheme}/api/v1",
                'web' => str_replace('api', 'staging', $this->request->httpHost()),
                'assets' => str_replace('api', 'staging-cdn', $scheme),
                'environment' => Environment::STAGING->value,
            ],
            default => [
                'api' => 'http://localhost:8000/api/v1',
                'web' => 'http://localhost:3000',
                'assets' => 'http://localhost:9000',
                'environment' => Environment::LOCAL->value,
            ]
        };
    }

    private function getEnvironment(string $host): Environment
    {
        return match (true) {
            str_contains($host, 'prod') => Environment::PRODUCTION,
            str_contains($host, 'staging') => Environment::STAGING,
            default => Environment::LOCAL,
        };
    }
}
