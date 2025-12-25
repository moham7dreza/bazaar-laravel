<?php

declare(strict_types=1);

namespace App\Http\Filters;

class FilterBase
{
    protected array $filters = [
        'where'       => [],
        'whereIn'     => [],
        'trashed'     => null,
        'search'      => null,
        'sort_by'     => 'id',
        'sort_order'  => 'desc',
    ];

    public static function make(): self
    {
        return new static();
    }

    public function setWhere(string $column, string $operator, $value): self
    {
        $this->filters['where'][] = [$column, $operator, $value];

        return $this;
    }

    public function setWhereIn(string $column, array $values): self
    {
        $this->filters['whereIn'][$column] = $values;

        return $this;
    }

    public function setTrashed(string $mode): self // 'with', 'only'
    {
        $this->filters['trashed'] = $mode;

        return $this;
    }

    public function setSearch(?string $search): self
    {
        $this->filters['search'] = $search;

        return $this;
    }

    public function setSort(string $column, string $direction = 'desc'): self
    {
        $this->filters['sort_by']    = $column;
        $this->filters['sort_order'] = $direction;

        return $this;
    }

    public function toArray(): array
    {
        return $this->filters;
    }
}
