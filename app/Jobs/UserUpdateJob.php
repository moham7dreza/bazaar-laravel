<?php

declare(strict_types=1);

namespace App\Jobs;

use Amiriun\SMS\Services\SMSService;
use App\Enums\Queue;
use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

final class UserUpdateJob implements ShouldQueue
{
    use Batchable, Queueable;

    public function __construct(
        public readonly array $ids,
    ) {
        $this->onQueue(Queue::LOW);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        User::query()
            ->whereIn('id', $this->ids)
            ->select('*') // select only needed columns
            ->each(function (User $user): void {

                $user->updateQuietly(['is_active' => true]);

                $this->notifyUser($user->mobile);
            });
    }

    public function tags(): array
    {
        return [
            'user-batch-update',
        ];
    }

    private function notifyUser(string $mobile): void
    {
        $data = new \Amiriun\SMS\DataContracts\SendSMSDTO();
        $data->setSenderNumber('300024444');
        $data->setMessage('Hello, your account is activated');
        $data->setTo($mobile);

        app(SMSService::class)->send($data);
    }
}
