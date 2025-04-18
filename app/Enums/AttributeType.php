<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;

enum AttributeType: int
{
    use EnumDataListTrait;

    case TEXT = 1;
    case NUMBER = 2;
}
