<?php

namespace App\Models;

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Http\Interfaces\MustVerifyMobile as ShouldVerifiedMobile;
use App\Models\Advertise\Advertisement;
use App\Models\Advertise\AdvertisementNote;
use App\Models\Geo\City;
use App\Traits\MustVerifyMobile;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, ShouldVerifiedMobile
{
    /*** _____________________________________________ use SECTION ________________________________________________ ***/
    use HasFactory;
    use HasRoles;
    use LogsActivity;
    use MustVerifyMobile;
    use Notifiable;
    use SoftDeletes;

    /*** _____________________________________________ props SECTION ______________________________________________ ***/

    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'mobile_verified_at',
        'city_id',
        'user_type',
        'is_active',
        'is_banned',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static array $recordEvents = ['deleted', 'updated'];

    /*** _____________________________________________ model related methods SECTION ______________________________ ***/

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'mobile_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'bool',
            'is_banned' => 'bool',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['email', 'mobile', 'user_type', 'is_active', 'is_banned']);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }

    #[Scope]
    public function admin(Builder $query): Builder
    {
        return $query->where('user_type', 1)
            ->whereNotNull('mobile_verified_at');
    }

    /*** _____________________________________________ relations SECTION __________________________________________ ***/
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
        return $this->belongsTo(City::class);
    }

    /*** _____________________________________________ method SECTION __________________________________________ ***/

    public function isAdmin(): bool
    {
        return $this->user_type === 1
            && ($this->hasVerifiedMobile() || $this->hasVerifiedEmail())
            && $this->hasPermissionTo(UserPermission::SEE_PANEL);
        //            && $this->hasRole(UserRole::ADMIN)
    }
}
