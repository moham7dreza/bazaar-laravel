<?php

declare(strict_types=1);

namespace Modules\Payment\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum PaymentStatus: int
{
    use EnumDataListTrait;

    case Pending = 1;
    case Paid    = 2;
    case Failed  = 3;
}
