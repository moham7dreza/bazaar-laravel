<?php

declare(strict_types=1);

namespace Modules\Advertise\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum Sort: string
{
    use EnumDataListTrait;

    case PRICE_ASC  = 'price_asc';
    case PRICE_DESC = 'price_desc';
    case NEWEST     = 'newest';
    case OLDEST     = 'oldest';
}
