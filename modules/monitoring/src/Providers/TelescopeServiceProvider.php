<?php

declare(strict_types=1);

namespace Modules\Monitoring\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

final class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Telescope::night();

        $this->hideSensitiveRequestDetails();

        Telescope::filter(fn (IncomingEntry $entry) => isEnvLocal() ||
                   $entry->isReportableException()                  ||
                   $entry->isFailedRequest()                        ||
                   $entry->isFailedJob()                            ||
                   $entry->isScheduledTask()                        ||
                   $entry->hasMonitoredTag());
    }

    /**
     * Register the Telescope gate.
     *
     * This gate determines who can access Telescope in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define('viewTelescope', static fn (?User $user) => ! isEnvLocalOrTesting() ? $user?->isAdmin() : true);
    }

    /**
     * Prevent sensitive request details from being logged by Telescope.
     */
    private function hideSensitiveRequestDetails(): void
    {
        if (isEnvLocal())
        {
            return;
        }

        Telescope::hideRequestParameters(['_token']);

        Telescope::hideRequestHeaders([
            'cookie',
            'x-csrf-token',
            'x-xsrf-token',
        ]);
    }
}
