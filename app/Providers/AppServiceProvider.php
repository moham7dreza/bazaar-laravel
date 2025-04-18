<?php

namespace App\Providers;

use App\Console\Commands\DataMigrationCommand;
use App\Http\Services\Date\TimeUtility;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        Model::automaticallyEagerLoadRelationships();

        $this->setupGates();
        $this->logSlowQuery();
        $this->loadExtraMigrationsPath();
        $this->setupMacros();
    }

    private function setupGates(): void
    {
        Gate::before(static function (?User $user) {
            return $user?->isAdmin();
        });

        Gate::define('viewPulse', static function (?User $user) {
            return ! isEnvLocalOrTesting() ? $user?->isAdmin() : true;
        });
    }

    private function logSlowQuery(): void
    {
        DB::whenQueryingForLongerThan(5000, static function (Connection $connection, QueryExecuted $event) {

            mongo_info('slow-query', [
                'connection' => $event->connection,
                'connectionName' => $event->connectionName,
                'duration' => $event->time,
                'sql' => $event->sql,
                'bindings' => str_replace_array('?', $event->bindings, $event->sql),
                'path' => request()?->path(),
                'req' => request()?->all(),
            ]);
        });
    }

    private function loadExtraMigrationsPath(): void
    {
        if (!isEnvTesting()) {
            $this->loadMigrationsFrom(__DIR__ . "/../.." . DataMigrationCommand::PATH);
        }
    }

    private function setupMacros(): void
    {
        Carbon::macro('toJalali', function ($format = 'Y-m-d') {
            return TimeUtility::dateTimeToJalaliFormat($this, $format);
        });
    }
}
