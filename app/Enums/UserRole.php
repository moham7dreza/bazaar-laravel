<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum UserRole: string
{
    use EnumDataListTrait;

    case Admin  = 'admin';
    case Writer = 'writer';
    case Editor = 'editor';
}
