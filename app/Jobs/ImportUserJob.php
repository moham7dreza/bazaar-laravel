<?php

declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ImportUserJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public $user
    ) {

    }

    public function handle(): void
    {

    }
}
