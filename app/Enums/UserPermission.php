<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;

enum UserPermission: string
{
    use EnumDataListTrait;

    case SEE_PANEL = 'see panel';
}
