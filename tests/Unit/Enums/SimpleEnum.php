<?php

declare(strict_types=1);

namespace Tests\Unit\Enums;

use App\Concerns\Enums\EnumArrayable;

enum SimpleEnum: string
{
    use EnumArrayable;

    case FIRST  = 'first';
    case SECOND = 'second';
    case THIRD  = 'third';
}
