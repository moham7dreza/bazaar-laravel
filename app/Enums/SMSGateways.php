<?php

namespace App\Enums;

use App\Enums\Concerns\EnumDataListTrait;
use Filament\Forms\Components\TextInput;
use Filament\Support\Contracts\HasLabel;


enum SMSGateways:int implements HasLabel
{
    use EnumDataListTrait;

    case KAVEHNEGAR = 1;
    case SMS_IR = 2;

    public function configInputs(): array
    {
        $keys = config('sms-gateways.keys.'.$this->value);

        return array_map(function ($config, $key ){
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
        return __("sms-gateways.".$this->value);
    }
}
