<?php

namespace App\Pipelines\Advertisements;

use Illuminate\Database\Eloquent\Builder;

final readonly class FilterAdvertisementsByPhrase
{
    public function __invoke(Builder $query, \Closure $next)
    {
        if (request()->has('phrase')) {

            $query->whereLike('title', '%'.request('phrase').'%');
        }

        return $next($query);
    }
}
