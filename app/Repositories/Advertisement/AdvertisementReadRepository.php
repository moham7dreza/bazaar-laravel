<?php

namespace App\Repositories\Advertisement;

use App\Abstracts\BaseRepository;
use App\Data\DTOs\PaginatedListViewDTO;
use App\Models\Advertise\Advertisement;
use Illuminate\Database\Eloquent\Builder;

class AdvertisementReadRepository extends BaseRepository
{
    public function getAdsOfUsersRegisteredWithinDate(int $limit, \DateTimeInterface $date, int $perPage = 20): PaginatedListViewDTO
    {
        $items = $this->freshQuery()->getQuery()
            ->with('user:created_at')
            ->whereHas('user', fn (Builder $query) => $query->createdAfter($date))
            ->take($limit)
            ->latest()
            ->paginate($perPage);

        return new PaginatedListViewDTO($items);
    }

    protected function baseQuery(): Builder
    {
        return Advertisement::query()->active();
    }
}
