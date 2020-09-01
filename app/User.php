<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getIsMasterAttribute()
    {
        return $this->profile->getMorphClass() == SuperAdminProfile::class
            || $this->profile->getMorphClass() == AdminProfile::class;
    }

    public function getIsSuperAdminAttribute()
    {
        return $this->profile->getMorphClass() == SuperAdminProfile::class;
    }

    public function getIsAdminAttribute()
    {
        return $this->profile->getMorphClass() == AdminProfile::class;
    }

    public function getIsSeekerAttribute()
    {
        return $this->profile->getMorphClass() == SeekerProfile::class;
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->morphTo();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
