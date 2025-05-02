<?php

use App\Abstracts\BaseRepository;
use App\Data\DTOs\PaginatedListViewDTO;
use Illuminate\Database\Eloquent\Builder;

// TODO implement Message entity

class MessageReadRepository extends BaseRepository
{
    public function getUserUnreadMessages(int $userId, int $limit = 20, int $perPage = 20): PaginatedListViewDTO
    {
        $items = $this->freshQuery()->getQuery()
            ->with('user')
            // sender_id filed in `nullable` in database
            ->where(fn (Builder $builder) => $builder->whereNot('sender_id', $userId)
                // this is necessary for get records which sender_id of them is null
                ->orWhereNull('sender_id'))
            ->canBeSeenBy($userId)
            ->notSeenBy($userId)
            ->latest()
            ->paginate($perPage);

        return new PaginatedListViewDTO($items);
    }

    protected function baseQuery(): Builder
    {
        return Message::query();
    }
}
