<?php

declare(strict_types=1);

namespace App\Providers;

use App\Broadcasting\WhatsappChannel;
use App\Console\Commands\System\DataMigrationCommand;
use App\Enums\ClientLocale;
use App\Enums\Status;
use App\Exceptions\ManagerConfigException;
use App\Helpers\JalalianFactory;
use App\Http\Filters\FiltersList;
use App\Http\Filters\Image\ImageThumbnailResizeFilter;
use App\Http\Routing\IgnoreBindingValidator;
use App\Models\Holiday;
use App\Models\User;
use App\Rules\ValidateImageRule;
use App\Rules\ValidateNationalCodeRule;
use App\Services\Manager;
use App\Services\TranslationService;
use Carbon\CarbonImmutable;
use Filament\Notifications\Auth\VerifyEmail;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Client\Response as HttpClientResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Pipeline\Hub;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Number;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Illuminate\Support\Uri;
use Illuminate\Validation\InvokableValidationRule;
use Illuminate\Validation\Rules\Email;
use Illuminate\Validation\Rules\Password;
use Monolog\Formatter\JsonFormatter;
use Morilog\Jalali\Jalalian;
use Throwable;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
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
//        $this->handleMissingTrans();
        $this->configureValidator();
        $this->configureDate();
        $this->configurePassword();
        $this->configurePipelines();
        $this->configureNotification();
        $this->configureSchedule();
        $this->configureUri();
        $this->configureEmail();
        //        $this->configureVerifyEmail();
        $this->configureStringable();
        $this->configureCollection();
        $this->configureEloquentBuilder();
        $this->configureQueryBuilder();
        $this->configureRoute();
        $this->configureBlueprint();
        $this->configureHttpClientResponse();
    }

    private function configureEmail(): void
    {
        Email::macro('contractor', static fn () => Email::default()
            ->strict()
            ->validateMxRecord()
            ->rules('ends_with:@contractors.org,@freelance.net'));

        Email::macro('customer', static fn () => Email::default()
            ->strict()
            ->rules('not_ends_with:@spam-domains.com'));

        Email::macro('partner', static fn () => Email::default()
            ->validateMxRecord()
            ->preventSpoofing()
            ->rules('ends_with:@trusted-partners.biz'));
    }

    private function configureCommands(): void
    {
        DB::prohibitDestructiveCommands(isEnvProduction());
    }

    private function configureModel(): void
    {
        Model::automaticallyEagerLoadRelationships();

        Model::shouldBeStrict( ! isEnvProduction());

        Model::unguard();
    }

    private function configureUrl(): void
    {
        URL::forceHttps(isEnvProduction());
//        URL::useOrigin('');
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

    private function configureNumber(): void
    {
        Number::useCurrency(
            Arr::get(ClientLocale::default(), 'currency')
        );
    }

    private function configureGates(): void
    {
        Gate::before(static fn (?User $user) => $user?->isAdmin());
    }

    private function logSlowQuery(): void
    {
        DB::enableQueryLog();

        DB::whenQueryingForLongerThan(5000, static function (Connection $connection, QueryExecuted $event): void {

            mongo_info('slow-query', [
                'connection'     => $event->connection,
                'connectionName' => $event->connectionName,
                'duration'       => $event->time,
                'sql'            => $event->sql,
                'bindings'       => Str::replaceArray('?', $event->bindings, $event->sql),
                'path'           => request()->path(),
                'req'            => request()->all(),
            ]);

            Log::build([
                'driver'               => 'single',
                'path'                 => storage_path('logs/query.log'),
                'replace_placeholders' => true,
                'formatter'            => JsonFormatter::class,
            ])->warning('Long running queries detected', $connection->getQueryLog());
        });

        DB::disableQueryLog();
    }

    private function loadExtraMigrationsPath(): void
    {
        if ( ! isEnvTesting())
        {
            $this->loadMigrationsFrom(__DIR__ . '/../..' . DataMigrationCommand::PATH);
        }
    }

    private function handleMissingTrans(): void
    {
        app(Translator::class)->handleMissingKeysUsing(function (string $key, array $replacements, ?string $locale): void {
            if (blank($key))
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

        Validator::extend('processable_image', static fn (string $attribute, mixed $value, array $parameters, \Illuminate\Contracts\Validation\Validator $validator) => InvokableValidationRule::make(new ValidateImageRule())
            ->setValidator($validator)
            ->passes($attribute, $value));
    }

    private function configureDate(): void
    {
        Date::use(CarbonImmutable::class);

        Date::macro('isHoliday', fn () => Holiday::query()->where('date', $this)->exists());

        Date::macro('toJalali', fn (): ?Jalalian => JalalianFactory::fromGregorian($this));

        Date::macro('createFromTimestampLocal', static fn ($timestamp) => Date::createFromTimestamp($timestamp, config()->string('app.timezone')));
    }

    private function configurePassword(): void
    {
        Password::defaults(
            static fn () => Password::min(8) // Minimum length of 8 characters
                ->mixedCase() // Must include both uppercase and lowercase letters
                ->letters()   // Must include at least one letter
                ->numbers()   // Must include at least one number
                ->symbols()   // Must include at least one symbol
                ->uncompromised(), // Checks against known data breaches
        );
    }

    private function configurePipelines(): void
    {
        $this->app
            ->get(Hub::class)
            ->pipeline(FiltersList::PROCESS_UPLOADED_IMAGE, fn (Pipeline $pipeline, UploadedFile $image) => $pipeline
                ->send($image)
                ->through([
                    ImageThumbnailResizeFilter::class,
                ])
                ->thenReturn());
    }

    private function configureNotification(): void
    {
        Notification::extend('whatsapp', static fn ($app) => $app->make(WhatsappChannel::class));
    }

    private function configureSchedule(): void
    {
        Event::macro('exceptOnHolidays', fn () => $this->skip(today()->isHoliday()));
    }

    private function configureUri(): void
    {
        Uri::macro('docs', fn () => $this->withPath('docs'));

        Uri::macro('inCategory', fn ($category) => $this->withPath('shop/' . $category . '/' . mb_trim($this->path(), '/')));

        Uri::macro('mobile', function () {
            $path = mb_trim($this->path(), '/');

            return $this->withHost('m.' . $this->host())
                ->withPath($path);
        });

        Uri::macro('tracking', fn ($campaign) => $this->withQuery(['utm_campaign' => $campaign, 'utm_source' => 'website']));
    }

    private function configureManager(): void
    {
        $this->app->singleton(function (Application $application): Manager {

            $config = $application->make(Repository::class)->get('services.manager');

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
        VerifyEmail::toMailUsing(static fn (User $user, string $url) => new MailMessage()
            ->subject('Verify Email Address')
            ->view('mail.email-verification', [ // TODO add template for it
                'title'       => 'Confirm your email address',
                'previewText' => 'Please confirm your email address',
                'user'        => $user,
                'url'         => $url,
            ]));
    }

    private function configureStringable(): void
    {
        Stringable::macro('toJson', fn (?bool $associative = null, int $depth = 512, int $flags = 0) => json_decode($this->value(), $associative, $depth, $flags));
    }

    private function configureCollection(): void
    {
        Collection::macro('reserveFirstAvailable', fn (string $key, int $duration = 60) => $this->first(fn ($item) => $item->reserve($key, $duration)));

        Collection::macro('c2c', fn () => $this->toJson(JSON_PRETTY_PRINT));
    }

    private function configureEloquentBuilder(): void
    {
        EloquentBuilder::macro('reserveFirstAvailable', fn (string $key, int $duration = 60) => $this->get()->first(fn ($item) => $item->reserve($key, $duration)));

        EloquentBuilder::macro('c2c', fn () => c2c(getSqlWithBindings($this)));

        EloquentBuilder::macro('getStrictTable', fn () => Str::afterLast($this->getModel()->getTable(), '.'));

        EloquentBuilder::macro('parent', fn () => $this->whereNull('parent_id'));

        EloquentBuilder::macro('active', fn () => $this->where('status', Status::Activated->value));

        EloquentBuilder::macro('forAuth', fn () => $this->whereBelongsTo(auth()->user()));
    }

    private function configureQueryBuilder(): void
    {
        QueryBuilder::macro('c2c', fn () => c2c(getSqlWithBindings($this)));
    }

    private function configureRoute(): void
    {
        Route::$validators = [
            ...Route::getValidators(),
            new IgnoreBindingValidator(),
        ];

        Route::macro('ignoreMissingBindings', fn () => true === Arr::get($this->action, 'ignoreMissingBindings'));
    }

    private function configureBlueprint(): void
    {
        Blueprint::macro('status', fn (string $default = 'inactive') => $this
            ->enum('status', [
                'active',
                'inactive',
                'blocked',
                'archived',
            ])
            ->comment('general status column')
            ->default($default)
            ->index());
    }

    private function configureHttpClientResponse(): void
    {
        HttpClientResponse::macro('c2c', function () {
            try
            {
                $this->collect()->c2c();
            } catch (Throwable)
            {
                c2c($this->body());
            }

            return $this;
        });
    }
}
