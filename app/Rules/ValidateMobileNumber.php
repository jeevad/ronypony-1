<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateMobileNumber implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $mobileNumber
     * @return bool
     */
    public function passes($attribute, $mobileNumber)
    {
        return valid_mobile_number($mobileNumber);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.custom.mobile_number.mobile_number');
    }
}
