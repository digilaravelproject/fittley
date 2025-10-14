<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background: #0b0b0b;
            /* Dark background */
            color: #fff;
            /* Light text */
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 680px;
            margin: 24px auto;
            background: #111;
            /* Slightly lighter dark background for the container */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
            /* Soft shadow for depth */
        }

        .header-logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .header-logo img {
            max-width: 180px;
            /* Ensure the logo is well-sized */
            margin-bottom: 20px;
        }

        h2 {
            color: #f7a31a;
            /* Accent color for headings */
            font-size: 24px;
            margin-bottom: 15px;
        }

        .content {
            font-size: 16px;
            color: #d0d0d0;
            /* Lighter text for readability */
            line-height: 1.5;
        }

        .cta-button {
            display: inline-block;
            padding: 12px 18px;
            background-color: #f7a31a;
            color: #000;
            border-radius: 6px;
            text-decoration: none;
            font-size: 16px;
            margin-top: 20px;
        }

        .cta-button:hover {
            background-color: #e68917;
            /* Darker shade on hover */
        }

        .footer {
            font-size: 12px;
            color: #bbb;
            text-align: center;
            margin-top: 30px;
        }

        .footer a {
            color: #f7a31a;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- Logo Section -->
        <div class="header-logo">
            <!-- Replace this with your actual logo path -->
            <img src="{{ getImagePath('logos/app_logo.png') }}" alt="Fittelly Logo">
        </div>

        <!-- Main Content -->
        <h2>Subscription Expired</h2>
        <p class="content">Hi {{ $subscription->user->name ?? $subscription->user->email }},</p>

        <p class="content">
            Your subscription to <strong>{{ optional($subscription->subscriptionPlan)->name }}</strong> has expired on
            <strong>{{ $subscription->ends_at ? $subscription->ends_at->toDayDateTimeString() : '—' }}</strong>.
        </p>

        <p class="content">
            We would love to have you back! To continue enjoying all of our premium features, please consider
            subscribing again.
        </p>

        <!-- Call to Action Button -->
        <a href="{{ url('/subscription/plans') }}" class="cta-button">Subscribe Again</a>

        <!-- Footer -->
        <div class="footer">
            <p>If you have any questions, feel free to reach out to us at <a
                    href="mailto:support@fittelly.com">support@fittelly.com</a>.</p>
            <p>© {{ date('Y') }} Fittelly, All Rights Reserved</p>
        </div>
    </div>

</body>

</html>