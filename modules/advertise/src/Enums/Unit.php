<?php

declare(strict_types=1);

namespace Modules\Advertise\Enums;

use App\Concerns\EnumDataListTrait;

enum Unit: string
{
    use EnumDataListTrait;

    case Unknown = 'unknown';
}
