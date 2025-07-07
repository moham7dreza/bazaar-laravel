<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Data\DTOs\PaginatedListViewDTO;
use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Modules\Advertise\Models\Advertisement;

final class UserReadRepository
{
    private Builder $baseQuery;

    public function __construct()
    {
        $this->baseQuery = User::query();
    }

    public function getUsersWithLatestAdvertisementPostedDate(int $limit = 1000, int $perPage = 20): PaginatedListViewDTO
    {
        $items = $this->baseQuery->clone()
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

    public function getUsersWithSpecialAdvertisements(int $limit = 1000, int $perPage = 20): PaginatedListViewDTO
    {
        $items = $this->baseQuery->clone()
            ->select('*') // only get required fields
            ->withWhereHas('advertisements', fn (Builder $builder) => $builder->where('is_special', true))
            ->take($limit)
            ->latest()
            ->paginate($perPage);

        return new PaginatedListViewDTO($items);
    }

    public function getCountOfUsersRole(UserRole $role): int
    {
        return $this->baseQuery->clone()
            ->with('roles')
            ->get()
            ->filter(fn (User $user) => $user->roles->where('name', $role)->toArray())
            ->count();
    }

    public function getCountOfUsersPermission(UserPermission $permission): int
    {
        return $this->baseQuery->clone()
            ->with('permissions')
            ->get()
            ->filter(fn (User $user) => $user->permissions->where('name', $permission)->toArray())
            ->count();
    }
}
