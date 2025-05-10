<?php

declare(strict_types=1);

namespace App\Http\Services\Advertisement;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;
use Modules\Advertise\DataContracts\AdvertisementSearchDTO;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Pipelines\FilterAdvertisementsByPhrase;

final class SearchService
{
    public function getAdvertisements(Builder $builder, AdvertisementSearchDTO $searchDTO)
    {
        return app(Pipeline::class)
            ->send($builder)
            ->through([
                FilterAdvertisementsByPhrase::class,
            ])
            ->then(fn (Builder $query) => $query
                ->active()
                ->published()
                ->when($searchDTO->ids, fn (Builder|Advertisement $builder) => $builder->whereIn('id', $searchDTO->ids))
                ->when($searchDTO->sort, fn (Builder|Advertisement $builder) => $builder->sortBy($searchDTO->sort))
                ->paginate($searchDTO->perPage)
                ->withQueryString());
    }
}
