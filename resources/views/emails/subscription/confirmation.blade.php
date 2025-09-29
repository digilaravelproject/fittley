@component('mail::message')
# Welcome to Fittelly! 🎉

Hi {{ $user->name }},

**Congratulations!** Your subscription to **{{ $plan->name }}** has been successfully activated.

@component('mail::panel')
## Your Subscription Details

- **Plan**: {{ $plan->name }}
- **Price**: ${{ number_format($subscription->amount, 2) }}
@if($subscription->discount_amount > 0)
- **Original Price**: ${{ number_format($plan->price, 2) }}
- **Discount Applied**: {{ $subscription->discount_percentage }}% (${!! number_format($subscription->discount_amount, 2) !!} saved!)
@endif
- **Billing Cycle**: {{ ucfirst($plan->billing_cycle) }}
- **Start Date**: {{ $subscription->starts_at->format('M d, Y') }}
- **Next Billing Date**: {{ $subscription->ends_at->format('M d, Y') }}
@if($subscription->trial_ends_at)
- **Trial Period**: Until {{ $subscription->trial_ends_at->format('M d, Y') }}
@endif
@endcomponent

## What's Included in Your Plan

@if($plan->features['access_fitlive'] ?? false)
✅ **FitLive Sessions** - Join live fitness classes with expert instructors
@endif

@if($plan->features['access_fitnews'] ?? false)
✅ **FitNews** - Stay updated with the latest fitness news and trends
@endif

@if($plan->features['access_fitinsight'] ?? false)
✅ **FitInsight Blog** - Access expert articles and fitness tips
@endif

@if($plan->features['access_fitguide'] ?? false)
✅ **FitGuide Workouts** - Comprehensive workout programs and guides
@endif

@if($plan->features['access_fitdoc'] ?? false)
✅ **FitDoc Documentaries** - Inspiring fitness and health documentaries
@endif

@if($plan->features['offline_downloads'] ?? false)
✅ **Offline Downloads** - Download content for offline viewing
@endif

@if($plan->features['priority_support'] ?? false)
✅ **Priority Support** - Get help faster with our premium support
@endif

## Get Started

Ready to begin your fitness journey? Access all your content right away:

@component('mail::button', ['url' => $dashboardUrl])
Go to Dashboard
@endcomponent

## Need Help?

If you have any questions or need assistance, our support team is here to help:
- Email: support@fittelly.com
- Help Center: [help.fittelly.com](https://help.fittelly.com)

## Invite Friends & Earn Rewards! 🎁

Did you know you can earn discounts by inviting friends? Share your referral code and both you and your friends save money:

**Your Referral Code**: `{{ $user->getOrCreateReferralCode()->code }}`

Share this link: [{{ config('app.url') }}/register?ref={{ $user->getOrCreateReferralCode()->code }}]({{ config('app.url') }}/register?ref={{ $user->getOrCreateReferralCode()->code }})

---

Thank you for choosing Fittelly. We're excited to be part of your fitness journey!

Best regards,<br>
The Fittelly Team

@component('mail::subcopy')
If you're having trouble clicking the "Go to Dashboard" button, copy and paste the URL below into your web browser: [{{ $dashboardUrl }}]({{ $dashboardUrl }})
@endcomponent
@endcomponent 