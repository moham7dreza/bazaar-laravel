<?php

namespace App\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum UserPermission: string
{
    use EnumDataListTrait;

    case SEE_PANEL = 'see panel';
}
