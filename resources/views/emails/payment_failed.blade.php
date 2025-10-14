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
            /* Light text for contrast */
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 680px;
            margin: 24px auto;
            background: #111;
            /* Slightly lighter background for the container */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
            /* Soft shadow for depth */
        }

        h2 {
            color: #e34b4b;
            /* Red color for error/alert */
            font-size: 24px;
            margin-bottom: 15px;
        }

        .content {
            font-size: 16px;
            color: #d0d0d0;
            /* Light gray text for content */
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
        <!-- Main Content -->
        <h2>Payment Failed</h2>
        <p class="content">Hi {{ $user->name ?? $user->email }},</p>

        <p class="content">
            We couldn’t process your payment. @if($reason) <strong>Reason:</strong> {{ $reason }} @endif
        </p>

        <p class="content">
            Please try again or <a href="mailto:support@fittelly.com"
                style="color:#f7a31a; text-decoration: none;">contact support</a> if you need assistance.
        </p>

        <!-- Call to Action Button -->
        <a href="{{ url('/payment/retry') }}" class="cta-button">Try Again</a>

        <!-- Footer -->
        <div class="footer">
            <p>© {{ date('Y') }} Fittelly, All Rights Reserved</p>
        </div>
    </div>

</body>

</html>