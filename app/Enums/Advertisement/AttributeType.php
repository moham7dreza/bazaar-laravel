<?php

namespace App\Enums\Advertisement;

use App\Traits\EnumDataListTrait;

enum AttributeType: int
{
    use EnumDataListTrait;

    case TEXT = 1;
    case NUMBER = 2;
}
