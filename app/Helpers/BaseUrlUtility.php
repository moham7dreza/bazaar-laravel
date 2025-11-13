<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Enums\ClientDomain;

final readonly class BaseUrlUtility
{
    public static function getBaseUrlForStaging(string $host): ClientDomain
    {
        $frontBackMapping = [
            'front' => 'backend',
        ];

        $targetFrontEndForStaging = array_search($host, $frontBackMapping, true);

        if ($targetFrontEndForStaging)
        {
            return ClientDomain::tryFrom(sprintf('https://%s.dev', $targetFrontEndForStaging));
        }

        return ClientDomain::ProdIR;
    }
}
