<?php

declare(strict_types=1);

namespace App\Providers;

use App\Broadcasting\WhatsappChannel;
use App\Console\Commands\System\DataMigrationCommand;
use App\Enums\Language;
use App\Models\Holiday;
use App\Models\User;
use App\Pipelines\Image\ImageThumbnailResizePipeline;
use App\Pipelines\Pipelines;
use App\Rules\ValidateImageRule;
use App\Rules\ValidateNationalCodeRule;
use App\Services\TranslationService;
use Carbon\CarbonImmutable;
use Filament\Notifications\Auth\VerifyEmail;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Pipeline\Hub;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Number;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Uri;
use Illuminate\Validation\InvokableValidationRule;
use Illuminate\Validation\Rules\Password;
use Morilog\Jalali\Jalalian;

final class AppServiceProvider extends ServiceProvider
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
        $this->configureCarbon();
        $this->handleMissingTrans();
        $this->configureValidator();
        $this->configureDate();
        $this->configurePassword();
        $this->configurePipelines();
        $this->configureNotification();
        $this->configureSchedule();
        $this->configureUri();
    }

    private function configureCommands(): void
    {
        DB::prohibitDestructiveCommands(isEnvProduction());
    }

    private function configureModels(): void
    {
        Model::automaticallyEagerLoadRelationships();
        Model::shouldBeStrict( ! isEnvProduction());
        Model::unguard();
    }

    private function configureUrl(): void
    {
        URL::forceHttps(isEnvProduction());
    }

    private function configureHttp(): void
    {
        Http::globalOptions([
            'timeout'         => 5,
            'connect_timeout' => 2,
            'headers'         => [
                'User-Agent' => 'ShoppingPortal/2.1',
                'Accept'     => 'application/json',
            ],
            'retry'       => 2,
            'retry_delay' => 150,
        ]);

        Http::macro('openai', static function () {
            $apiKey = config()?->string('');

            return Http::withHeaders([
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' . $apiKey,
            ])
                ->baseUrl('https://api.openai.com/v1/chat');
        });
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
        Gate::before(static fn (?User $user) => $user?->isAdmin());

        Gate::define('viewWebTinker', static fn (?User $user) => ! isEnvLocalOrTesting() ? $user?->isAdmin() : true);
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
        if ( ! isEnvTesting())
        {
            $this->loadMigrationsFrom(__DIR__ . '/../..' . DataMigrationCommand::PATH);
        }
    }

    private function configureCarbon(): void
    {
        Carbon::macro('jdate', fn (): ?Jalalian => jalali_date($this));
    }

    private function handleMissingTrans(): void
    {
        app('translator')->handleMissingKeysUsing(function (string $key, array $replacements, ?string $locale): void {
            if (empty($key))
            {
                return;
            }

            ondemand_info("Missing translation key: *** ( {$key} ) ***", file: 'translation');

            // Only update JSON translation files (skip PHP array files)
            if ( ! str_contains($key, '.'))
            {
                app(TranslationService::class)->addMissingKeyToJsonLangFile($key, $locale);
            }
        });
    }

    private function configureValidator(): void
    {
        Validator::extend('mobile', static fn (string $attribute, mixed $value, array $parameters, Validator $validator) => ! ($validator->make(['password' => $value], [
            'password' => 'numeric|digits:11|regex:/^09[0-9]{9}$/',
        ])->fails()));

        Validator::extend('national_code', static fn (string $attribute, mixed $value, array $parameters, \Illuminate\Contracts\Validation\Validator $validator) => InvokableValidationRule::make(new ValidateNationalCodeRule())
            ->setValidator($validator)
            ->passes($attribute, $value));

        Validator::extend('picture', static fn (string $attribute, mixed $value, array $parameters, \Illuminate\Contracts\Validation\Validator $validator) => InvokableValidationRule::make(new ValidateImageRule())
            ->setValidator($validator)
            ->passes($attribute, $value));
    }

    private function configureDate(): void
    {
        Date::use(CarbonImmutable::class);
        Date::macro('isHoliday', fn () => Holiday::query()->where('date', $this)->exists()); // today()->isHoliday()
    }

    private function configurePassword(): void
    {
        Password::defaults(static fn () => Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers());
    }

    private function configurePipelines(): void
    {
        $this->app
            ->get(Hub::class)
            ->pipeline(Pipelines::PROCESS_UPLOADED_IMAGE, fn (Pipeline $pipeline, UploadedFile $image) => $pipeline
                ->send($image)
                ->through([
                    ImageThumbnailResizePipeline::class,
                ])
                ->thenReturn());
    }

    private function configureNotification(): void
    {
        Notification::extend('whatsapp', static fn ($app) => $app->make(WhatsappChannel::class));
    }

    private function configureSchedule(): void
    {
        Event::macro('exceptOnHolidays', static fn () => $this->skip(today()->isHoliday()));
    }

    private function configureUri(): void
    {
        Uri::macro('docs', fn () => $this->withPath('docs'));
        Uri::macro('inCategory', fn ($category) => $this->withPath('shop/' . $category . '/' . trim($this->path(), '/')));
        Uri::macro('mobile', function () {
            $path = trim($this->path(), '/');

            return $this->withHost('m.' . $this->host())
                ->withPath($path);
        });
        Uri::macro('tracking', fn ($campaign) => $this->withQuery(['utm_campaign' => $campaign, 'utm_source' => 'website']));
    }

    private function configureManager(): void
    {
        $this->app->singleton(Manager::class, function (Application $application): Manager {

            $config = $application['config']->get('services.manager');

            $rules = [
                'redirect'      => ['required', 'url'],
                'config_id'     => ['required', 'string'],
                'client_id'     => ['required', 'string'],
                'client_secret' => ['required', 'string'],
            ];

            Validator::make($config, $rules)
                ->setException(ManagerConfigException::class)
                ->validate();

            return new Manager($config);
        });
    }

    private function configureVerifyEmail(): void
    {
        // custom email verification template
        VerifyEmail::toMailUsing(static fn (User $user, string $url) => (new MailMessage())
            ->subject('Verify Email Address')
            ->view('mail.email-verification', [ // TODO add template for it
                'title'       => 'Confirm your email address',
                'previewText' => 'Please confirm your email address',
                'user'        => $user,
                'url'         => $url,
            ]));
    }
}
