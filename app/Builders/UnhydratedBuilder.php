<?php

declare(strict_types=1);

namespace App\Builders;

use Illuminate\Support\Arr;
use Closure;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Cursor;
use Illuminate\Pagination\Paginator;
use Throwable;

class UnhydratedBuilder extends EloquentBuilder
{
    /**
     * Get the unhydrated results (raw database results).
     *
     * @throws Throwable
     */
    public function getUnhydrated(array|string $columns = ['*']): Collection
    {
        return $this->toBase()->get($columns);
    }

    /**
     * Paginate the unhydrated query (LengthAwarePaginator).
     *
     * @throws Throwable
     */
    public function paginateUnhydrated(
        int|null|Closure $perPage = null,
        array|string $columns = ['*'],
        string $pageName = 'page',
        ?int $page = null,
        int|null|Closure $total = null,
    ): LengthAwarePaginator {
        $page    = $page ?: Paginator::resolveCurrentPage($pageName);
        $total   = value($total) ?? $this->toBase()->getCountForPagination();
        $perPage = value($perPage, $total) ?: $this->model->getPerPage();

        $results = $total
            ? $this->forPage($page, $perPage)->getUnhydrated($columns)
            : $this->model->newCollection();

        return $this->paginator($results, $total, $perPage, $page, [
            'path'     => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }

    /**
     * Simple paginate the unhydrated query (Paginator).
     *
     * @throws Throwable
     */
    public function simplePaginateUnhydrated(
        ?int $perPage = null,
        array $columns = ['*'],
        string $pageName = 'page',
        ?int $page = null
    ): Paginator {
        $page    = $page ?: Paginator::resolveCurrentPage($pageName);
        $perPage = $perPage ?: $this->model->getPerPage();

        $this->skip(($page - 1) * $perPage)->take($perPage + 1);

        return $this->simplePaginator($this->getUnhydrated($columns), $perPage, $page, [
            'path'     => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }

    /**
     * Cursor paginate the unhydrated query.
     *
     * @throws Throwable
     */
    public function cursorPaginateUnhydrated(
        ?int $perPage = null,
        array|string $columns = ['*'],
        string $cursorName = 'cursor',
        Cursor|string|null $cursor = null
    ): CursorPaginator {
        $perPage = $perPage ?: $this->model->getPerPage();

        return $this->paginateUsingCursorUnhydrated($perPage, $columns, $cursorName, $cursor);
    }

    /**
     * Paginate using cursor with unhydrated results.
     *
     * @throws Throwable
     */
    public function paginateUsingCursorUnhydrated(
        int $perPage,
        array|string $columns = ['*'],
        string $cursorName = 'cursor',
        Cursor|string|null $cursor = null
    ): CursorPaginator {
        if ( ! $this->query->orders)
        {
            $this->oldest($this->model->getQualifiedKeyName());
        }

        $orders = collect($this->query->orders)
            ->map(fn ($order) => [
                'column'    => Arr::get($order, 'column'),
                'direction' => Arr::get($order, 'direction'),
            ]);

        $cursor = $cursor instanceof Cursor
            ? $cursor
            : Cursor::fromEncoded($cursor);

        $comparisons = $cursor?->toComparisons() ?? [];

        $this->addCursorWhereConditions($cursor, $orders, $comparisons);

        $this->take($perPage + 1);

        return $this->cursorPaginator($this->getUnhydrated($columns), $perPage, $cursor, [
            'path'       => Paginator::resolveCurrentPath(),
            'cursorName' => $cursorName,
            'parameters' => $orders->pluck('column')->toArray(),
        ]);
    }
}
