<?php

declare(strict_types=1);

namespace App\Models;

use Afsakar\FilamentOtpLogin\Models\Contracts\CanLoginDirectly;
use App\Concerns\GeneratesUsernames;
use App\Concerns\InteractWithSensitiveColumns;
use App\Concerns\MustVerifyMobile;
use App\Contracts\MustVerifyMobile as ShouldVerifiedMobile;
use App\Enums\ClientDomain;
use App\Enums\ClientLocale;
use App\Enums\StorageDisk;
use App\Enums\Theme;
use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Events\UserUpdatedEvent;
use App\Helpers\ClientLocaleService;
use App\Http\Resources\Admin\User\UserCollection;
use App\Http\Resources\Admin\User\UserResource;
use App\Models\Geo\City;
use App\Models\Scopes\LatestScope;
use Database\Factories\UserFactory;
use DateTimeInterface;
use DirectoryTree\Metrics\HasMetrics;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Attributes\UseResourceCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsEncryptedArrayObject;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;
use Kenepa\ResourceLock\Models\Concerns\HasLocks;
use Laravel\Sanctum\HasApiTokens;
use MeShaon\RequestAnalytics\Contracts\CanAccessAnalyticsDashboard;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Models\AdvertisementNote;
use Modules\Payment\Models\Payment;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Zap\Models\Concerns\HasSchedules;

