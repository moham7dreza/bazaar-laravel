<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum RequestHeader: string
{
    use EnumDataListTrait;

    case PLATFORM       = 'platform';
    case ORIGIN         = 'origin';
    case REFERER        = 'referer';
    case OS             = 'os';
    case DISABLE_CACHE  = 'x-disable-cache';

    case IDEMPOTENCY_KEY    = 'Idempotency-Key';
    case IDEMPOTENCY_STATUS = 'Idempotency-Status';
}
