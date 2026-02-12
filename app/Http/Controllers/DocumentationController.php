<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use SplFileInfo;

class DocumentationController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $module = $request->input('module');
        $type   = $request->input('type');

        $docsPath = base_path('docs/features');
        $files    = collect(File::files($docsPath))
            ->filter(fn ($file) => ! str_contains($file->getFilename(), 'TEMPLATE'))
            ->map(fn ($file) => $this->parseDocumentationFile($file))
            ->filter(function ($doc) use ($search, $module, $type) {
                if ($search && ! $this->matchesSearch($doc, $search))
                {
                    return false;
                }

                if ($module && ! str_contains(mb_strtolower($doc['module']), mb_strtolower($module)))
                {
                    return false;
                }

                return ! ($type && mb_strtolower($doc['type']) !== mb_strtolower($type));
            })
            ->sortByDesc('created_at')
            ->values();

        $modules = $this->getUniqueModules();
        $types   = ['feature', 'bug', 'enhancement', 'refactor'];

        return view('documentation.index', [
            'documents'      => $files,
            'search'         => $search,
            'modules'        => $modules,
            'types'          => $types,
            'selectedModule' => $module,
            'selectedType'   => $type,
        ]);
    }

    public function show(string $filename): View
    {
        $filePath = base_path("docs/features/{$filename}");

        abort_if( ! File::exists($filePath), 404, 'Documentation not found');

        $content     = File::get($filePath);
        $metadata    = $this->extractMetadata($content);
        $htmlContent = $this->parseMarkdown($content);

        return view('documentation.show', [
            'filename'   => $filename,
            'content'    => $htmlContent,
            'metadata'   => $metadata,
            'rawContent' => $content,
        ]);
    }

    protected function parseDocumentationFile(SplFileInfo $file): array
    {
        $content  = File::get($file->getPathname());
        $metadata = $this->extractMetadata($content);

        // Extract Jira ticket from filename
        $filename = $file->getFilename();
        preg_match('/^([A-Z]+-\d+)-(.+)\.md$/', $filename, $matches);

        return [
            'filename'    => $filename,
            'jira_ticket' => $matches[1]        ?? 'Unknown',
            'title'       => $metadata['title'] ?? $this->extractTitle($content),
            'description' => $this->extractDescription($content),
            'module'      => $metadata['module']   ?? 'General',
            'type'        => $metadata['type']     ?? 'feature',
            'priority'    => $metadata['priority'] ?? 'medium',
            'author'      => $metadata['author']   ?? 'Unknown',
            'created_at'  => $file->getMTime(),
            'branch'      => $metadata['branch'] ?? null,
        ];
    }

    protected function extractMetadata(string $content): array
    {
        $metadata = [];

        // Extract from frontmatter or metadata table
        if (preg_match('/\*\*Author\*\*:\s*(.+)/i', $content, $matches))
        {
            $metadata['author'] = mb_trim($matches[1]);
        }

        if (preg_match('/\*\*Date\*\*:\s*(.+)/i', $content, $matches))
        {
            $metadata['date'] = mb_trim($matches[1]);
        }

        if (preg_match('/\*\*Branch\*\*:\s*`(.+)`/i', $content, $matches))
        {
            $metadata['branch'] = mb_trim($matches[1]);
        }

        if (preg_match('/\*\*Module\*\*\s*\|\s*(.+)/i', $content, $matches))
        {
            $metadata['module'] = mb_trim($matches[1]);
        }

        if (preg_match('/\*\*Task Type\*\*\s*\|\s*(.+)/i', $content, $matches))
        {
            $metadata['type'] = mb_trim($matches[1]);
        }

        if (preg_match('/\*\*Priority\*\*\s*\|\s*(.+)/i', $content, $matches))
        {
            $metadata['priority'] = mb_trim($matches[1]);
        }

        // Extract title from first heading
        if (preg_match('/^#\s+(.+)$/m', $content, $matches))
        {
            $metadata['title'] = mb_trim($matches[1]);
        }

        return $metadata;
    }

    protected function extractTitle(string $content): string
    {
        if (preg_match('/^#\s+(.+)$/m', $content, $matches))
        {
            return mb_trim($matches[1]);
        }

        return 'Untitled';
    }

    protected function extractDescription(string $content): string
    {
        // Extract first paragraph under "What Problem Does This Solve?"
        if (preg_match('/###\s+What Problem Does This Solve\?\s+(.+?)(?=\n\n|###)/s', $content, $matches))
        {
            return Str::limit(mb_trim($matches[1]), 200);
        }

        // Fallback to first paragraph
        if (preg_match('/\n\n(.+?)\n\n/s', $content, $matches))
        {
            return Str::limit(mb_trim($matches[1]), 200);
        }

        return 'No description available';
    }

    protected function matchesSearch(array $doc, string $search): bool
    {
        $searchLower = mb_strtolower($search);

        return str_contains(mb_strtolower($doc['title']), $searchLower)
            || str_contains(mb_strtolower($doc['description']), $searchLower)
            || str_contains(mb_strtolower($doc['jira_ticket']), $searchLower)
            || str_contains(mb_strtolower($doc['module']), $searchLower);
    }

    protected function getUniqueModules(): array
    {
        $docsPath = base_path('docs/features');
        $files    = collect(File::files($docsPath))
            ->filter(fn ($file) => ! str_contains($file->getFilename(), 'TEMPLATE'))
            ->map(fn ($file) => $this->parseDocumentationFile($file))
            ->pluck('module')
            ->unique()
            ->sort()
            ->values()
            ->toArray();

        return $files;
    }

    protected function parseMarkdown(string $content): string
    {
        // Basic Markdown to HTML conversion
        // For production, use a library like league/commonmark

        // Headers
        $content = preg_replace('/^### (.+)$/m', '<h3>$1</h3>', $content);
        $content = preg_replace('/^## (.+)$/m', '<h2>$1</h2>', $content);
        $content = preg_replace('/^# (.+)$/m', '<h1>$1</h1>', $content);

        // Bold
        $content = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $content);

        // Italic
        $content = preg_replace('/\*(.+?)\*/', '<em>$1</em>', $content);

        // Links
        $content = preg_replace('/\[(.+?)\]\((.+?)\)/', '<a href="$2" target="_blank" class="text-blue-600 hover:underline">$1</a>', $content);

        // Code blocks
        $content = preg_replace('/```(\w+)?\n(.+?)\n```/s', '<pre class="bg-gray-100 dark:bg-gray-800 p-4 rounded overflow-x-auto"><code>$2</code></pre>', $content);

        // Inline code
        $content = preg_replace('/`(.+?)`/', '<code class="bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded text-sm">$1</code>', $content);

        // Lists
        $content = preg_replace('/^\- (.+)$/m', '<li>$1</li>', $content);
        $content = preg_replace('/(<li>.*<\/li>)/s', '<ul class="list-disc ml-6">$1</ul>', $content);

        // Blockquotes
        $content = preg_replace('/^> (.+)$/m', '<blockquote class="border-l-4 border-gray-300 pl-4 italic">$1</blockquote>', $content);

        // Paragraphs
        $content = preg_replace('/\n\n/', '</p><p class="mb-4">', $content);
        $content = '<p class="mb-4">' . $content . '</p>';

        return $content;
    }
}
