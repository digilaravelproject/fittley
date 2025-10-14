<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentFailedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $reason;

    /**
     * Create a new message instance.
     *
     * @param  mixed  $user
     * @param  string|null  $reason
     * @return void
     */
    public function __construct($user, $reason = null)
    {
        $this->user = $user;
        $this->reason = $reason;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Customize the subject as needed
        return $this->subject("Payment Failed")
            ->view('emails.payment_failed')
            ->with([
                'user' => $this->user,
                'reason' => $this->reason,
            ]);
    }
}
