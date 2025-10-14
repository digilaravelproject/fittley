<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\UserSubscription;

class SubscriptionExpiryReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subscription;
    public $daysLeft;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\UserSubscription  $subscription
     * @param  int  $daysLeft
     * @return void
     */
    public function __construct(UserSubscription $subscription, int $daysLeft)
    {
        $this->subscription = $subscription;
        $this->daysLeft = $daysLeft;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $planName = $this->subscription->subscriptionPlan->name ?? 'Plan';

        return $this->subject("Your {$planName} is expiring in {$this->daysLeft} day(s)")
            ->view('emails.subscription_expiry_reminder')
            ->with([
                'subscription' => $this->subscription,
                'daysLeft' => $this->daysLeft,
            ]);
    }
}
