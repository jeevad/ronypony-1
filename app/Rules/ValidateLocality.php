<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateLocality implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $locality
     * @return bool
     */
    public function passes($attribute, $locality)
    {
        return preg_match("/^[a-zA-Z\.'\s]+$/", $locality);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.custom.locality.locality');
    }
}
