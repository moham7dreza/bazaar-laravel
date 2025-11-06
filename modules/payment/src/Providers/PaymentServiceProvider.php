<?php

declare(strict_types=1);

namespace Modules\Payment\Providers;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\ServiceProvider;
use Modules\Payment\Database\Seeders\PaymentSeeder;

class PaymentServiceProvider extends ServiceProvider
{
    private const array COMMANDS = [];

    public function register(): void
    {
        $this->commands(self::COMMANDS);

        $this->setupSeeders();
    }

    public function boot(): void
    {
    }

    private function setupSeeders(): void
    {
        DatabaseSeeder::$seeders[] = PaymentSeeder::class;
    }
}
