<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;

enum ValueType: int
{
    use EnumDataListTrait;

    case TEXT = 1;
    case NUMBER = 2;
}
