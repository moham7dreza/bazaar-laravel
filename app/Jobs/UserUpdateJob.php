<?php

declare(strict_types=1);

namespace App\Jobs;

use Amiriun\SMS\DataContracts\SendSMSDTO;
use Amiriun\SMS\Services\SMSService;
use App\Enums\Queue;
use App\Enums\Sms\SmsSenderNumber;
use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\FailOnException;

final class UserUpdateJob implements ShouldQueue
{
    use Batchable, Queueable;

    public function __construct(
        public readonly array $ids,
    ) {
        $this->onQueue(Queue::LOW);
    }

    public function middleware(): array
    {
        return [
            new FailOnException([

            ]),
        ];
    }

    public function handle(): void
    {
        User::query()
            ->whereIntegerInRaw('id', $this->ids)
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
        $data = new SendSMSDTO();
        $data->setSenderNumber(SmsSenderNumber::NUMBER_1->value);
        $data->setMessage('Hello, your account is activated');
        $data->setTo($mobile);

        app(SMSService::class)->send($data);
    }
}
