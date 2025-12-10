<?php

declare(strict_types=1);

namespace Tests\Unit\Enums;

use App\Concerns\Enums\EnumTranslatable;

enum TestStatusEnum: string
{
    use EnumTranslatable;

    case Draft     = 'draft';
    case Pending   = 'pending';
    case Published = 'published';
}
