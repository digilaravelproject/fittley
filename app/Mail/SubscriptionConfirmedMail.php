<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\UserSubscription;

class SubscriptionConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subscription;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\UserSubscription  $subscription
     * @return void
     */
    public function __construct(UserSubscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $planName = $this->subscription->subscriptionPlan->name ?? 'Plan';

        return $this->subject("Subscription activated: {$planName}")
            ->view('emails.subscription_confirmed')
            ->with([
                'subscription' => $this->subscription,
            ]);
    }
}
