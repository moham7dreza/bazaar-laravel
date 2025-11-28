<?php

declare(strict_types=1);

namespace Modules\Advertise\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum AdvertisementStatus: string
{
    use EnumDataListTrait;

    case AsGoodAsNew    = 'as_good_as_new';

    case Used           = 'used';
}
