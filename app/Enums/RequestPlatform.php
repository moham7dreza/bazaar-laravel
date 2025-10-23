<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum RequestPlatform: string
{
    use EnumDataListTrait;

    case WEB    = 'web';
    case SERVER = 'server';
    case APP    = 'app';
    case PWA    = 'pwa';
}
