<?php

namespace App\Data\DTOs\Advertisement;

use App\Enums\Advertisement\Sort;

final readonly class SearchDTO
{
    public function __construct(
        public ?string $phrase,
        public ?Sort $sort,
        public int $perPage,
    ) {
        //
    }
}
