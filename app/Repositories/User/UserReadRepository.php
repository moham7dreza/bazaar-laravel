<?php

namespace App\Repositories\User;

use App\Abstracts\BaseRepository;
use App\Models\Advertise\Advertisement;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class UserReadRepository extends BaseRepository
{
    public function findById(int $id): ?User
    {
        return $this->baseQuery()
            ->where('id', $id)
            ->first();
    }

    public function getUserByMobile(string $mobile): ?User
    {
        return $this->freshQuery()->getQuery()->where('mobile', $mobile)->first();
    }

    public function getUsersWithLatestAdvertisementPostedDate(): Collection
    {
        return $this->freshQuery()->getQuery()
            ->select('*') // only get required fields
            ->addSelect([
                'latest_advertisement_posted_at' => Advertisement::query()
                    ->select('created_at')
                    ->whereColumn('user_id', 'users.id')
                    ->latest()
                    ->limit(1),
            ])
            ->take(1000)
            ->get();
    }

    protected function baseQuery(): Builder
    {
        return User::query();
    }
}
