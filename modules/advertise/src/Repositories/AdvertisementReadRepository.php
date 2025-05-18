<?php

declare(strict_types=1);

namespace Modules\Advertise\Repositories;

use App\Abstracts\BaseRepository;
use App\Data\DTOs\PaginatedListViewDTO;
use App\Enums\UserId;
use App\Models\Scopes\LatestScope;
use DateTimeInterface;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Modules\Advertise\DataContracts\AdvertisementSearchDTO;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Services\AdvertisementSearchService;

final class AdvertisementReadRepository extends BaseRepository
{
    public function search(AdvertisementSearchDTO $searchDTO): PaginatedListViewDTO
    {
        $items = app(AdvertisementSearchService::class)->getAdvertisements(
            builder: $this->freshQuery()->getQuery(),
            searchDTO: $searchDTO,
        );

        return new PaginatedListViewDTO($items);
    }

    public function columnCounts(string $column): array
    {
        return $this->freshQuery()->getQuery()
            ->withoutGlobalScope(LatestScope::class)
            ->select($column, DB::raw('COUNT(*) as count'))
            ->groupBy($column)
            ->pluck('count', $column)
            ->toArray();
    }

    public function getAdsOfUsersRegisteredWithinDate(int $limit, DateTimeInterface $date, int $perPage = 20): PaginatedListViewDTO
    {
        $items = $this->freshQuery()->getQuery()
            ->with('user:created_at')
            ->whereHas('user', fn (Builder $query) => $query->createdAfter($date))
            ->active()
            ->published()
            ->take($limit)
            ->latest()
            ->paginate($perPage);

        return new PaginatedListViewDTO($items);
    }

    public function getTopAdsOfDistinctUsersHaveAvatar(int $limit, int $perPage = 20): PaginatedListViewDTO
    {
        $items = $this->freshQuery()->getQuery()
            ->select('user_id')
            ->distinct('user_id')
            ->whereRelation('user', function (Builder $query): void {
                $query
                    ->whereNotIn('id', [
                        UserId::Admin->value,
                    ])
                    ->whereNotNull('avatar_url');
            })
            ->with('user:id,avatar_url')
            ->inRandomOrder()
            ->active()
            ->published()
            ->take($limit)
            ->paginate($perPage);

        return new PaginatedListViewDTO($items);
    }

    public function getAdsWithCounts(int $limit, int $perPage = 20): PaginatedListViewDTO
    {
        $items = $this->freshQuery()->getQuery()
            ->select('*')
            ->withCount([
                'images',
                'viewedByUsers',
                'favoritedByUsers',
            ])
            ->inRandomOrder()
            ->active()
            ->published()
            ->take($limit)
            ->paginate($perPage);

        return new PaginatedListViewDTO($items);
    }

    protected function baseQuery(): Builder
    {
        return Advertisement::query()->active();
    }
}
