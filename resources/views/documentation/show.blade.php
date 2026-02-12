<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $metadata['title'] ?? $filename }} - Documentation</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .documentation-content h1 { @apply text-3xl font-bold text-gray-900 dark:text-white mb-4; }
        .documentation-content h2 { @apply text-2xl font-bold text-gray-900 dark:text-white mt-8 mb-4; }
        .documentation-content h3 { @apply text-xl font-semibold text-gray-900 dark:text-white mt-6 mb-3; }
        .documentation-content p { @apply text-gray-700 dark:text-gray-300 mb-4 leading-relaxed; }
        .documentation-content ul { @apply list-disc ml-6 mb-4 text-gray-700 dark:text-gray-300; }
        .documentation-content ol { @apply list-decimal ml-6 mb-4 text-gray-700 dark:text-gray-300; }
        .documentation-content li { @apply mb-2; }
        .documentation-content code { @apply bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded text-sm font-mono; }
        .documentation-content pre { @apply bg-gray-100 dark:bg-gray-800 p-4 rounded overflow-x-auto mb-4; }
        .documentation-content pre code { @apply bg-transparent p-0; }
        .documentation-content blockquote { @apply border-l-4 border-gray-300 dark:border-gray-600 pl-4 italic text-gray-600 dark:text-gray-400 mb-4; }
        .documentation-content table { @apply w-full border-collapse mb-4; }
        .documentation-content th { @apply bg-gray-100 dark:bg-gray-800 px-4 py-2 text-left font-semibold text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600; }
        .documentation-content td { @apply px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300; }
        .documentation-content a { @apply text-blue-600 dark:text-blue-400 hover:underline; }
    </style>
</head>
<body class="h-full bg-gray-50 dark:bg-gray-900">
    <div class="min-h-full">
        <!-- Navigation -->
        <nav class="bg-white dark:bg-gray-800 shadow sticky top-0 z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('documentation.index') }}" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white flex items-center gap-2">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Back to Documentation
                        </a>
                    </div>
                    <div class="flex items-center gap-4">
                        <button
                            onclick="copyToClipboard()"
                            class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white flex items-center gap-1"
                        >
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            Copy Link
                        </button>
                        <button
                            onclick="window.print()"
                            class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white flex items-center gap-1"
                        >
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Print
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <!-- Metadata Card -->
            @if($metadata)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @if(isset($metadata['author']))
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Author</h4>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $metadata['author'] }}</p>
                            </div>
                        @endif
                        @if(isset($metadata['date']))
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Date</h4>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $metadata['date'] }}</p>
                            </div>
                        @endif
                        @if(isset($metadata['branch']))
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Branch</h4>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    <code class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">{{ $metadata['branch'] }}</code>
                                </p>
                            </div>
                        @endif
                        @if(isset($metadata['module']))
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Module</h4>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $metadata['module'] }}</p>
                            </div>
                        @endif
                        @if(isset($metadata['type']))
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Type</h4>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ ucfirst($metadata['type']) }}</p>
                            </div>
                        @endif
                        @if(isset($metadata['priority']))
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Priority</h4>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    <span class="px-2 py-1 rounded text-xs font-medium
                                        {{ $metadata['priority'] === 'critical' || $metadata['priority'] === 'high' ? 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200' }}">
                                        {{ ucfirst($metadata['priority']) }}
                                    </span>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Documentation Content -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-8 documentation-content prose prose-lg max-w-none">
                {!! $content !!}
            </div>

            <!-- Raw Markdown View (Collapsible) -->
            <div class="mt-6">
                <details class="bg-gray-100 dark:bg-gray-800 rounded-lg">
                    <summary class="px-6 py-4 cursor-pointer font-medium text-gray-900 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg">
                        View Raw Markdown
                    </summary>
                    <div class="px-6 pb-6">
                        <pre class="bg-gray-900 text-gray-100 p-4 rounded overflow-x-auto text-sm"><code>{{ $rawContent }}</code></pre>
                    </div>
                </details>
            </div>
        </main>
    </div>

    <script>
        function copyToClipboard() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                alert('Link copied to clipboard!');
            });
        }
    </script>
</body>
</html>

