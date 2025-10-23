<?php

declare(strict_types=1);

namespace App\Data\DTOs;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

final class PaginatedListViewDTO extends Data
{
    public Collection $items;

    public int $total;

    public int $lastPage;

    public int $currentPage;

    public int $perPage;

    public function __construct(LengthAwarePaginator $paginator)
    {
        $this->items       = $paginator->getCollection();
        $this->total       = $paginator->total();
        $this->perPage     = $paginator->perPage();
        $this->currentPage = $paginator->currentPage();
        $this->lastPage    = $paginator->lastPage();
    }
}
