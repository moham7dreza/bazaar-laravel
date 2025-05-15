<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum RequestHeader: string
{
    use EnumDataListTrait;

    case PLATFORM = 'Platform';
    case ORIGIN   = 'origin';

    case IDEMPOTENCY_KEY    = 'Idempotency-Key';
    case IDEMPOTENCY_STATUS = 'Idempotency-Status';
}
