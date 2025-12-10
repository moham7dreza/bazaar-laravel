<?php

declare(strict_types=1);

namespace App\Enums\Image;

enum ImageUploadMethod: string
{
    case MethodSave                  = 'save';

    case MethodCreateIndexAndSave    = 'index';

    case MethodFitAndSave            = 'fit';
}
