<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\FeatureAccessException;

final class FeatureFlagService
{
    public function syncFeatureFlags(array $serverFlags, array $clientFlags): array
    {
        $serverOnly = collect($serverFlags)->diffKeys($clientFlags);
        $clientOnly = collect($clientFlags)->diffKeys($serverFlags);

        return [
            'flags_to_add'    => $serverOnly->all(),
            'flags_to_remove' => $clientOnly->keys()->all(),
            'sync_required'   => $serverOnly->isNotEmpty() || $clientOnly->isNotEmpty(),
        ];
    }

    /**
     * @throws FeatureAccessException
     */
    public function validateFeatureAccess(array $userFlags, array $requiredFeatures): true
    {
        $unavailable = collect($requiredFeatures)
            ->diffKeys($userFlags)
            ->keys();

        if ($unavailable->isNotEmpty())
        {
            throw new FeatureAccessException(
                'Access denied to features: ' . $unavailable->implode(', ')
            );
        }

        return true;
    }
}
