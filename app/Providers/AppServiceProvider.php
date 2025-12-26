<?php

declare(strict_types=1);

namespace App\Providers;

use App\Concerns\HasCustomApplicationConfig;
use Illuminate\Support\ServiceProvider;
use Override;

final class AppServiceProvider extends ServiceProvider
{
    use HasCustomApplicationConfig;

    #[Override]
    public function register(): void
    {
        $this->bindSearchClient();
    }

    public function boot(): void
    {
        $this->configureCommands();
        $this->configureModel();
        $this->configureUrl();
        $this->configureVite();
        $this->configureHttp();
        $this->configureNumber();
        $this->configureGates();
        $this->logSlowQuery();
        $this->loadExtraMigrationsPath();
        // $this->handleMissingTrans();
        $this->configureValidator();
        $this->configureDate();
        $this->configurePassword();
        $this->configurePipelines();
        $this->configureNotification();
        $this->configureSchedule();
        $this->configureUri();
        $this->configureEmail();
        // $this->configureVerifyEmail();
        $this->configureStringable();
        $this->configureStr();
        $this->configureSupportCollection();
        $this->configureEloquentBuilder();
        $this->configureQueryBuilder();
        $this->configureRoutingRoute();
        $this->configureBlueprint();
        $this->configureHttpClientResponse();
        $this->configureMail();
        $this->configureRateLimiter();
        $this->configureCommandsToRunOnReload();
        $this->configureMetrics();
        $this->configureScramble();
        $this->configureResetPassword();
        // $this->configureQueue();
        // $this->configureRoute();
        $this->validateEnvironmentVariables();
        $this->configureEloquentRelation();
    }
}
