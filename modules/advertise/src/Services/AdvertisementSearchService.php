<?php

declare(strict_types=1);

namespace Modules\Advertise\Services;

use App\Contracts\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Pipeline;
use Modules\Advertise\DataContracts\AdvertisementSearchDTO;
use Modules\Advertise\Http\Filters\FilterAdvertisementsByPhrase;
use Modules\Advertise\Models\Advertisement;
use phpDocumentor\Reflection\Types\ClassString;

final class AdvertisementSearchService
{
    public function getAdvertisements(Builder $builder, AdvertisementSearchDTO $searchDTO): LengthAwarePaginator
    {
        /** @var array<ClassString<Filter>> $filters */
        $filters = [
            //            FilterAdvertisementsByPhrase::class,
        ];

        return Pipeline::send($builder)
            ->through($filters)
            ->finally(function (): void {
                info('search request log.', request()->all());
            })
            ->then(fn (Builder $query) => $query
                ->active()
                ->published()
                ->when($searchDTO->phrase, fn (Builder|Advertisement $builder) => $builder->whereAny([
                    'title',
                    'description',
                    'tags',
                ], 'like', '%' . $searchDTO->phrase . '%'))
                ->when($searchDTO->ids, fn (Builder|Advertisement $builder) => $builder->whereIn('id', $searchDTO->ids))
                ->when($searchDTO->sort, fn (Builder|Advertisement $builder) => $builder->sortBy($searchDTO->sort))
                ->paginate($searchDTO->perPage)
                ->withQueryString());
    }
}
