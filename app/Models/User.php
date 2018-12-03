<?php

namespace App\Models;

use App\Models\Traits\UserScope;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Traits\EmailVerification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    use EmailVerification, Notifiable, UserScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'email', 'password', 'sign_up_ip', 'sign_up_user_agent',
        'email_activation_token', 'email_activation_token_sent_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'email_activation_token_sent_at',
        'email_verified_at',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = strtolower($email);
    }

    public function setFullNameAttribute($fullName)
    {
        $this->attributes['full_name'] = ucwords($fullName);
    }

    public function hasPassword(): bool
    {
        $password = $this->getAuthPassword();
        return $password !== '' && $password !== null;
    }

    public function queryEmail($query, $email)
    {
        return $query->where('email', $email);
    }

    public function queryMobileNumber($query, $mobileNumber)
    {
        return $query->where('mobile_number', $mobileNumber);
    }

    public function isBanned(): bool
    {
        return !is_null($this->banned_at);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
