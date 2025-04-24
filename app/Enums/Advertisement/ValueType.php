<?php

namespace App\Enums\Advertisement;

use App\Enums\Concerns\EnumDataListTrait;

enum ValueType: int
{
    use EnumDataListTrait;

    case TEXT = 1;
    case NUMBER = 2;
}
