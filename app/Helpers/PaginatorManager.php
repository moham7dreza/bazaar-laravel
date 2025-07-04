<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class PaginatorManager
{
    private function calculateSideLinks(LengthAwarePaginator $paginator): int
    {
        return match (true) {
            $paginator->lastPage() > 30 => 3,
            $paginator->lastPage() > 20 => 2,
            default => 1,
        };
    }

    public function paginate(Collection $items, int $currentPage, int $perPage): LengthAwarePaginator
    {
        $paginator = new LengthAwarePaginator(
            items: $items->forPage($currentPage, $perPage),
            total: $items->count(),
            perPage: $perPage,
            currentPage: $currentPage,
            options: [
                'path' => request()->url(),
                'pageName' => 'page',
            ]
        );

        $sideLinks = $this->calculateSideLinks($paginator);

        $paginator->onEachSide($sideLinks);

        return $paginator;
    }
}
