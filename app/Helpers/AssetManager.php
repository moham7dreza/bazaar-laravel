<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Services\Str;

final class AssetManager
{
    private array $imageFormats = ['jpg', 'png', 'gif', 'webp'];

    public function validateAsset(string $filename)
    {
        foreach ($this->imageFormats as $format)
        {
            if (Str::is("*.{$format}", $filename, true))
            {
                return true;
            }
        }

        return false;
    }

    public function processMediaUploads(array $files)
    {
        return collect($files)->filter(function ($file) {
            // Match media-specific files (e.g., MEDIA-*.*)
            return Str::is('MEDIA-*.*', $file, true);
        });
    }

    public function categorizeAsset(string $filename)
    {
        $categories = [
            'thumbnail' => 'THUMB-*.*',
            'banner'    => 'BNR-*.*',
            'logo'      => 'LOGO-*.*',
        ];

        foreach ($categories as $type => $pattern)
        {
            if (Str::is($pattern, $filename, true))
            {
                return $type;
            }
        }

        return 'general';
    }
}
