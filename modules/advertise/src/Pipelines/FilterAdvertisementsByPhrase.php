<?php

declare(strict_types=1);

namespace Modules\Advertise\Pipelines;

use Closure;
use Illuminate\Database\Eloquent\Builder;

final readonly class FilterAdvertisementsByPhrase
{
    public function __invoke(Builder $query, Closure $next)
    {
        if (request()->has('phrase'))
        {

            $query->whereAny([
                'title',
                'description',
                'tags',
            ], 'like', '%' . request('phrase') . '%');
        }

        return $next($query);
    }
}
