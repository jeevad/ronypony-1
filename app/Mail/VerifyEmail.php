<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trans('notifications.verify_email'))
            ->view('emails.verify_email')
            ->with([
                'action' => $this->_formatActionUrl(),
            ]);
    }

    private function _formatActionUrl()
    {
        $actionUrl = str_replace(
            '{id}',
            $this->user->id,
            config("auth.email_verify_template_url")
        );
        $actionUrl .= "?token={$this->user->email_activation_token}";

        return $actionUrl;
    }
}
