<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;

enum AdvertisementType: string
{
    use EnumDataListTrait;

    case CAR = 'car';
}
