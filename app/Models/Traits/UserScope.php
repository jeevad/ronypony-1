<?php

namespace App\Models\Traits;

trait UserScope
{
    public function scopeEmail($query, $email)
    {
        return $this->queryEmail($query, $email);
    }

    public function scopeMobileNumber($query, $mobileNumber)
    {
        return $this->queryMobileNumber($query, $mobileNumber);
    }

    public function scopeEmailOrMobileNumber($query, $loginKey)
    {
        return $this->queryEmailOrMobileNumber($query, $loginKey);
    }

    public function scopeEmailVerified($query)
    {
        return $query->where('email_verified', 1);
    }
}
