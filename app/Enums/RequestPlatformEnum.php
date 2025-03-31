<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;

enum RequestPlatformEnum: string
{
    use EnumDataListTrait;

    case WEB = 'web';
    case SERVER = 'server';
    case APP = 'app';
    case PWA = 'pwa';
}
