<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\MissingSettingsException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Fluent;
use Throwable;

final class SettingsManager
{
    private Fluent $settings;

    public function __construct(array $config)
    {
        $this->settings = new Fluent($config);
    }

    public function getBackupLocations(): array
    {
        return $this->settings->array('backup_locations');
    }

    public function getActivePaymentGateway(array $gateways)
    {
        return Arr::sole($gateways, static fn ($gateway) => true === Arr::get($gateway, 'enabled'));
    }

    public function getPrimaryContact(array $contacts)
    {
        return Arr::sole($contacts, static fn ($contact) => true === Arr::get($contact, 'is_primary'));
    }

    public function findDeprecatedSettings(array $currentSettings, array $supportedSettings): Collection
    {
        return collect($currentSettings)
            ->diffKeys($supportedSettings)
            ->map(fn ($value, $key) => [
                'setting'       => $key,
                'current_value' => $value,
                'deprecated_at' => Date::now(),
            ]);
    }

    /**
     * @throws MissingSettingsException|Throwable
     */
    public function validateEssentialKeys(array $settings): true
    {
        $essential = [
            'app_name'    => null,
            'environment' => null,
            'debug_mode'  => null,
        ];

        $missing = collect($essential)
            ->diffKeys($settings)
            ->keys();

        throw_if($missing->isNotEmpty(), MissingSettingsException::class, 'Essential settings missing: ' .
        $missing->implode(', '));

        return true;
    }

    public function compareEnvironments(array $production, array $staging): array
    {
        $prodOnly    = collect($production)->diffKeys($staging);
        $stagingOnly = collect($staging)->diffKeys($production);

        return [
            'production_only'   => $prodOnly->all(),
            'staging_only'      => $stagingOnly->all(),
            'total_differences' => $prodOnly->count() + $stagingOnly->count(),
        ];
    }
}
