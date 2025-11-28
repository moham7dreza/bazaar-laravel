<?php

declare(strict_types=1);

namespace Modules\Advertise\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum ValueType: int
{
    use EnumDataListTrait;

    case Text   = 1;

    case Number = 2;
}
