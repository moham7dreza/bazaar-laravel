<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

final class ForumPostService
{
    public function processReply(string $content, User $author): bool
    {
        // Handle code blocks and formatting
        $formatted = Str::inlineMarkdown($content, [
            'html_input'         => 'strip',
            'allow_unsafe_links' => false,
            'use_autolinks'      => true,
        ]);

        return $this->addAuthorContext($formatted, $author);
    }

    public function formatQuote(string $originalContent, string $newContent): string
    {
        $quote    = '> ' . str_replace("\n", "\n> ", $originalContent);
        $combined = $quote . "\n\n" . $newContent;

        return Str::inlineMarkdown($combined, [
            'html_input'         => 'strip',
            'allow_unsafe_links' => false,
        ]);
    }

    public function processCodeSnippet(string $content): string
    {
        return Str::inlineMarkdown($content, [
            'html_input'         => 'strip',
            'allow_unsafe_links' => false,
            'use_underline'      => false, // Prevent conflicts with code
        ]);
    }

    private function addAuthorContext(string $formatted, User $author): bool
    {
        return true;
    }
}
