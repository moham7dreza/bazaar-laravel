<?php

namespace App\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum RequestHeader: string
{
    use EnumDataListTrait;

    case PLATFORM = 'Platform';
    case ORIGIN = 'origin';
}
