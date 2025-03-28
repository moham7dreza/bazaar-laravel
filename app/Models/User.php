<?php

namespace App\Models;

use App\Models\Advertise\Advertisement;
use App\Models\Advertise\AdvertisementNote;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'mobile_verified_at',
        'city_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
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
}
