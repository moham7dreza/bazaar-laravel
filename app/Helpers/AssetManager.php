<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Str;

final class AssetManager
{
    private array $imageFormats = ['jpg', 'png', 'gif', 'webp'];

    public function validateAsset(string $filename)
    {
        return array_any($this->imageFormats, fn ($format) => Str::is("*.{$format}", $filename, true));
    }

    public function processMediaUploads(array $files)
    {
        return collect($files)->filter(fn ($file) =>
            // Match media-specific files (e.g., MEDIA-*.*)
            Str::is('MEDIA-*.*', $file, true));
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
