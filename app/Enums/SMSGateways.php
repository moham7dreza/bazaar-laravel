<?php

declare(strict_types=1);

namespace App\Enums;

use Illuminate\Support\Arr;
use App\Enums\Concerns\EnumDataListTrait;
use Filament\Forms\Components\TextInput;
use Filament\Support\Contracts\HasLabel;

enum SMSGateways: int implements HasLabel
{
    use EnumDataListTrait;

    case Kavehnegar = 1;
    case SmsIr      = 2;

    public function configInputs(): array
    {
        $keys = config('sms-gateways.keys.' . $this->value);

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
        return __('sms-gateways.' . $this->value);
    }
}
