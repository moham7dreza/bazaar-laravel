<?php

namespace App\Enums\Content;

use App\Enums\Concerns\EnumDataListTrait;

enum MenuPosition: string
{
    use EnumDataListTrait;

    case HEADER = 'header';
}
