<?php

declare(strict_types=1);

namespace App\Stacks;

use http\Exception\InvalidArgumentException;
use JsonException;
use Redis;

class HistoryStack
{
    public function __construct(
        private readonly Redis $redis,
    ) {
    }

    /**
     * @throws JsonException
     */
    public function push(array $event, int $userId): void
    {
        $this->redis->lPush(
            "history:todos:{$event['data']['todo_id']}:{$userId}",
            json_encode($event, JSON_THROW_ON_ERROR)
        );
    }

    /**
     * @throws JsonException
     */
    public function pop(int $todoId, int $userId): array
    {
        $eventJson = $this->redis->lpop("history:todos:{$todoId}:{$userId}");

        throw_unless($eventJson, InvalidArgumentException::class, 'Event not found in redis');

        return json_decode($eventJson, true, 512, JSON_THROW_ON_ERROR);
    }
}
