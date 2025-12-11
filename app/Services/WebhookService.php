<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\InvalidWebhookException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class WebhookService
{
    /**
     * @throws InvalidWebhookException
     */
    public function registerWebhook(string $url, array $events): bool
    {
        // Validate webhook URL is secure
        throw_unless(Str::isUrl($url, ['https']), InvalidWebhookException::class, message: 'Webhook URLs must use HTTPS protocol', context: [
            'url'    => $url,
            'events' => $events,
        ]);

        // Additional validation for webhook endpoints
        throw_unless($this->isReachableEndpoint($url), InvalidWebhookException::class, message: 'Webhook endpoint is not reachable', context: [
            'url'    => $url,
            'events' => $events,
        ]);

        return $this->createWebhookSubscription($url, $events);
    }

    public function validateIntegrationUrls(array $integrations): array
    {
        $validated = [];

        foreach ($integrations as $service => $config)
        {
            if (null !== Arr::get($config, 'callback_url') &&
                Str::isUrl(Arr::get($config, 'callback_url'), ['https']))
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
