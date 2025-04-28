<?php

namespace App\Providers;

use App\Console\Commands\System\DataMigrationCommand;
use App\Enums\Language;
use App\Models\User;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Number;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->setupGlobalConfigurations();
        $this->setupGates();
        $this->logSlowQuery();
        $this->loadExtraMigrationsPath();
        $this->setupMacros();
        $this->handleMissingTrans();
        $this->setUpValidators();
    }

    private function setupGlobalConfigurations(): void
    {
        /*
       ResetPassword::createUrlUsing(static function (User $notifiable, string $token) {
           return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
       });
       */

        Model::automaticallyEagerLoadRelationships();
        Number::useCurrency(Language::default()['currency']);
        URL::forceHttps(isEnvProduction());
        DB::prohibitDestructiveCommands(isEnvProduction());
    }

    private function setupGates(): void
    {
        Gate::before(static function (?User $user) {
            return $user?->isAdmin();
        });

        Gate::define('viewPulse', static function (?User $user) {
            return ! isEnvLocalOrTesting() ? $user?->isAdmin() : true;
        });

        Gate::define('viewWebTinker', static function (?User $user) {
            return ! isEnvLocalOrTesting() ? $user?->isAdmin() : true;
        });
    }

    private function logSlowQuery(): void
    {
        DB::whenQueryingForLongerThan(5000, static function (Connection $connection, QueryExecuted $event): void {

            mongo_info('slow-query', [
                'connection' => $event->connection,
                'connectionName' => $event->connectionName,
                'duration' => $event->time,
                'sql' => $event->sql,
                'bindings' => Str::replaceArray('?', $event->bindings, $event->sql),
                'path' => request()?->path(),
                'req' => request()?->all(),
            ]);
        });
    }

    private function loadExtraMigrationsPath(): void
    {
        if (! isEnvTesting()) {
            $this->loadMigrationsFrom(__DIR__.'/../..'.DataMigrationCommand::PATH);
        }
    }

    private function setupMacros(): void
    {
        Carbon::macro('toJalali', function ($format = 'Y-m-d H:i:s') {
            return Jalalian::forge($this)->format($format);
        });
    }

    private function handleMissingTrans(): void
    {
        app('translator')->handleMissingKeysUsing(function ($key, $replacements, $locale): void {
            if (empty($key)) {
                return;
            }

            ondemand_info("Missing translation key: *** ( $key ) ***", file: 'translation');

            // Only update JSON translation files (skip PHP array files)
            if (! str_contains($key, '.')) {
                $this->addMissingKeyToJsonLangFile($key, $locale);
            }
        });
    }

    protected function addMissingKeyToJsonLangFile(string $key, string $locale): void
    {
        $path = lang_path("{$locale}.json");

        // Skip if key contains dots (file-based translations)
        if (str_contains($key, '.')) {
            return;
        }

        try {
            if (! file_exists($path)) {
                file_put_contents($path, '{}');
            }

            $translations = json_decode(file_get_contents($path), true) ?? [];

            if (! array_key_exists($key, $translations)) {
                $translations[$key] = $key;
                file_put_contents(
                    $path,
                    json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
                );
            }
        } catch (\Exception $e) {
            \Log::error("Failed to update translations key '$key' for '$locale.json': ".$e->getMessage());
        }
    }

    private function setUpValidators(): void
    {
        Validator::extend('mobile', static function ($attribute, $value, $parameters, $validator) {

            if (Validator::make(['password' => $value], [
                'password' => 'numeric|digits:11|regex:/^09[0-9]{9}$/',
            ])->fails()) {
                return false;
            }

            return true;
        });
    }
}
