<?php

namespace App\Exceptions;

use App\Enums\Content\ImageUploadMethod;
use Exception;

class ImageUplodeMethodNotFoundException extends Exception
{
    public function __construct(ImageUploadMethod $method)
    {
        parent::__construct(__("No ImageUploadMethod is registered for method: {$method->value}"));
    }
}
