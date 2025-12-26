<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Broadcasting\WhatsappChannel;
use App\Console\Commands\System\DataMigrationCommand;
use App\Enums\Currency;
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
use Dedoc\Scramble\Scramble;
use DirectoryTree\Metrics\Facades\Metrics;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Filament\Notifications\Auth\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Database\Connection;
use Illuminate\Database\Console\DumpCommand;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response as HttpClientResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pipeline\Hub;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Number;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Illuminate\Support\Uri;
use Illuminate\Validation\InvokableValidationRule;
use Illuminate\Validation\Rules\Email;
use Illuminate\Validation\Rules\Password;
use Modules\Advertise\Models\Advertisement;
use Monolog\Formatter\JsonFormatter;
use Morilog\Jalali\Jalalian;

use function Illuminate\Support\minutes;

trait HasCustomApplicationConfig
{
    public function configureResetPassword(): void
    {
        ResetPassword::createUrlUsing(fn (User $notifiable, string $token): string => config('app.frontend_url') . "/password-reset/{$token}?email={$notifiable->getEmailForPasswordReset()}");
    }

    public function configureEmail(): void
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

    public function configureCommands(): void
    {
        DB::prohibitDestructiveCommands(app()->isProduction());

        DumpCommand::prohibit(app()->isProduction());
    }

    public function configureModel(): void
    {
        Model::automaticallyEagerLoadRelationships();

        Model::shouldBeStrict( ! app()->isProduction());

        Model::unguard();
    }

    public function configureUrl(): void
    {
        URL::forceHttps(app()->isProduction());

        // @todo:high: have problem in admin.
        /*
        URL::useOrigin(
            ClientDomainService::getDomainWithFallBack()->value
        );
        */
    }

    public function configureHttp(): void
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

