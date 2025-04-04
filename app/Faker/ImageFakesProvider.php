<?php

namespace App\Faker;

use App\Enums\ImageSize;
use Faker\Provider\Base;

class ImageFakesProvider extends Base
{
    public function imageIndexArray(): array
    {
        return [
            'indexArray' => [
                ImageSize::LARGE->value => $this->generator->imageUrl,
                ImageSize::MEDIUM->value => $this->generator->imageUrl,
                ImageSize::SMALL->value => $this->generator->imageUrl,
            ],
            'directory' => $this->generator->directory,
            'currentImage' => ImageSize::MEDIUM->value,
        ];
    }

    public function directory(): string
    {
        return asset('images/menus/2025/01/01/2322324234');
    }
}
