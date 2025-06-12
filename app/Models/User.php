<?php

declare(strict_types=1);

namespace App\Models;

use Afsakar\FilamentOtpLogin\Models\Contracts\CanLoginDirectly;
use App\Concerns\GeneratesUsernames;
use App\Concerns\InteractWithSensitiveColumns;
use App\Concerns\MustVerifyMobile;
use App\Contracts\MustVerifyMobile as ShouldVerifiedMobile;
use App\Enums\StorageDisk;
use App\Enums\Theme;
use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Events\UserUpdatedEvent;
use App\Models\Geo\City;
use App\Models\Scopes\LatestScope;
use Database\Factories\UserFactory;
use DateTimeInterface;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;
use Kenepa\ResourceLock\Models\Concerns\HasLocks;
use Laravel\Sanctum\HasApiTokens;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Models\AdvertisementNote;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

#[UseFactory(UserFactory::class)]
#[ScopedBy([LatestScope::class])]
final class User extends Authenticatable implements CanLoginDirectly, FilamentUser, HasAvatar, ShouldVerifiedMobile
{
    //    use GeneratesUsernames;
    use HasApiTokens;
    use HasFactory;
    use HasLocks;
    use HasRoles;
    use InteractWithSensitiveColumns;
    use LogsActivity;
    use MustVerifyMobile;
    use Notifiable;
    use SoftDeletes;
    use TwoFactorAuthenticatable;

    const int TYPE_USER  = 0;

    const int TYPE_ADMIN = 1;

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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        'theme'     => Theme::DRACULA->value,
        'is_active' => true,
        'user_type' => self::TYPE_USER,
    ];

    protected static array $recordEvents = ['deleted', 'updated'];

    protected $dispatchesEvents = [
        'updated' => UserUpdatedEvent::class,
    ];

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
        return $this->avatar_url ? Storage::disk(StorageDisk::PUBLIC->value)->url($this->avatar_url) : null;
    }

    #[Scope]
    public function admin(Builder $query): Builder
    {
        return $query->ofType(self::TYPE_ADMIN)
            ->whereNotNull('mobile_verified_at');
    }

    #[Scope]
    public function suspended(Builder $query): Builder
    {
        return $query->whereNotNull('suspended_at')
            ->where('suspended_until', '>=', now());
    }

    #[Scope]
    public function ofType(Builder $query, int $type): void
    {
        $query->where('user_type', $type);
    }

    #[Scope]
    public function createdAfter(Builder $query, DateTimeInterface|string|int $date): void
    {
        $query->where('created_at', '>=', Carbon::parse($date));
    }

    public function advertisements(): HasMany
    {
        return $this->hasMany(Advertisement::class);
    }

    public function favoriteAdvertisements(): BelongsToMany
    {
        return $this->belongsToMany(Advertisement::class)->withTimestamps();
    }

    public function advertisementNotes(): HasMany
    {
        return $this->hasMany(AdvertisementNote::class);
    }

    public function viewedAdvertisements(): BelongsToMany
    {
        return $this->belongsToMany(Advertisement::class, 'advertisement_view_history')->withTimestamps();
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class)->withDefault(['name' => __('Unknown city')]);
    }

    public function latestAdvertisement(): HasOne
    {
        return $this->hasOne(Advertisement::class)->latestOfMany();
    }

    public function mostViewedAdvertisement(): HasOne
    {
        return $this->hasOne(Advertisement::class)->ofMany('view', 'max');
    }

    // the newest advertisement with likest in last month
    public function popularRecentAdvertisement(): HasOne
    {
        return $this->hasOne(Advertisement::class)->ofMany(
            [
                'like'       => 'max',
                'created_at' => 'max',
            ],
            function (Builder $query): void {
                $query->where('created_at', '>', now()->subMonth());
            }
        );
    }

    public function specialAdvertisements(): HasMany
    {
        return $this->hasMany(Advertisement::class)->withAttributes(['is_special' => true]);
    }

    public function actionTags()
    {
        return $this->hasMany(UserActionTag::class);
    }

    public function isAdmin(): bool
    {
        return self::TYPE_ADMIN === $this->user_type
            && ($this->hasVerifiedMobile() || $this->hasVerifiedEmail())
            && ($this->checkPermissionTo(UserPermission::SEE_PANEL) || $this->hasRole(UserRole::ADMIN));
    }

    // suspend section

    public function isSuspended(): bool
    {
        return null !== $this->suspended_at && now()->lte($this->suspended_until);
    }

    public function suspend(): bool
    {
        return $this->update([
            'suspend_at'      => now(),
            'suspended_until' => now()->addWeek(),
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

    public function hasAdvertisements(): Attribute
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
            //            'addresses' => \Illuminate\Database\Eloquent\Casts\AsCollection::of(\App\Data\ValueObjects\Address::class)
        ];
    }
}
