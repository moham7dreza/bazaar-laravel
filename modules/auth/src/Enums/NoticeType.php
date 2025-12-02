<?php

declare(strict_types=1);

namespace Modules\Auth\Enums;

use App\Concerns\EnumDataListTrait;

enum NoticeType: int
{
    use EnumDataListTrait;

    case Sms   = 0;

    case Email = 1;
}
