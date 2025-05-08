<?php

namespace App\Http\Services\Advertisement;

use App\Data\DTOs\Advertisement\SearchDTO;
use App\Models\Advertise\Advertisement;
use App\Pipelines\Advertisements\FilterAdvertisementsByPhrase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

class SearchService
{
    public function getAdvertisements(SearchDTO $searchDTO)
    {
        return app(Pipeline::class)
            ->send(Advertisement::query())
            ->through([
                FilterAdvertisementsByPhrase::class,
            ])
            ->then(function (Builder $query) use ($searchDTO) {
                return $query
                    ->active()
                    ->published()
                    ->when($searchDTO->sort, fn (Builder $builder) => $builder->sortBy($searchDTO->sort))
                    ->paginate($searchDTO->perPage);
            });
    }
}
