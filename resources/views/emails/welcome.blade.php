<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #121212;
            /* Dark background */
            color: #e0e0e0;
            /* Light text color for readability */
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 680px;
            margin: 0 auto;
            background: #1e1e1e;
            /* Slightly lighter dark background */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        h1 {
            color: #f7a31a;
            /* Accent color for headings */
            font-size: 26px;
            margin-bottom: 10px;
        }

        .intro-text {
            font-size: 16px;
            color: #d0d0d0;
            /* Lighter text for better contrast */
        }

        .btn {
            background-color: #f7a31a;
            /* Button color */
            color: white;
            padding: 12px 25px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            display: inline-block;
            margin-top: 20px;
        }

        .footer {
            font-size: 12px;
            color: #b0b0b0;
            text-align: center;
            margin-top: 30px;
        }

        .footer a {
            color: #f7a31a;
            text-decoration: none;
        }

        .header-logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .header-logo img {
            max-width: 150px;
        }

        .contact-info {
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header-logo">
            <!-- Replace this URL with your actual logo -->
            <img src="{{ getImagePath('logos/app_logo.png') }}" alt="Fittelly Logo">
        </div>

        <h1>Welcome, {{ $user->name ?? 'User' }}!</h1>

        <p class="intro-text">
            Thanks for joining Fittelly! We’re thrilled to have you with us. You can start exploring live sessions,
            reading helpful guides, and setting your goals right away.
        </p>

        <p class="intro-text">
            Feel free to dive in and make the most of your Fittelly experience!
        </p>

        <a href="{{ url('/dashboard') }}" class="btn">Get Started</a>

        <div class="contact-info">
            <p class="footer">If you have any questions, don't hesitate to contact us at <a
                    href="mailto:support@fittelly.com">support@fittelly.com</a></p>
        </div>

        <div class="footer">
            <p>— The Fittelly Team</p>
            <p>© {{ date('Y') }} Fittelly, All Rights Reserved</p>
        </div>
    </div>
</body>

</html>