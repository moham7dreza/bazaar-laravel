<?php

declare(strict_types=1);

namespace Modules\Advertise\Enums;

use App\Concerns\EnumDataListTrait;

enum AttributeType: int
{
    use EnumDataListTrait;

    case Text   = 1;

    case Number = 2;
}
