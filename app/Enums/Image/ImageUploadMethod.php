<?php

declare(strict_types=1);

namespace App\Enums\Image;

enum ImageUploadMethod: string
{
    case METHOD_SAVE                  = 'save';
    case METHOD_CREATE_INDEX_AND_SAVE = 'index';
    case METHOD_FIT_AND_SAVE          = 'fit';
}
