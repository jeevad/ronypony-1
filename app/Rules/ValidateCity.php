<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateCity implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $city
     * @return bool
     */
    public function passes($attribute, $city)
    {
        return preg_match("/^[a-zA-Z0-9\,\.'\s]+$/", $city);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.custom.city.city');
    }
}
