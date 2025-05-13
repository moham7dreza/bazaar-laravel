<?php

declare(strict_types=1);

namespace Modules\Monitoring\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\Monitoring\Commands\CheckVulnerabilitiesCommand;

final class MonitoringServiceProvider extends ServiceProvider
{
    private const array COMMANDS = [
        CheckVulnerabilitiesCommand::class,
    ];

    public function register(): void
    {
        $this->commands(self::COMMANDS);
    }

    public function boot(): void
    {
        $this->configureGates();
    }

    private function configureGates(): void
    {
        Gate::define('viewPulse', static fn (?User $user) => ! isEnvLocalOrTesting() ? $user?->isAdmin() : true);
    }
}
