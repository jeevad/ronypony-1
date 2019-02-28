<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateOfficeName implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $officeName
     * @return bool
     */
    public function passes($attribute, $officeName)
    {
        return preg_match("/^[a-zA-Z\-\,\.'\s]+$/", $officeName);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.custom.office_name.office_name');
    }
}
