<?php
namespace App\Inspections;

use Exception;

class KeyHeldDown
{
    /**
     * Detect spam.
     *
     * @param  string $body
     * @throws \Exception
     */
    public function detect($body)
    {
        if (preg_match('/(.)\\1{4,}/u', $body)) {
            throw new Exception(trans('validation.spam_free'));
        }
    }
}