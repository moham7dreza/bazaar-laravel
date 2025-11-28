<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum RequestPlatform: string
{
    use EnumDataListTrait;

    case Web    = 'web';

    case Server = 'server';

    case App    = 'app';

    case Pwa    = 'pwa';
}
