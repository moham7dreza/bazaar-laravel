<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Enums\ClientDomain;
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
            Environment::Production => [
                'api'         => $scheme . '/api',
                'web'         => $request->httpHost(),
                'assets'      => str_replace('api', 'cdn', $scheme),
                'environment' => Environment::Production->value,
            ],
            Environment::Staging => [
                'api'         => $scheme . '/api',
                'web'         => str_replace('api', 'staging', $request->httpHost()),
                'assets'      => str_replace('api', 'staging-cdn', $scheme),
                'environment' => Environment::Staging->value,
            ],
            default => [
                'api'         => ClientDomain::Local->backendApi(),
                'web'         => ClientDomain::Local->value,
                'assets'      => ClientDomain::Local->backendUrl(),
                'environment' => Environment::Local->value,
            ]
        };
    }

    private function getEnvironment(string $host): Environment
    {
        return match (true)
        {
            str_contains($host, 'ir')  => Environment::Production,
            str_contains($host, 'dev') => Environment::Staging,
            default                    => Environment::Local,
        };
    }
}