        Http::macro('profile', static fn () => Http::retry(
            3,
            100,
            static fn ($e, $attempts): bool => $e instanceof ConnectionException
        )
            ->connectTimeout(5)
            ->timeout(5)
            ->get('https://thispersondoesnotexist.com/')
            ->throw());
    }

    public function configureVite(): void
    {
        Vite::useAggressivePrefetching();
    }

    public function configureNumber(): void
    {
        Number::useCurrency(
            Currency::currentCurrency()->value
        );
    }

    public function configureGates(): void
    {
        // @todo:high: fix gate.
        // Gate::before(static fn (?User $user): ?bool => $user?->isAdmin());
    }

    public function logSlowQuery(): void
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

    public function loadExtraMigrationsPath(): void
    {
        if ( ! app()->runningUnitTests())
        {
            $this->loadMigrationsFrom(__DIR__ . '/../..' . DataMigrationCommand::PATH);
        }
    }

    public function handleMissingTrans(): void
    {
        resolve(Translator::class)->handleMissingKeysUsing(function (string $key, array $replacements, ?string $locale): void {
            if (blank($key))
            {
                return;
            }

            ondemand_info(sprintf('Missing translation key: *** ( %s ) ***', $key), file: 'translation');

            // Only update JSON translation files (skip PHP array files)
            if ( ! str_contains($key, '.'))
            {
                resolve(TranslationService::class)->addMissingKeyToJsonLangFile($key, $locale);
            }
        });
    }

    public function configureValidator(): void
    {
        Validator::extend('mobile', static fn (string $attribute, mixed $value, array $parameters, Validator $validator): bool => ! ($validator->make(['password' => $value], [
            'password' => 'numeric|digits:11|regex:/^09[0-9]{9}$/',
        ])->fails()));

        Validator::extend('national_code', static fn (string $attribute, mixed $value, array $parameters, \Illuminate\Contracts\Validation\Validator $validator) => InvokableValidationRule::make(new ValidateNationalCodeRule())
            ->setValidator($validator)
            ->passes($attribute, $value));

        Validator::extend('processable_image', static fn (string $attribute, mixed $value, array $parameters, \Illuminate\Contracts\Validation\Validator $validator) => InvokableValidationRule::make(new ValidateImageRule())
            ->setValidator($validator)
            ->passes($attribute, $value));
    }

    public function configureDate(): void
    {
        Date::use(CarbonImmutable::class);

        Date::macro('isHoliday', fn () => Holiday::query()->where('date', $this)->exists());

        Date::macro('toJalali', fn (): ?Jalalian => JalalianFactory::fromGregorian($this));

        Date::macro('createFromTimestampLocal', static fn ($timestamp) => Date::createFromTimestamp($timestamp, config()->string('app.timezone')));
    }

    public function configurePassword(): void
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

    public function configurePipelines(): void
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

    public function configureNotification(): void
    {
        Notification::extend('whatsapp', static fn ($app) => $app->make(WhatsappChannel::class));
    }

    public function configureSchedule(): void
    {
        Event::macro('exceptOnHolidays', fn () => $this->skip(today()->isHoliday()));
    }

    public function configureUri(): void
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

    public function configureManager(): void
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

    public function configureVerifyEmail(): void
    {
        // custom email verification template
        VerifyEmail::toMailUsing(static fn (User $user, string $url) => new MailMessage()
            ->subject('Verify Email Address')
            ->view('mail.email-verification', [ // @todo:high: add template for it
                'title'       => 'Confirm your email address',
                'previewText' => 'Please confirm your email address',
                'user'        => $user,
                'url'         => $url,
            ]));
    }

    public function configureStringable(): void
    {
        Stringable::macro('toJson', fn (?bool $associative = null, int $depth = 512, int $flags = 0): mixed => json_decode($this->value(), $associative, $depth, $flags));
    }

    public function configureStr(): void
    {
        Str::macro('lowerSnake', static fn (string $str) => Str::lower(Str::snake($str)));
    }

    public function configureSupportCollection(): void
    {
        SupportCollection::macro('reserveFirstAvailable', fn (string $key, int $duration = 60) => $this->first(fn ($item) => $item->reserve($key, $duration)));

        SupportCollection::macro('c2c', fn () => $this->toJson(JSON_PRETTY_PRINT));

        SupportCollection::macro('paginate', function (int $perPage, ?int $page = null, string $pageName = 'page'): LengthAwarePaginator {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                items: $this->forPage($page, $perPage),
                total: $this->count(),
                perPage: $perPage,
                currentPage: $page,
                options: [
                    'path'     => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

    }

    public function configureEloquentBuilder(): void
    {
        EloquentBuilder::macro('reserveFirstAvailable', fn (string $key, int $duration = 60) => $this->get()->first(fn ($item) => $item->reserve($key, $duration)));

        /**
         * copy to clipboard macro
         * copy sql query to clipboard, useful for debugging.
         */
        EloquentBuilder::macro('c2c', fn () => c2c(getSqlWithBindings($this)));

        EloquentBuilder::macro('getStrictTable', fn () => Str::afterLast($this->getModel()->getTable(), '.'));

        EloquentBuilder::macro('parent', fn () => $this->whereNull('parent_id'));

        EloquentBuilder::macro('active', fn () => $this->where('status', Status::Activated->value));

        EloquentBuilder::macro('createdAfter', fn (
            DateTimeInterface $dateTime
        ) => $this->where('created_at', '>', $dateTime));

        EloquentBuilder::macro('forAuth', fn () => $this->whereBelongsTo(auth()->user()));

        /**
         * just in time macro for builder
         * no query executed until you access the collection.
         */
        EloquentBuilder::macro('jit', fn (): object => new ReflectionClass($this->getModel()->newCollection())
            ->newLazyProxy(fn () => $this->get()));

        EloquentBuilder::macro('remember', fn (
            int $duration,
            ?string $key = null,
            array $tags  = [],
        ): EloquentCollection => (blank($tags) ? cache() : cache()->tags($tags))->remember(
            key: $key ?: $this->getCacheKey(),
            ttl: $duration,
            callback: fn () => $this->get()
        ));

        EloquentBuilder::macro('rememberForever', fn (
            ?string $key = null,
            array $tags  = [],
        ): EloquentCollection => (blank($tags) ? cache() : cache()->tags($tags))->rememberForever(
            key: $key ?: $this->getCacheKey(),
            callback: fn () => $this->get()
        ));

        EloquentBuilder::macro('getCacheKey', fn (): string => sprintf(
            'eloquent_%s_%s',
            $this->getModel()->getTable(),
            md5($this->toSql() . serialize($this->getBindings()))
        ));

        EloquentBuilder::macro('rememberPaginate', fn (
            int $perPage     = 15,
            array $columns   = ['*'],
            string $pageName = 'page',
            ?int $page       = null,
            int $duration    = 60,
            ?string $key     = null,
            array $tags      = [],
        ): LengthAwarePaginator => (blank($tags) ? cache() : cache()->tags($tags))->remember(
            key: $key ?: $this->getPaginateCacheKey($perPage, $page),
            ttl: $duration,
            callback: fn () => $this->paginate($perPage, $columns, $pageName, $page)
        ));

        EloquentBuilder::macro('getPaginateCacheKey', fn (
            int $perPage,
            ?int $page = null
        ): string => sprintf(
            'eloquent_paginate_%s_%s_%s_%s',
            $this->getModel()->getTable(),
            $perPage,
            $page ?: request()->integer('page', 1),
            md5($this->toSql() . serialize($this->getBindings()))
        ));
    }

    public function configureQueryBuilder(): void
    {
        QueryBuilder::macro('c2c', fn () => c2c(getSqlWithBindings($this)));
    }

    public function configureRoutingRoute(): void
    {
        RoutingRoute::$validators = [
            ...RoutingRoute::getValidators(),
            new IgnoreBindingValidator(),
        ];

        RoutingRoute::macro('ignoreMissingBindings', fn (): bool => true === Arr::get($this->action, 'ignoreMissingBindings'));
    }

    public function configureBlueprint(): void
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

    public function configureHttpClientResponse(): void
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

    public function bindSearchClient(): void
    {
        $this->app->bind(Client::class, fn (Application $app): Client => ClientBuilder::create()
            ->setHosts($app->make(Repository::class)->array('services.search.hosts'))
            ->build());
    }

    public function configureMail(): void
    {
        if ($overrideMail = config('mail.override_to'))
        {
            Mail::alwaysTo($overrideMail);
        }
    }

    public function configureRateLimiter(): void
    {
        RateLimiter::for('otp-request', static fn (Request $request): array => [
            Limit::perMinutes(2, 5)
                ->by($request->get('mobile') ?: $request->ip()),
        ]);

        RateLimiter::for('uploads', static fn (Request $request) => $request->user()?->isPremium()
            ? Limit::none()
            : Limit::perMinute(10));
    }

    public function configureCommandsToRunOnReload(): void
    {
        $this->reloads('permission:cache-reset');
    }

    public function configureMetrics(): void
    {
        Metrics::capture();
    }

    public function configureScramble(): void
    {
        Scramble::routes(fn (Route $route): bool => str_starts_with($route->uri(), 'api'));
    }

    public function configureQueue(): void
    {
        Queue::withoutInterruptionPolling();
    }

    public function configureRoute(): void
    {
        Route::model(
            'user',
            User::class,
            fn (int $id) => cache()->remember(
                "user.{$id}",
                minutes(5),
                fn () => User::query()
                    ->findOrFail($id)
            )
        );
    }

    public function validateEnvironmentVariables(): void
    {
        $variables = [
            'APP_ENV',
            'DB_HOST',
            'DB_DATABASE',
        ];

        foreach ($variables as $variable)
        {
            throw_unless(env($variable), "Missing env variable: {$variable}");
        }
    }

    public function configureEloquentRelation(): void
    {
        Relation::enforceMorphMap([
            'user'          => User::class,
            'advertisement' => Advertisement::class,
        ]);
    }
}
