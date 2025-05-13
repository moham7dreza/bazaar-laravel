<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Arr;

final class SettingsManager
{
    public function getActivePaymentGateway(array $gateways)
    {
        return Arr::sole($gateways, static fn ($gateway) => true === $gateway['enabled']);
    }

    public function getPrimaryContact(array $contacts)
    {
        return Arr::sole($contacts, static fn ($contact) => true === $contact['is_primary']);
    }
}
