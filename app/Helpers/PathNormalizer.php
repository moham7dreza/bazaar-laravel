<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Str;

class PathNormalizer
{
    public function standardizeProtocol(string $url, string $protocol = 'https')
    {
        // Replace http:// with https://
        $url = Str::replaceStart('http://', $protocol . '://', $url);

        // Add protocol if missing
        if ( ! str_starts_with($url, $protocol . '://'))
        {
            return $protocol . '://' . $url;
        }

        return $url;
    }

    public function unifySubdomain(string $url, string $targetDomain)
    {
        // Replace www with target domain
        $url = Str::replaceStart('www.', $targetDomain . '.', $url);

        // Replace staging with target domain
        $url = Str::replaceStart('staging.', $targetDomain . '.', $url);

        return $url;
    }

    public function normalizeApiPath(string $endpoint)
    {
        // Remove leading /api if present
        return Str::replaceStart('/api', '', $endpoint);
    }
}
