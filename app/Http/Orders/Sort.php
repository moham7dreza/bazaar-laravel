<?php

declare(strict_types=1);

namespace App\Http\Orders;

use Illuminate\Database\Query\Builder;

final class Sort
{
    // flights/123/reservations?sort=seatNumber,-createdAt
    public static function apply(
        ?string $sort,
        Builder $query,
        string $tableName,
        array $supportedFields,
    ): void {
        if (blank($sort))
        {
            return;
        }

        $sortFields = explode(',', $sort);

        foreach ($sortFields as $sortField)
        {
            $sortOrder = 'ASC';

            if ('-' === \Illuminate\Support\Arr::get($sortField, 0))
            {
                $sortOrder = 'DESC';
                $sortField = mb_substr($sortField, 1);
            }

            if (in_array($sortField, $supportedFields, true))
            {
                $query->orderBy("{$tableName}.{$sortField}", $sortOrder);
            }
        }
    }
}
