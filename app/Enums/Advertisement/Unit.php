<?php

namespace App\Enums\Advertisement;

use App\Traits\EnumDataListTrait;

enum Unit: string
{
    use EnumDataListTrait;

    case UNKNOWN = 'unknown';
}
