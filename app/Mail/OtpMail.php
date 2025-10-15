<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $otp;

    /**
     * Create a new message instance.
     */
    public function __construct(string $otp)
    {
        $this->otp = $otp;
    }

    /**
     * Build the message.
     */
    public function build(): static
    {
        return $this->subject('Your Fittelly Email Verification Code')
            ->view('emails.otp')
            ->with([
                'otp' => $this->otp,
            ]);
    }
}
