<?php

declare(strict_types=1);

namespace Modules\Advertise\Enums;

use App\Concerns\EnumDataListTrait;

enum Sort: string
{
    use EnumDataListTrait;

    case PriceAsc   = 'price_asc';

    case PriceDesc  = 'price_desc';

    case Newest     = 'newest';

    case Oldest     = 'oldest';
}
