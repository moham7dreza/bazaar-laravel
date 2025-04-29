<?php

namespace App\Repositories\User;

use App\Models\Advertise\Advertisement;
use App\Models\User;
use Illuminate\Support\Collection;

class UserReadRepository
{
    public function getUsersWithLatestAdvertisementPostedDate(): Collection
    {
        return User::query()
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
}
