<?php

declare(strict_types=1);

namespace Tests\Unit\Enums;

use App\Concerns\Enums\EnumTranslatable;

enum TestStatusEnum: string
{
    use EnumTranslatable;

    case DRAFT     = 'draft';
    case PENDING   = 'pending';
    case PUBLISHED = 'published';
}
