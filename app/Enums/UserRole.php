<?php

namespace App\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum UserRole: string
{
    use EnumDataListTrait;

    case ADMIN  = 'admin';
    case WRITER = 'writer';
    case EDITOR = 'editor';
}
