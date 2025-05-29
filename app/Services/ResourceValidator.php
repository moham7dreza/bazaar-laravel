<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ResourceValidator
{
    public function validateExternalLinks(array $links): Collection
    {
        return collect($links)->filter(function ($url, $type) {
            return match ($type)
            {
                'documentation' => Str::isUrl($url, ['https']),
                'repository'    => Str::isUrl($url, ['https']),
                'demo'          => Str::isUrl($url, ['http', 'https']),
                default         => Str::isUrl($url)
            };
        });
    }

    public function validateSecureResources(array $urls): Collection
    {
        return collect($urls)
            ->filter(fn ($url) => Str::isUrl($url, ['https']))
            ->values();
    }

    public function sanitizeBookmarks(array $bookmarks): array
    {
        return array_filter($bookmarks, static function ($bookmark) {
            // Only allow http/https URLs
            return Str::isUrl($bookmark, ['http', 'https']);

            // Additional validation logic here
        });
    }
}
