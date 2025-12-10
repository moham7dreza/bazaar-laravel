<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\EnumDataListTrait;

enum Status: int
{
    use EnumDataListTrait;

    case Activated   = 1;

    case Disabled    = 0;
}
