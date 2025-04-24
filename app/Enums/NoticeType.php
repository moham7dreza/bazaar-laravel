<?php

namespace App\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum NoticeType: int
{
    use EnumDataListTrait;

    case SMS = 0;
    case EMAIL = 1;
}
