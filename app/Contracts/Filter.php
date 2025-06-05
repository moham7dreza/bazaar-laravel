<?php

declare(strict_types=1);

namespace App\Contracts;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

interface Filter
{
    public function handle(Builder|Relation $query, Closure $next);
}
