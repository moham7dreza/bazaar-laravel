<?php

namespace App\Models;

use App\Enums\UserPermission;
use App\Enums\UserRole;
use Filament\Panel;
use App\Models\Advertise\Advertisement;
use App\Models\Advertise\AdvertisementNote;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail, FilamentUser
{
    use HasFactory, Notifiable;

    use HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'mobile_verified_at',
        'city_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin() && $this->hasVerifiedEmail();
    }

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }

    public function favoriteAdvertisements()
    {
        return $this->belongsToMany(Advertisement::class)->withTimestamps();
    }


    public function advertisementNotes()
    {
        return $this->hasMany(AdvertisementNote::class);
    }


    public function viewedAdvertisements()
    {
        return $this->belongsToMany(Advertisement::class, 'advertisement_view_history')->withTimestamps();
    }

    public function isAdmin(): bool
    {
        return $this->user_type === 1
            && !is_null($this->mobile_verified_at)
            && $this->hasPermissionTo(UserPermission::SEE_PANEL)
//            && $this->hasRole(UserRole::ADMIN)
            ;
    }

    public function scopeAdmin($query)
    {
        return $query->where('user_type', 1)
            ->whereNotNull('mobile_verified_at');
    }
}
