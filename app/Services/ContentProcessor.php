<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Str;

class ContentProcessor
{
    protected array $secureOptions = [
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
}
