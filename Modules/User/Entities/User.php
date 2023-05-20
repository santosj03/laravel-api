<?php

namespace Modules\User\Entities;

// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Modules\Product\Entities\Product;
use Modules\User\Entities\UserDetails;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password', 'user_access_status_id', 'login_attempts', 'last_login_at', 'locked_until'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function details()
    {
        return $this->hasOne(UserDetails::class);
    }
    
    public function status()
    {
        return $this->hasOne(UserAccessStatus::class, 'id', 'user_access_status_id');
    }
}
