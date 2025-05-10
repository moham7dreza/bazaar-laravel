<?php

declare(strict_types=1);

namespace Modules\Advertise\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum ValueType: int
{
    use EnumDataListTrait;

    case TEXT   = 1;
    case NUMBER = 2;
}
