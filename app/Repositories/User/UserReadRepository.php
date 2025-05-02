<?php

namespace App\Repositories\User;

use App\Abstracts\BaseRepository;
use App\Data\DTOs\PaginatedListViewDTO;
use App\Models\Advertise\Advertisement;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserReadRepository extends BaseRepository
{
    public function getUsersWithLatestAdvertisementPostedDate(int $limit = 1000, int $perPage = 20): PaginatedListViewDTO
    {
        $items = $this->freshQuery()->getQuery()
            ->select('*') // only get required fields
            ->addSelect([
                'latest_advertisement_posted_at' => Advertisement::query()
                    ->select('created_at')
                    ->whereColumn('user_id', 'users.id')
                    ->latest()
                    ->limit(1),
            ])
            ->take($limit)
            ->latest()
            ->paginate($perPage);

        return new PaginatedListViewDTO($items);
    }

    protected function baseQuery(): Builder
    {
        return User::query();
    }
}
