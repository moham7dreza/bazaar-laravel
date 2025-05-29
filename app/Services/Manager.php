<?php

declare(strict_types=1);

namespace App\Services;

final readonly class Manager
{
    public function __construct(
        public array $config,
    ) {
    }
}
