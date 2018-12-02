<?php

namespace App\Http\Controllers\Auth;

use Mail;
use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Responses\SuccessResponse;
use App\Http\Requests\VerifyEmailRequest;
use Illuminate\Auth\Access\AuthorizationException;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be resent if the user did not receive the original email message.
    |
    */

    public function verify(VerifyEmailRequest $request)
    {
        $user = $request->user('api');
        if ($request->route('id') != $user->getKey()) {
            throw new AuthorizationException(trans('alerts.unauthorized'));
        }
        $user->verifyActivationToken($request->input('token'));
        $user->wasEmailVerified();

        return new SuccessResponse(trans('alerts.email_verified'));
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        $user = $request->user('api');
        if ($user->hasVerifiedEmail()) {
            return new SuccessResponse('Your Email already verified');
        }

        $user->saveActivationToken();
        Mail::to($user)->send(new VerifyEmail($user));

        return new SuccessResponse(trans('auth.verification_link_sent'));
    }
}
