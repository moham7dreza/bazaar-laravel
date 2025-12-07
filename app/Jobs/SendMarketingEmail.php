<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Services\EmailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Queue;
use Symfony\Component\HttpFoundation\Response;

class SendMarketingEmail implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $userId,
        public int $campaignId,
    ) {
    }

    /**
     * @throws RequestException
     */
    public function handle(EmailService $emailService): void
    {
        try
        {
            $emailService->send($this->userId, $this->campaignId);
        } catch (RequestException $requestException)
        {
            if (Response::HTTP_TOO_MANY_REQUESTS === $requestException->response->status())
            {
                $retryAfter = $requestException->response->header('Retry-After');

                if ( ! $retryAfter)
                {
                    $retryAfter = 60;
                }

                // Pause the entire queue for the rate limit duration
                Queue::pauseFor(
                    connection: $this->connection ?? config()->string('queue.default'),
                    queue: $this->queue           ?? 'default',
                    ttl: (int) $retryAfter
                );

                // Release this job to be picked up when queue resumes
                $this->release((int) $retryAfter);
            }

            throw $requestException;
        }
    }
}
