<?php

declare(strict_types=1);

namespace Modules\Advertise\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum AdvertisementType: string
{
    use EnumDataListTrait;

    case Car = 'car';
}
