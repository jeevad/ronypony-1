<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class ValidateEmailVerifield implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $email
     * @return bool
     */
    public function passes($attribute, $email)
    {
        $userCount = User::email($email)
            ->emailVerified()
            ->count();

        return (bool)$userCount;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $message = trans('auth.email_not_verified');
        return $message;
    }
}
