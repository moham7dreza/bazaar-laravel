<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;

enum RequestHeader: string
{
    use EnumDataListTrait;

    case PLATFORM = 'Platform';
    case ORIGIN = 'origin';
}
