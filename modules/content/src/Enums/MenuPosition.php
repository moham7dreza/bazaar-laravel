<?php

declare(strict_types=1);

namespace Modules\Content\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum MenuPosition: string
{
    use EnumDataListTrait;

    case HEADER = 'header';
}
