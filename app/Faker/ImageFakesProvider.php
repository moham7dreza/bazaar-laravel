<?php

namespace App\Faker;

use App\Enums\ImageSize;
use Faker\Provider\Base;

class ImageFakesProvider extends Base
{
    /**
     * Generate index array with custom format.
     */
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

    /**
     * Generate image directory
     */
    public function directory(): string
    {
        return asset('images/menus/2025/01/01/2322324234');
    }
}
