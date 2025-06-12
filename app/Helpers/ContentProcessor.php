<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Str;

final class ContentProcessor
{
    private array $secureOptions = [
        'html_input'         => 'strip',
        'allow_unsafe_links' => false,
    ];

    public function formatPost(string $content): string
    {
        return Str::inlineMarkdown(
            $content,
            $this->secureOptions
        );
    }

    public function processHashtags(string $content): string
    {
        // Convert #hashtag to links while preserving markdown
        $processed = preg_replace(
            '/#(\w+)/',
            '[#$1](/tags/$1)',
            $content
        );

        return Str::inlineMarkdown(
            $processed,
            $this->secureOptions
        );
    }

    public function formatSystemMessage(string $template, array $variables): string
    {
        $content = strtr($template, $variables);

        return Str::inlineMarkdown(
            $content,
            [
                'html_input'         => 'escape',
                'allow_unsafe_links' => false,
            ]
        );
    }

    public function processFormData(array $data)
    {
        return collect($data)->map(fn ($value) => is_string($value)
                ? Str::transliterate($value)
                : $value)->all();
    }

    public function createSlug(string $title)
    {
        return Str::slug(Str::transliterate($title));
    }

    public function normalizeSearchQuery(string $query)
    {
        return mb_strtolower(Str::transliterate($query));
    }

    public function sanitizeKeywords(array $keywords)
    {
        return array_map(fn ($keyword) => Str::transliterate($keyword), $keywords);
    }
}
