<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\User  $user
     * @param  string  $token
     * @return void
     */
    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // You might want to use the token in the view to build a reset link
        $resetLink = url('/password/reset/' . $this->token);

        return $this->subject('Reset your Fittelly password')
            ->view('emails.password_reset')
            ->with([
                'user' => $this->user,
                'resetLink' => $resetLink,
            ]);
    }
}
