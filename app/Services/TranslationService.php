<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;

final class TranslationService
{
    public function addMissingKeyToJsonLangFile(string $key, string $locale): void
    {
        $path = lang_path("{$locale}.json");

        // Skip if key contains dots (file-based translations)
        if (str_contains($key, '.'))
        {
            return;
        }

        try
        {
            if ( ! is_file($path))
            {
                file_put_contents($path, '{}');
            }

            $translations = json_decode(file_get_contents($path), true, 512, JSON_THROW_ON_ERROR) ?? [];

            if ( ! array_key_exists($key, $translations))
            {
                $translations[$key] = $key;
                file_put_contents(
                    $path,
                    json_encode($translations, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
                );
            }
        } catch (Exception $e)
        {
            Log::error("Failed to update translations key '{$key}' for '{$locale}.json': " . $e->getMessage());
        }
    }
}
