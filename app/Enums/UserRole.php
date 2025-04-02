<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;

enum UserRole: string
{
    use EnumDataListTrait;

    case ADMIN = 'admin';
}
