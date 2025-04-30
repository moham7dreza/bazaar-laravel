<?php

namespace App\Repositories\Advertisement;

use App\Abstracts\BaseRepository;
use App\Data\DTOs\PaginatedListViewDTO;
use App\Models\Advertise\Advertisement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class AdvertisementReadRepository extends BaseRepository
{
    public function getAdsOfUsersRegisteredWithinDate($date, $perPage): PaginatedListViewDTO
    {
        $items = $this->freshQuery()->getQuery()
            ->with('user:created_at')
            ->whereHas('user', fn (Builder $query) => $query->whereDate('created_at', '>=', Carbon::parse($date)))
            ->latest()
            ->paginate($perPage);

        return new PaginatedListViewDTO($items);
    }

    protected function baseQuery(): Builder
    {
        return Advertisement::query()->active();
    }
}
