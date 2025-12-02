<?php

declare(strict_types=1);

namespace Modules\Content\Enums;

use App\Concerns\EnumDataListTrait;

enum MenuPosition: string
{
    use EnumDataListTrait;

    case Header = 'header';
}
