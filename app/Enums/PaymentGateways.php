<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;
use Filament\Forms\Components\TextInput;
use Filament\Support\Contracts\HasLabel;

enum PaymentGateways: int implements HasLabel
{
    use EnumDataListTrait;

    case ZARRIN_PAL = 1;
    case ASAN_PARDAKHT = 2;
    case BEH_PARDAKHT = 3;

    public function configInputs(): array
    {
        $keys = config('payment-gateways.keys.'.$this->value);

        return array_map(function ($config, $key) {
            $name = "config.$key";
            $label = $config['label'] ?? $key;
            $rules = $config['rules'] ?? [];

            return TextInput::make($name)
                ->label($label)
                ->rules($rules);

        }, $keys, array_keys($keys));
    }

    public function getLabel(): ?string
    {
        return __('payment-gateways.'.$this->value);
    }
}
