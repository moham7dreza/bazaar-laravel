<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\EnumDataListTrait;

enum RequestHeader: string
{
    use EnumDataListTrait;

    case Platform       = 'platform';

    case Origin         = 'origin';

    case Referer        = 'referer';

    case Os             = 'os';

    case DisableCache   = 'x-disable-cache';

    case IdempotencyKey    = 'Idempotency-Key';

    case IdempotencyStatus = 'Idempotency-Status';
}
