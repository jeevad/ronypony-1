<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateZIPCode implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $zipCode
     * @return bool
     */
    public function passes($attribute, $zipCode)
    {
        return strlen($zipCode) === 6;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.custom.zip_code.zip_code');
    }
}
