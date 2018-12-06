<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateFullName implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $fullName
     * @return bool
     */
    public function passes($attribute, $fullName)
    {
        return preg_match("/^[a-zA-Z\.'\s]+$/", $fullName);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.custom.full_name.full_name');
    }
}
