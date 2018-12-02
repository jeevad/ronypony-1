<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;
use App\Exceptions\TokenMismatchException;

trait EmailVerification
{
    /**
     * Check if the user verification is pending.
     *
     * @return boolean
     */
    public function isPendingEmailVerification(): bool
    {
        return !$this->email_verified && $this->hasVerificationToken();
    }

    /**
     * Checks if the user has a verification token.
     *
     * @return bool
     */
    public function hasVerificationToken(): bool
    {
        return !is_null($this->email_activation_token);
    }

    /**
     * Generate the verification token.
     *
     * @return string|bool
     */
    public static function generateActivationToken()
    {
        return hash_hmac('sha256', Str::random(40), config('app.key'));
    }

    /**
     * Update and save the model instance with the verification token.
     * @param  string $token
     * @return bool
     */
    public function saveActivationToken()
    {
        $this->email_verified = 0;
        $this->email_verified_at = null;
        $this->email_activation_token = static::generateActivationToken();
        $this->email_activation_token_sent_at = now();
        $this->save();
    }

    /**
     * Compare the two given tokens.
     *
     * @param $requestToken
     * @throws TokenMismatchException
     */
    public function verifyActivationToken($requestToken)
    {
        if ($this->email_activation_token !== $requestToken) {
            throw new TokenMismatchException();
        }
    }

    /**
     * Save the given user as verified.
     *
     * @return void
     */
    public function wasEmailVerified()
    {
        $this->email_verified = true;
        $this->email_verified_at = now();
        $this->email_activation_token = null;
        $this->email_activation_token_sent_at = null;
        $this->save();
    }
}