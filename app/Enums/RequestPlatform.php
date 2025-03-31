<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;

enum RequestPlatform: string
{
    use EnumDataListTrait;

    case WEB = 'web';
    case SERVER = 'server';
    case APP = 'app';
    case PWA = 'pwa';
}
