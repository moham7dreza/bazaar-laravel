<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Documentation - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gray-50 dark:bg-gray-900">
    <div class="min-h-full">
        <!-- Navigation -->
        <nav class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <h1 class="text-xl font-bold text-gray-900 dark:text-white">📚 Task Documentation</h1>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <a href="/" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                            ← Back to App
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <!-- Search and Filters -->
            <div class="px-4 sm:px-0 mb-6">
                <form method="GET" action="{{ route('documentation.index') }}" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search -->
                        <div class="md:col-span-2">
                            <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Search
                            </label>
                            <input
                                type="text"
                                id="search"
                                name="search"
                                value="{{ $search }}"
                                placeholder="Search by title, description, Jira ticket..."
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                            >
                        </div>

                        <!-- Module Filter -->
                        <div>
                            <label for="module" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Module
                            </label>
                            <select
                                id="module"
                                name="module"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                            >
                                <option value="">All Modules</option>
                                @foreach($modules as $mod)
                                    <option value="{{ $mod }}" {{ $selectedModule === $mod ? 'selected' : '' }}>
                                        {{ $mod }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Type Filter -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Type
                            </label>
                            <select
                                id="type"
                                name="type"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                            >
                                <option value="">All Types</option>
                                @foreach($types as $t)
                                    <option value="{{ $t }}" {{ $selectedType === $t ? 'selected' : '' }}>
                                        {{ ucfirst($t) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 flex gap-2">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            Search
                        </button>
                        <a
                            href="{{ route('documentation.index') }}"
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600"
                        >
                            Clear Filters
                        </a>
                    </div>
                </form>
            </div>

            <!-- Results -->
            <div class="px-4 sm:px-0">
                @if($documents->isEmpty())
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-6 text-center">
                        <p class="text-yellow-800 dark:text-yellow-200">
                            No documentation found. Create your first documentation using:
                        </p>
                        <code class="block mt-2 bg-yellow-100 dark:bg-yellow-900/40 px-4 py-2 rounded">
                            php artisan make:task-doc
                        </code>
                    </div>
                @else
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                                Found {{ $documents->count() }} {{ Str::plural('document', $documents->count()) }}
                            </h2>
                        </div>
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($documents as $doc)
                                <li class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <a href="{{ route('documentation.show', $doc['filename']) }}" class="block px-6 py-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-2">
                                                    <span class="px-2 py-1 text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded">
                                                        {{ $doc['jira_ticket'] }}
                                                    </span>
                                                    <span class="px-2 py-1 text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded">
                                                        {{ $doc['module'] }}
                                                    </span>
                                                    <span class="px-2 py-1 text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded">
                                                        {{ ucfirst($doc['type']) }}
                                                    </span>
                                                    @if($doc['priority'] === 'high' || $doc['priority'] === 'critical')
                                                        <span class="px-2 py-1 text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded">
                                                            {{ ucfirst($doc['priority']) }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                                    {{ $doc['title'] }}
                                                </h3>
                                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                    {{ $doc['description'] }}
                                                </p>
                                                <div class="mt-2 flex items-center text-xs text-gray-500 dark:text-gray-400">
                                                    <span>By {{ $doc['author'] }}</span>
                                                    <span class="mx-2">•</span>
                                                    <span>{{ date('Y-m-d', $doc['created_at']) }}</span>
                                                    @if($doc['branch'])
                                                        <span class="mx-2">•</span>
                                                        <code class="bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded">{{ $doc['branch'] }}</code>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>

