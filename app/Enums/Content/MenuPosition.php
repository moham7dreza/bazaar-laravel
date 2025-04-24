<?php

namespace App\Enums\Content;

use App\Traits\EnumDataListTrait;

enum MenuPosition: string
{
    use EnumDataListTrait;

    case HEADER = 'header';
}
