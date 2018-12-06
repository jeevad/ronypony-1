<?php

namespace App\Rules;

use Exception;
use App\Inspections\Spam;
use Illuminate\Contracts\Validation\Rule;

class SpamFree implements Rule
{
    public function passes($attribute, $value)
    {
        try {
            return !resolve(Spam::class)->detect($value);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.spam_free');
    }
}
