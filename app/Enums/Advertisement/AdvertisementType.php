<?php

namespace App\Enums\Advertisement;

use App\Enums\Concerns\EnumDataListTrait;

enum AdvertisementType: string
{
    use EnumDataListTrait;

    case CAR = 'car';
}
