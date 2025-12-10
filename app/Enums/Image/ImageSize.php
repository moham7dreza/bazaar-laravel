<?php

declare(strict_types=1);

namespace App\Enums\Image;

enum ImageSize: string
{
    case Small  = 'small';

    case Medium = 'medium';

    case Large  = 'large';
}
