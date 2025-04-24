<?php

namespace App\Enums\Advertisement;

use App\Traits\EnumDataListTrait;

enum ValueType: int
{
    use EnumDataListTrait;

    case TEXT = 1;
    case NUMBER = 2;
}
