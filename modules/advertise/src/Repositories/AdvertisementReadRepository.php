<?php

declare(strict_types=1);

namespace Modules\Advertise\Repositories;

use App\Data\DTOs\PaginatedListViewDTO;
use App\Enums\UserId;
use App\Models\Scopes\LatestScope;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Advertise\DataContracts\AdvertisementSearchDTO;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Services\AdvertisementSearchService;

final class AdvertisementReadRepository
{
    public function search(AdvertisementSearchDTO $searchDTO): PaginatedListViewDTO
    {
        $items = app(AdvertisementSearchService::class)->getAdvertisements(
            builder: $this->baseQuery(),
            searchDTO: $searchDTO,
        );

        return new PaginatedListViewDTO($items);
    }

    public function columnCounts(string $column): array
    {
        return $this->baseQuery()
            ->withoutGlobalScope(LatestScope::class)
            ->select($column, DB::raw('COUNT(*) as count'))
            ->groupBy($column)
            ->pluck('count', $column)
            ->toArray();
    }

    public function getAdsOfUsersRegisteredWithinDate(int $limit, DateTimeInterface $date, int $perPage = 20): PaginatedListViewDTO
    {
        $items = $this->baseQuery()
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
        $items = $this->baseQuery()
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
        $items = $this->baseQuery()
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

    public function getAdsCountWhichTypeOfThemUsedMore()
    {
        return $this->baseQuery()
            ->select('ads_type', DB::raw('COUNT(*) as total'))
            ->groupBy('ads_type')
            ->having('total', '>', 10)
            ->toBase() // this is necessary for do not ignore groupBy and having
            ->getCountForPagination();
    }

    private function baseQuery(): Builder
    {
        return Advertisement::query()->active();
    }
}
