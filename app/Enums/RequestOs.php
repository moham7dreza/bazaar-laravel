<?php

namespace App\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum RequestOs: string
{
    use EnumDataListTrait;

    case WEB = 'web';
    case IOS = 'ios';
    case ANDROID = 'android';

    public static function mobiles(): array
    {
        return [
            self::ANDROID->value,
            self::IOS->value,
        ];
    }
}
