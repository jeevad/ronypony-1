<?php

namespace App\Listeners;

use Mail;
use App\Mail\VerifyEmail;
use App\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailVerificationMail
{
    /**
     * Handle the event.
     *
     * @param  Registered $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        if (!$event->user->hasVerifiedEmail()) {
            Mail::to($event->user)->send(new VerifyEmail($event->user));
        }
    }
}
