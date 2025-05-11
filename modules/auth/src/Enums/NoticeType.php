<?php

declare(strict_types=1);

namespace Modules\Auth\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum NoticeType: int
{
    use EnumDataListTrait;

    case SMS   = 0;
    case EMAIL = 1;
}
