<?php

namespace App\Enums\Advertisement;

use App\Traits\EnumDataListTrait;

enum Sort: string
{
    use EnumDataListTrait;

    case PRICE_ASC = 'price_asc';
    case PRICE_DESC = 'price_desc';
    case NEWEST = 'newest';
}
