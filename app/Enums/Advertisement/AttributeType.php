<?php

namespace App\Enums\Advertisement;

use App\Enums\Concerns\EnumDataListTrait;

enum AttributeType: int
{
    use EnumDataListTrait;

    case TEXT = 1;
    case NUMBER = 2;
}
