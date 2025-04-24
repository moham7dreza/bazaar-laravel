<?php

namespace App\Enums\Advertisement;

use App\Traits\EnumDataListTrait;

enum AdvertisementType: string
{
    use EnumDataListTrait;

    case CAR = 'car';
}
