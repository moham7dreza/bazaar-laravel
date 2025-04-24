<?php

namespace App\Enums\Advertisement;

use App\Enums\Concerns\EnumDataListTrait;

enum Unit: string
{
    use EnumDataListTrait;

    case UNKNOWN = 'unknown';
}
