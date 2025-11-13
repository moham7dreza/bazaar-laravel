<?php

declare(strict_types=1);

namespace Modules\Advertise\Repositories\Search;

use App\Http\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Pipeline;
use Modules\Advertise\DataContracts\AdvertisementSearchDTO;
use Modules\Advertise\Models\Advertisement;
use phpDocumentor\Reflection\Types\ClassString;

final readonly class AdvertisementEloquentSearchRepository implements AdvertisementSearchRepository
{
    public function search(AdvertisementSearchDTO $searchDTO): Collection
    {
        /** @var array<ClassString<Filter>> $filters */
        $filters = [
            //            FilterAdvertisementsByPhrase::class,
        ];

        return Pipeline::send(Advertisement::query())
            ->withinTransaction()
            ->through($filters)
            ->finally(function (): void {
                info('search request log.', request()->all());
            })
            ->then(
                fn (Builder $query) => $query
                    ->active()
                    ->published()
                    ->when($searchDTO->phrase, fn (Builder|Advertisement $builder) => $builder->whereAny([
                        'title',
                        'description',
                        'tags',
                    ], 'like', '%' . $searchDTO->phrase . '%'))
                    ->when($searchDTO->ids, fn (Builder|Advertisement $builder) => $builder->whereIntegerInRaw('id', $searchDTO->ids))
                    ->when($searchDTO->sort, fn (Builder|Advertisement $builder): Builder => $builder->sortBy($searchDTO->sort))
                    ->get()
            );
    }
}
