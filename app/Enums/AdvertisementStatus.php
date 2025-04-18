<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;

enum AdvertisementStatus: string
{
    use EnumDataListTrait;

    case AS_GOOD_AS_NEW = 'as_good_as_new';
}
