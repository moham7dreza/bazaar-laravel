<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Filters;

use App\Http\Filters\Filter;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;

class FilterAdvertisementsByPhrase implements Filter
{
    public function __construct(
        private readonly Request $request,
    ) {
    }

    public function handle(Builder|Relation $query, Closure $next)
    {
        if ($this->request->has('phrase'))
        {
            $query->whereAny([
                'title',
                'description',
                'tags',
            ], 'like', '%' . $this->request->get('phrase') . '%');
        }

        return $next($query);
    }
}
