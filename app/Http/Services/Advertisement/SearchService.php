<?php

namespace App\Http\Services\Advertisement;

use App\Data\DTOs\Advertisement\SearchDTO;
use App\Models\Advertise\Advertisement;
use App\Pipelines\Advertisements\FilterAdvertisementsByPhrase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

class SearchService
{
    public function getAdvertisements(Builder $builder, SearchDTO $searchDTO)
    {
        return app(Pipeline::class)
            ->send($builder)
            ->through([
                FilterAdvertisementsByPhrase::class,
            ])
            ->then(function (Builder $query) use ($searchDTO) {
                return $query
                    ->active()
                    ->published()
                    ->when($searchDTO->ids, fn (Builder|Advertisement $builder) => $builder->whereIn('id', $searchDTO->ids))
                    ->when($searchDTO->sort, fn (Builder|Advertisement $builder) => $builder->sortBy($searchDTO->sort))
                    ->paginate($searchDTO->perPage)
                    ->withQueryString();
            });
    }
}
