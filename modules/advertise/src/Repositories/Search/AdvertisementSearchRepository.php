<?php

declare(strict_types=1);

namespace Modules\Advertise\Repositories\Search;

use Illuminate\Database\Eloquent\Collection;
use Modules\Advertise\DataContracts\AdvertisementSearchDTO;

interface AdvertisementSearchRepository
{
    public function search(AdvertisementSearchDTO $searchDTO): Collection;
}
