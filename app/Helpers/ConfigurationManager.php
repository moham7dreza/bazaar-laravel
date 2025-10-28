<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

final readonly class ConfigurationManager
{
    public function processSettings($settings)
    {
        $array = Arr::from($settings);

        return $this->validateSettings($array);
    }

    public function combineConfigurations(...$configs)
    {
        return collect($configs)
            ->map(fn ($config) => Arr::from($config))
            ->reduce(fn ($carry, $item) => array_merge($carry, $item), []);
    }

    public function sanitizeAndStore($configuration, array $schema)
    {
        $data = Arr::from($configuration);

        $validator = Validator::make($data, $schema);

        throw_if($validator->fails(), ValidationException::class, $validator);

        return $data;
    }

    private function validateSettings(array $settings)
    {
        return true;
    }
}
