<?php

declare(strict_types=1);

namespace App\Services;

class Manager
{
    public function __construct(
        public readonly array $config,
    ) {}
}
