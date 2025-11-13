<?php

declare(strict_types=1);

namespace Modules\Advertise\DataContracts;

use Modules\Advertise\Enums\Sort;
use Spatie\LaravelData\Data;

final class AdvertisementSearchDTO extends Data
{
    public function __construct(
        public ?string $phrase,
        public ?Sort $sort,
        public int $perPage = 24,
        public int $page = 1,
        public array $ids = [],
    ) {

    }
}
