<?php

declare(strict_types=1);

namespace Modules\Monitoring\Jobs;

use App\Enums\Queue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Modules\Monitoring\Models\DevLog;

final class MongoLogJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 0;

    public function __construct(
        public readonly array $data,
        public readonly string $logKey,
    ) {
        $this->delay(now()->addSeconds(5));
        $this->onQueue(Queue::MONGO_LOG);
    }

    public function handle(): void
    {
        DevLog::query()->create(array_merge($this->data, ['log_key' => $this->logKey]));
    }

    public function tags(): array
    {
        return [
            'mongo-log',
        ];
    }
}
