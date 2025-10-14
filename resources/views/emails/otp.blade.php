<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background: #0b0b0b;
            color: #fff;
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 680px;
            margin: 24px auto;
            background: #111;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
        }

        .header-logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .header-logo img {
            max-width: 160px;
            margin-bottom: 10px;
        }

        h2 {
            color: #f7a31a;
            font-size: 24px;
            margin-bottom: 15px;
            text-align: center;
        }

        .content {
            font-size: 16px;
            color: #d0d0d0;
            line-height: 1.6;
            text-align: center;
        }

        .otp-code {
            font-size: 28px;
            font-weight: bold;
            color: #f7a31a;
            letter-spacing: 4px;
            margin: 20px 0;
            display: inline-block;
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
            <img src="{{ getImagePath('logos/app_logo.png') }}" alt="Fittelly Logo">
        </div>

        <!-- OTP Message -->
        <h2>Email Verification Code</h2>
        <p class="content">
            Hello {{ $user->name ?? $user->email }},<br>
            Please use the following One-Time Password (OTP) to verify your email address:
        </p>

        <!-- OTP Code -->
        <div class="otp-code">{{ $otp }}</div>

        <p class="content">
            This OTP is valid for <strong>5 minutes</strong>. Do not share it with anyone.
        </p>

        <div class="footer">
            <p>Need help? Contact us at <a href="mailto:support@fittelly.com">support@fittelly.com</a></p>
            <p>© {{ date('Y') }} Fittelly, All Rights Reserved</p>
        </div>
    </div>

</body>

</html>