#[UseFactory(UserFactory::class)]
#[UseResource(UserResource::class)]
#[UseResourceCollection(UserCollection::class)]
#[ScopedBy([LatestScope::class])]
final class User extends Authenticatable implements
    CanLoginDirectly,
    FilamentUser,
    HasAvatar,
    HasLocalePreference,
    ShouldVerifiedMobile,
    CanAccessAnalyticsDashboard
{
    //    use GeneratesUsernames;
    use HasApiTokens;
    use HasFactory;
    use HasLocks;
    use HasMetrics;
    use HasRoles;
    use HasSchedules;
    use InteractWithSensitiveColumns;
    use LogsActivity;
    use MustVerifyMobile;
    use Notifiable;
    use SoftDeletes;
    use TwoFactorAuthenticatable;

    const int TypeUser = 0;

    const int TypeAdmin = 1;

    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'mobile_verified_at',
        'city_id',
        'user_type',
        'is_active',
        'suspended_at',
        'suspended_until',
        'avatar_url',
        'last_login_at',
        'last_login_ip',
        'secrets',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        'theme'     => Theme::Dracula->value,
        'is_active' => true,
        'user_type' => self::TypeUser,
    ];

    protected static array $recordEvents = ['deleted', 'updated'];

    protected $dispatchesEvents = [
        'updated' => UserUpdatedEvent::class,
    ];

    public function preferredLocale(): string
    {
        return ClientLocaleService::getUserLocaleWithFallback($this)->value;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'email',
                'mobile',
                'user_type',
                'is_active',
                'suspended_at',
                'suspended_until',
            ]);
    }

    public function canAccessAnalyticsDashboard(): bool
    {
        return $this->isAdmin();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }

    public function canLoginDirectly(): bool
    {
        return str($this->email)->is('admin@admin.com');
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::disk(StorageDisk::Public->value)->url($this->avatar_url) : null;
    }

    /**
     * @return HasMany<Advertisement, $this>
     */
    public function advertisements(): HasMany
    {
        return $this->hasMany(Advertisement::class);
    }

    /**
     * @return BelongsToMany<Advertisement, $this, Pivot>
     */
    public function favoriteAdvertisements(): BelongsToMany
    {
        return $this->belongsToMany(Advertisement::class)->withTimestamps();
    }

    /**
     * @return HasMany<AdvertisementNote, $this>
     */
    public function advertisementNotes(): HasMany
    {
        return $this->hasMany(AdvertisementNote::class);
    }

    /**
     * @return BelongsToMany<Advertisement, $this, Pivot>
     */
    public function viewedAdvertisements(): BelongsToMany
    {
        return $this->belongsToMany(Advertisement::class, 'advertisement_view_history')->withTimestamps();
    }

    /**
     * @return BelongsTo<City, $this>
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class)->withDefault(['name' => __('Unknown city')]);
    }

    /**
     * @return HasOne<Advertisement, $this>
     */
    public function latestAdvertisement(): HasOne
    {
        return $this->hasOne(Advertisement::class)->latestOfMany();
    }

    /**
     * @return HasOne<Advertisement, $this>
     */
    public function mostViewedAdvertisement(): HasOne
    {
        return $this->hasOne(Advertisement::class)->ofMany('view', 'max');
    }

    // the newest advertisement with likest in last month
    /**
     * @return HasOne<Advertisement, $this>
     */
    public function popularRecentAdvertisement(): HasOne
    {
        return $this->hasOne(Advertisement::class)->ofMany(
            [
                'like'       => 'max',
                'created_at' => 'max',
            ],
            function (Builder $query): void {
                $query->where('created_at', '>', Date::now()->subMonth());
            }
        );
    }

    /**
     * @return HasMany<Advertisement, $this>
     */
    public function specialAdvertisements(): HasMany
    {
        return $this->hasMany(Advertisement::class)->withAttributes(['is_special' => true]);
    }

    /**
     * @return HasMany<UserActionTag, $this>
     */
    public function actionTags(): HasMany
    {
        return $this->hasMany(UserActionTag::class);
    }

    /**
     * @return HasMany<Payment, $this>
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function isAdmin(): bool
    {
        return self::TypeAdmin === $this->user_type
            && ($this->hasVerifiedMobile() || $this->hasVerifiedEmail())
            && ($this->checkPermissionTo(UserPermission::SeePanel) || $this->hasRole(UserRole::Admin));
    }

    // suspend section

    public function isSuspended(): bool
    {
        return null !== $this->suspended_at && Date::now()->lte($this->suspended_until);
    }

    public function suspend(): bool
    {
        return $this->update([
            'suspend_at'      => Date::now(),
            'suspended_until' => Date::now()->addWeek(),
        ]);
    }

    public function unsuspend(): bool
    {
        return $this->update([
            'suspended_until' => null,
        ]);
    }

    // end suspend section

    /**
     * determine if the user owns the given model.
     */
    public function owns(Model $model, string $relation = 'user')
    {
        return $model->{$relation}()->is($this);
    }

    public function updateLoginFields(): bool
    {
        return $this->updateQuietly([
            'last_login_at' => Date::now()->toDateTimeString(),
            'last_login_ip' => request()->getClientIp(),
        ]);
    }

    public function getDomain(): ?ClientDomain
    {
        return $this->domain ? ClientDomain::fromNumber($this->domain) : null;
    }

    public function getLocale(): ?ClientLocale
    {
        return $this->locale ? ClientLocale::fromNumber($this->locale) : null;
    }

    #[Scope]
    protected function admin(Builder $query): Builder
    {
        return $query->ofType(self::TypeAdmin)
            ->whereNotNull('mobile_verified_at');
    }

    #[Scope]
    protected function suspended(Builder $query): Builder
    {
        return $query->whereNotNull('suspended_at')
            ->where('suspended_until', '>=', Date::now());
    }

    #[Scope]
    protected function ofType(Builder $query, int $type): void
    {
        $query->where('user_type', $type);
    }

    #[Scope]
    protected function createdAfter(Builder $query, DateTimeInterface|string|int $date): void
    {
        $query->where('created_at', '>=', Date::parse($date));
    }

    /**
     * @accessor has_advertisements
     */
    protected function hasAdvertisements(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->relationLoaded('advertisements') ? $this->advertisements()->exists() : null,
        );
    }

    protected function casts(): array
    {
        return [
            'email_verified_at'  => 'datetime',
            'mobile_verified_at' => 'datetime',
            'password'           => 'hashed',
            'is_active'          => 'bool',
            'suspended_at'       => 'datetime',
            'suspended_until'    => 'datetime',
            'last_login_at'      => 'datetime',
            //            'addresses' => \Illuminate\Database\Eloquent\Casts\AsCollection::of(\App\Data\ValueObjects\Address::class),
            'domain'  => 'integer',
            'locale'  => 'integer',
            'secrets' => AsEncryptedArrayObject::class,
        ];
    }
}
