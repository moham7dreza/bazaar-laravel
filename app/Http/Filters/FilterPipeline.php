<?php

declare(strict_types=1);

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Pipeline;

class FilterPipeline
{
    protected array $filters = [];

    public function __construct(
        public readonly Builder $builder,
        public readonly Request $request,
    ) {
    }

    public function addFilter(Filter $filter): Filter
    {
        $this->filters[] = new $filter($this->request);

        return end($this->filters);
    }

    public function process()
    {
        return resolve(Pipeline::class)
            ->send($this->builder)
            ->through($this->filters)
            ->withinTransaction()
            ->thenReturn();
    }
}
