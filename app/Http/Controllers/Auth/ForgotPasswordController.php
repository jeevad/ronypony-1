<?php

namespace App\Http\Controllers\Auth;

use Mail;
use App\Models\User;
use App\Mail\PasswordReset;
use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponse;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Send activation link to set new password
     *
     * @param ForgotPasswordRequest $request
     * @return SuccessResponse
     */
    public function __invoke(ForgotPasswordRequest $request)
    {
        $user = User::email($request->input('email'))->first();
        $token = $this->broker()->createToken($user);
        Mail::to($user)->send(new PasswordReset($token, $user));

        return new SuccessResponse(trans('passwords.sent'), ['token' => $token]);
    }
}
