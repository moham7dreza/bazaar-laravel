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
    use Batchable;
    use Queueable;
    public function __construct(
        public readonly array $ids,
    ) {
        $this->onQueue(Queue::Low);
    }

    public function middleware(): array
    {
        return [
            //            new FailOnException(fn (\Throwable $e, mixed $job): bool => /* ... */),
            new FailOnException([

            ]),
        ];
    }

    public function handle(SMSService $SMSService): void
    {
        User::query()
            ->whereIntegerInRaw('id', $this->ids)
            ->select('*') // select only needed columns
            ->each(function (User $user) use ($SMSService): void {

                $user->updateQuietly(['is_active' => true]);

                $data = new SendSMSDTO();
                $data->setSenderNumber(SmsSenderNumber::Number1->value);
                $data->setMessage('Hello, your account is activated');
                $data->setTo($user->mobile);

                $SMSService->send($data);
            });
    }

    public function tags(): array
    {
        return [
            'user-batch-update',
        ];
    }
}
