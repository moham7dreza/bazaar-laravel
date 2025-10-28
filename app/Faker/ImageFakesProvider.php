<?php

declare(strict_types=1);

namespace App\Faker;

use App\Enums\Image\ImageSize;
use Faker\Provider\Base;

final class ImageFakesProvider extends Base
{
    /**
     * Generate index array with custom format.
     */
    public function imageIndexArray(): array
    {
        return [
            'indexArray' => [
                ImageSize::LARGE->value  => 'images/admin.jpg',
                ImageSize::MEDIUM->value => 'images/admin.jpg',
                ImageSize::SMALL->value  => 'images/admin.jpg',
            ],
            'directory'    => $this->generator->directory(),
            'currentImage' => ImageSize::MEDIUM->value,
        ];
    }

    /**
     * Generate image directory.
     */
    public function directory(): string
    {
        return asset('images/menus/2025/01/01/2322324234');
    }
}
