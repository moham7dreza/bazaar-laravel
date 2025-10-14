<?php

declare(strict_types=1);

namespace Modules\Advertise\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum AdvertisementStatus: string
{
    use EnumDataListTrait;

    case AS_GOOD_AS_NEW = 'as_good_as_new';
    case USED           = 'used';
}
