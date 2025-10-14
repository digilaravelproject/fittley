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

        h2 {
            color: #f7a31a;
            /* Accent color for headings */
            font-size: 24px;
            margin-bottom: 15px;
        }

        .content {
            font-size: 16px;
            color: #d0d0d0;
            /* Lighter gray text for content */
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
        <h2>Password Reset Request</h2>
        <p class="content">Hello {{ $user->name ?? $user->email }},</p>

        <p class="content">
            We received a request to reset your password. Click the button below to reset your password. This link will
            expire shortly, so please act quickly.
        </p>

        <!-- Call to Action Button -->
        <a href="{{ url('password/reset', $token) }}" class="cta-button">Reset Password</a>

        <p class="content" style="color:#bdbdbd;">
            If you didn't request this, you can safely ignore this email. Your password won't be changed.
        </p>

        <!-- Footer -->
        <div class="footer">
            <p>For assistance, please contact us at <a href="mailto:support@fittelly.com">support@fittelly.com</a></p>
            <p>© {{ date('Y') }} Fittelly, All Rights Reserved</p>
        </div>
    </div>

</body>

</html>