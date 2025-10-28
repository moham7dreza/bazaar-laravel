<?php

declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Throwable;

class ImportUsersJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly int $page = 1,
    ) {

    }

    /**
     * @throws Throwable
     * @throws ConnectionException
     */
    public function handle(): void
    {
        $response = Http::throw()
            ->baseUrl('https://advertisements.google.com')
            ->withToken(config('services.google.token'))
            ->get('users/profile', [
                'page' => $this->page,
            ]);

        $jobs = [];

        foreach ($response->json('data') as $user)
        {
            $jobs[] = new ImportUserJob($user);
        }

        if (blank($jobs))
        {
            return;
        }

        $batch = Bus::batch($jobs)->allowFailures();

        if ($this->page < $response->json('last_page'))
        {
            $nextPage = $this->page + 1;

            $batch->finally(fn () => dispatch(new ImportUsersJob($nextPage)));
        }
        $batch->dispatch();
    }
}
