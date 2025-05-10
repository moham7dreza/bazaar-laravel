<?php

declare(strict_types=1);

namespace App\Data\DTOs\Advertisement;

use Modules\Advertise\Enums\Sort;

final readonly class SearchDTO
{
    public function __construct(
        public ?string $phrase,
        public ?Sort $sort,
        public int $perPage,
        public array $ids,
    ) {

    }
}
