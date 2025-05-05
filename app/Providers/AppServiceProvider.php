<?php

namespace App\Providers;

use App\Console\Commands\System\DataMigrationCommand;
use App\Enums\Language;
use App\Http\Services\TranslationService;
use App\Models\User;
use App\Rules\ValidateImageRule;
use App\Rules\ValidateNationalCodeRule;
use Carbon\CarbonImmutable;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Number;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Validation\InvokableValidationRule;
use Illuminate\Validation\Rules\Password;
use Morilog\Jalali\Jalalian;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->configureCommands();
        $this->configureModels();
        $this->configureUrl();
        $this->configureVite();
        $this->configureHttp();
        $this->configureCurrency();
        $this->configureGates();
        $this->logSlowQuery();
        $this->loadExtraMigrationsPath();
        $this->setupMacros();
        $this->handleMissingTrans();
        $this->setUpValidators();
        $this->configureDate();
        $this->configurePassword();
    }

    private function configureCommands(): void
    {
        DB::prohibitDestructiveCommands(isEnvProduction());
    }

    private function configureModels(): void
    {
        Model::automaticallyEagerLoadRelationships();
        Model::shouldBeStrict(! isEnvProduction());
        Model::unguard();
    }

    private function configureUrl(): void
    {
        URL::forceHttps(isEnvProduction());
    }

    private function configureHttp(): void
    {
        Http::globalOptions([
            // Set reasonable timeouts
            'timeout'         => 8,
            'connect_timeout' => 3,

            // Add default headers
            'headers' => [
                'User-Agent' => 'ShoppingPortal/2.1',
                'Accept'     => 'application/json',
            ],

            // Configure default retry behavior
            'retry'       => 2,
            'retry_delay' => 150,
        ]);
    }

    private function configureVite(): void
    {
        Vite::useAggressivePrefetching();
    }

    private function configureCurrency(): void
    {
        Number::useCurrency(Language::default()['currency']);
    }

    private function configureGates(): void
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
                'connection'     => $event->connection,
                'connectionName' => $event->connectionName,
                'duration'       => $event->time,
                'sql'            => $event->sql,
                'bindings'       => Str::replaceArray('?', $event->bindings, $event->sql),
                'path'           => request()?->path(),
                'req'            => request()?->all(),
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
        Carbon::macro('toJalali', function (string $format = 'Y-m-d H:i:s') {
            return Jalalian::forge($this)->format($format);
        });
    }

    private function handleMissingTrans(): void
    {
        app('translator')->handleMissingKeysUsing(function (string $key, array $replacements, ?string $locale): void {
            if (empty($key)) {
                return;
            }

            ondemand_info("Missing translation key: *** ( $key ) ***", file: 'translation');

            // Only update JSON translation files (skip PHP array files)
            if (! str_contains($key, '.')) {
                app(TranslationService::class)->addMissingKeyToJsonLangFile($key, $locale);
            }
        });
    }

    private function setUpValidators(): void
    {
        Validator::extend('mobile', static function (string $attribute, mixed $value, array $parameters, Validator $validator) {

            if ($validator->make(['password' => $value], [
                'password' => 'numeric|digits:11|regex:/^09[0-9]{9}$/',
            ])->fails()) {
                return false;
            }

            return true;
        });

        Validator::extend('national_code', static function (string $attribute, mixed $value, array $parameters, \Illuminate\Contracts\Validation\Validator $validator) {
            return InvokableValidationRule::make(new ValidateNationalCodeRule())
                ->setValidator($validator)
                ->passes($attribute, $value);
        });

        Validator::extend('picture', static function (string $attribute, mixed $value, array $parameters, \Illuminate\Contracts\Validation\Validator $validator) {
            return InvokableValidationRule::make(new ValidateImageRule())
                ->setValidator($validator)
                ->passes($attribute, $value);
        });
    }

    private function configureDate(): void
    {
        Date::use(CarbonImmutable::class);
    }

    private function configurePassword(): void
    {
        Password::defaults(static function () {
            return Password::min(10)
                ->letters()
                ->mixedCase()
                ->numbers();
        });
    }
}
