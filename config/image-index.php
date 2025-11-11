<?php

declare(strict_types=1);

use App\Enums\Image\ImageSize;

return [

    'index-image-sizes' => [
        ImageSize::Large->value => [
            'width'  => 800,
            'height' => 600,
        ],
        ImageSize::Medium->value => [
            'width'  => 350,
            'height' => 350,
        ],
        ImageSize::Small->value => [
            'width'  => 80,
            'height' => 80,
        ],
    ],
    'default-current-index-image' => ImageSize::Medium->value,

    'default-parent-upload-directory' => 'images',
];
