<?php

declare(strict_types=1);

namespace Modules\Monitoring\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Nightwatch\Facades\Nightwatch;
use Laravel\Pulse\Facades\Pulse;
use Modules\Monitoring\Commands;
use Override;

final class MonitoringServiceProvider extends ServiceProvider
{
    private const array COMMANDS = [
        Commands\CheckVulnerabilitiesCommand::class,
        Commands\MonitorCommands::class,
    ];

    #[Override]
    public function register(): void
    {
        $this->commands(self::COMMANDS);
    }

    public function boot(): void
    {
        $this->configureGates();
        $this->configurePulse();
        $this->configureNightwatch();
    }

    private function configureGates(): void
    {
        Gate::define('viewPulse', static fn (?User $user) => ! isEnvLocalOrTesting() ? $user?->isAdmin() : true);
    }

    private function configurePulse(): void
    {
        Pulse::user(fn (User $user) => [
            'name'   => $user->name,
            'extra'  => $user->email,
            'avatar' => $user->avatar_url,
        ]);
    }

    private function configureNightwatch(): void
    {
        Nightwatch::user(fn (User $user) => [
            'name'     => $user->name,
            'username' => $user->email,
        ]);
    }
}
