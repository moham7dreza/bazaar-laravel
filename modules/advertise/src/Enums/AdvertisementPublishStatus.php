<?php

declare(strict_types=1);

namespace Modules\Advertise\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum AdvertisementPublishStatus: int
{
    use EnumDataListTrait;

    case Inactive = 0;
    case Active   = 1;
    case Pending  = 2;
}
