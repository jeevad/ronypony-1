<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordReset extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $user;
    protected $token;
    protected $channel;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $user)
    {
        $this->token = $token;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = trans('notifications.welcome_email_subject');

        return $this->subject($subject)
            ->view('emails.password_link')
            ->with([
                'logo' => logo_url(),
                'action' => $this->_formatActionUrl(),
            ]);
    }

    private function _formatActionUrl()
    {
        $actionUrl = str_replace(
            '{token}',
            $this->token,
            config("auth.reset_password_template_url")
        );
        $actionUrl .= "?email={$this->user->email}";

        return $actionUrl;
    }
}
