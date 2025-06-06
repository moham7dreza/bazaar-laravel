<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Enums\Environment;
use Illuminate\Http\Request;

final readonly class DomainRouter
{
    public function generateRoutes(Request $request): array
    {
        $baseHost = $request->host();
        $scheme   = $request->schemeAndHttpHost();

        return match ($this->getEnvironment($baseHost))
        {
            Environment::PRODUCTION => [
                'api'         => "{$scheme}/api",
                'web'         => $request->httpHost(),
                'assets'      => str_replace('api', 'cdn', $scheme),
                'environment' => Environment::PRODUCTION->value,
            ],
            Environment::STAGING => [
                'api'         => "{$scheme}/api",
                'web'         => str_replace('api', 'staging', $request->httpHost()),
                'assets'      => str_replace('api', 'staging-cdn', $scheme),
                'environment' => Environment::STAGING->value,
            ],
            default => [
                'api'         => 'http://localhost:9000/api',
                'web'         => 'http://localhost:3000',
                'assets'      => 'http://localhost:9000',
                'environment' => Environment::LOCAL->value,
            ]
        };
    }

    private function getEnvironment(string $host): Environment
    {
        return match (true)
        {
            str_contains($host, 'ir')  => Environment::PRODUCTION,
            str_contains($host, 'dev') => Environment::STAGING,
            default                    => Environment::LOCAL,
        };
    }
}
