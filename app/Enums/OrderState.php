<?php

namespace App\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum OrderState: string
{
    use EnumDataListTrait;

    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case SHIPPED = 'shipped';
}
