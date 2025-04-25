<?php

namespace App\Pipelines\Advertisements;

use Illuminate\Database\Eloquent\Builder;

final readonly class FilterAdvertisementsByTitle
{
    public function __invoke(Builder $query, \Closure $next)
    {
        $field = 'title';
        if (request()->has($field)) {
            $query->whereLike($field, '%'.request($field).'%');
        }

        return $next($query);
    }
}
