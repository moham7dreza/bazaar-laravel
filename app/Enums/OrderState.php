<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\EnumDataListTrait;

enum OrderState: string
{
    use EnumDataListTrait;

    case Pending    = 'pending';

    case Processing = 'processing';

    case Shipped    = 'shipped';
}
