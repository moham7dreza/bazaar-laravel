<?php

namespace App\Enums;

enum ImageUploadMethod: string
{
    case METHOD_SAVE = 'save';
    case METHOD_CREATE_INDEX_AND_SAVE = 'index';
    case METHOD_FIT_AND_SAVE = 'fit';
}
