<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum RequestOs: string
{
    use EnumDataListTrait;

    case Web     = 'web';

    case Ios     = 'ios';

    case Android = 'android';

    public static function mobiles(): array
    {
        return [
            self::Android->value,
            self::Ios->value,
        ];
    }
}
