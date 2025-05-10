<?php

declare(strict_types=1);

namespace Modules\Advertise\DataContracts;

use Modules\Advertise\Enums\Sort;

final readonly class AdvertisementSearchDTO
{
    public function __construct(
        public ?string $phrase,
        public ?Sort $sort,
        public int $perPage,
        public array $ids,
    ) {

    }
}
