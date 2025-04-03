<?php

use App\Enums\ImageSize;

return [

    'index-image-sizes' => [
        ImageSize::LARGE->value => [
            'width' => 800,
            'height' => 600,
        ],
        ImageSize::MEDIUM->value => [
            'width' => 350,
            'height' => 350,
        ],
        ImageSize::SMALL->value => [
            'width' => 80,
            'height' => 80,
        ],
    ],
    'default-current-index-image' => ImageSize::MEDIUM->value,

    'default-parent-upload-directory' => 'images',
];
