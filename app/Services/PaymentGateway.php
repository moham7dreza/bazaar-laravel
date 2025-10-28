<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Arr;
use InvalidArgumentException;
use RuntimeException;

final class PaymentGateway
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function processPayment(float $amount): bool
    {
        // Before: verbose type checking
        if ( ! isset($this->config['api_key']) || ! is_string($this->config['api_key']))
        {
            throw new RuntimeException('API key is required and must be a string');
        }

        if (isset($this->config['debug']) && ! is_bool($this->config['debug']))
        {
            throw new RuntimeException('Debug flag must be a boolean value');
        }

        if (isset($this->config['allowed_currencies']) && ! is_array($this->config['allowed_currencies']))
        {
            throw new RuntimeException('Allowed currencies must be an array');
        }

        // Process payment...

        // After: concise, expressive type checking
        try
        {
            $apiKey            = Arr::string($this->config, 'api_key');
            $debug             = Arr::boolean($this->config, 'debug', false);
            $allowedCurrencies = Arr::array($this->config, 'allowed_currencies', []);

            // Process payment...

        } catch (InvalidArgumentException $e)
        {
            throw new RuntimeException('Invalid payment configuration: ' . $e->getMessage());
        }

        return true;
    }
}
