<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Concerns\EnumDataListTrait;
use Filament\Forms\Components\TextInput;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Arr;

enum PaymentGateways: int implements HasLabel
{
    use EnumDataListTrait;

    case ZarrinPal    = 1;
    case AsanPardakht = 2;
    case BehPardakht  = 3;

    public function configInputs(): array
    {
        $keys = config('payment-gateways.keys.' . $this->value);

        return array_map(function ($config, $key) {
            $name  = "config.{$key}";
            $label = Arr::get($config, 'label', $key);
            $rules = Arr::get($config, 'rules', []);

            return TextInput::make($name)
                ->label($label)
                ->rules($rules);

        }, $keys, array_keys($keys));
    }

    public function getLabel(): ?string
    {
        return __('payment-gateways.' . $this->value);
    }
}
