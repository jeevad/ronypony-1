<?php

namespace App\Models;

use Hash;
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
        'full_name', 'email', 'password', 'mobile_number', 'sign_up_ip', 'sign_up_user_agent',
        'email_activation_token', 'email_activation_token_sent_at', 'role_id', 'group_id',
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

    protected $casts = [
        'banned' => 'boolean',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function group()
    {
        return $this->belongsTo(UserGroup::class);
    }

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

    public function queryEmail($query, $email)
    {
        return $query->where('email', $email);
    }

    public function queryMobileNumber($query, $mobileNumber)
    {
        return $query->where('mobile_number', $mobileNumber);
    }

    public function hasPassword(): bool
    {
        $password = $this->getAuthPassword();
        return $password !== '' && $password !== null;
    }

    public function isBanned(): bool
    {
        return !is_null($this->banned_at);
    }

    public function status(): string
    {
        return $this->banned ? 'Inactive' : 'Active';
    }

    public function authenticatePassword($plainPassword): bool
    {
        return Hash::check($plainPassword, $this->getAuthPassword());
    }

    public function updatePassword($password)
    {
        $this->password = Hash::make($password);
        $this->save();
    }

    public function avatarFolder()
    {
        return 'uploads/users/' . $this->id;
    }

    public function updateAvatar($avatar)
    {
        $this->avatar = $avatar;
        $this->save();
    }

    public function avatarURL()
    {
        if ($this->avatar) {
            return asset("storage/{$this->avatarFolder()}/{$this->avatar}");
        }
        return $this->gravatarUrl();
    }

    public function defaultAvatar()
    {
        return asset('assets/front/images/user50x50.png');
    }

    public function gravatarUrl($size = 100)
    {
        $hash = md5(strtolower(trim($this->email)));
        $default = urlencode($this->defaultAvatar());

        return "https://www.gravatar.com/avatar/$hash?s=$size&d=$default";
    }

    /**
     * Check admin role
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->isRole('admin');
    }

    /**
     * Returns whether a user has a role of 'moderator'
     *
     * @return boolean
     */
    public function isModerator()
    {
        return $this->isRole('moderator');
    }

    /**
     * Check user/citizen role
     *
     * @return bool
     */
    public function isUser()
    {
        return $this->isRole('user');
    }

    /**
     * Check if user is $role.
     *
     * @param string $role
     *
     * @return mixed
     */
    public function isRole($role)
    {
        return $this->role()->where('slug', $role)->exists();
    }

    /**
     * Check if user in $roles.
     *
     * @param array $roles
     *
     * @return mixed
     */
    public function inRoles($roles = [])
    {
        return $this->role()->whereIn('slug', (array)$roles)->exists();
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

    public function isInWishlist($productId)
    {
        $wishList = Wishlist::where('user_id', '=', $this->attributes['id'])
            ->where('product_id', '=', $productId)->get();

        if (count($wishList) <= 0) {
            return false;
        }

        return true;
    }
}
