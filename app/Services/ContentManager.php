<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;

final class ContentManager
{
    public function findDormantAuthors(): Collection
    {
        return User::query()
            ->whereDoesntHaveRelation(
                'articles',
                'published_at',
                '>',
                Date::now()->subDays(60)
            )->get();
    }

    /*
     * TODO
    public function getUnmoderatedContent()
    {
        return Article::query()
            ->whereDoesntHaveRelation(
                'moderations',
                'reviewed_at',
                '!=',
                null
            )->get();
    }

    public function getUnpopularContent()
    {
        return Article::whereMorphDoesntHaveRelation(
            'reactions',
            [Like::class, Share::class, Bookmark::class],
            'created_at',
            '>',
            Date::now()->subMonth()
        )->get();
    }

    public function archiveStaleContent()
    {
        return Article::query()
            ->whereDoesntHaveRelation('comments', 'id', '!=', null)
            ->whereDoesntHaveRelation('views', 'id', '!=', null)
            ->whereDoesntHaveRelation(
                'updates',
                'created_at',
                '>',
                Date::now()->subMonths(6)
            )
            ->update(['status' => 'archived']);
    }
    */
}
