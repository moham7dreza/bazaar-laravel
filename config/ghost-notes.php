<?php

declare(strict_types=1);

return [
    'tags' => [
        '@ghost',
        '@todo',
        '@fixme',
        '@note',
    ],
    'filename'       => 'docs/GHOST_LOG.md',
    'ignore_folders' => [
        'vendor',
        'node_modules',
        'storage',
        'tests',
    ],
    'git_context' => true,

    // GitHub Repo URL (Mane: https://github.com/username/repo-name)
    'repo_url'       => env('GHOST_NOTES_REPO_URL', ''),
    'default_branch' => 'master',
];
