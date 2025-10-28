<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\InvalidWebhookException;
use Illuminate\Support\Str;

class WebhookService
{
    /**
     * @throws InvalidWebhookException
     */
    public function registerWebhook(string $url, array $events): bool
    {
        // Validate webhook URL is secure
        if ( ! Str::isUrl($url, ['https']))
        {
            throw new InvalidWebhookException('Webhook URLs must use HTTPS protocol');
        }

        // Additional validation for webhook endpoints
        if ( ! $this->isReachableEndpoint($url))
        {
            throw new InvalidWebhookException('Webhook endpoint is not reachable');
        }

        return $this->createWebhookSubscription($url, $events);
    }

    public function validateIntegrationUrls(array $integrations): array
    {
        $validated = [];

        foreach ($integrations as $service => $config)
        {
            if (isset($config['callback_url']) &&
                Str::isUrl($config['callback_url'], ['https']))
            {
                $validated[$service] = $config;
            }
        }

        return $validated;
    }

    private function isReachableEndpoint(string $url): true
    {
        return true;
    }

    private function createWebhookSubscription(string $url, array $events): bool
    {
        return true;
    }
}
