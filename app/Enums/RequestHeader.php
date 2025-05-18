<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum RequestHeader: string
{
    use EnumDataListTrait;

    case PLATFORM      = 'Platform';
    case ORIGIN        = 'origin';
    case DISABLE_CACHE = 'x-disable-cache';
}
