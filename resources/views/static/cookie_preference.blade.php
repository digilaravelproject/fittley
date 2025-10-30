@extends('layouts.public')

@section('title', 'Cookie Preference')

@section('content')
    <style>
        .page-header {
            background: linear-gradient(135deg, #141E30, #243B55);
            color: white;
            text-align: center;
            padding: 100px 20px 80px;
        }

        .page-header h2 {
            font-weight: 700;
            font-size: 2.5rem;
        }

        .breadcrumb-custom a {
            color: #f0f0f0;
            text-decoration: none;
            transition: 0.3s;
        }

        .breadcrumb-custom a:hover {
            color: orange;
        }

        .section-card {
            background-color: var(--dark-color);
            color: #ddd;
            padding: 50px 35px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            margin-bottom: 40px;
            transition: transform 0.3s ease;
        }

        .section-card:hover {
            transform: translateY(-5px);
        }

        .section-card h5 {
            color: orange;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .section-card p,
        .section-card li {
            line-height: 1.7;
            font-size: 0.95rem;
        }

        .section-card ul {
            padding-left: 20px;
        }

        body {
            background-color: #0b0b14;
        }
    </style>

    <div class="page-header">
        <h2>Cookie Preference</h2>
        <div class="breadcrumb-custom mt-3">
            <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
            <span style="color: orange;"> > Cookie Preference</span>
        </div>
    </div>

    <div class="container py-5">
        {{-- Cookie Preference Sections --}}
        <div class="section-card">
            <h5>1. Introduction</h5>
            <p>
                At Fittelly, we use cookies and similar tracking technologies to enhance your experience on our platform,
                analyze usage, provide personalized content, and support community interactions. This notice explains what
                cookies are, how we use them, and how you can manage your settings.
            </p>
        </div>

        <div class="section-card">
            <h5>2. What Are Cookies?</h5>
            <p>
                Cookies are small text files placed on your device by a web server when you visit a website. They help us
                remember preferences, improve performance, and facilitate your participation in community activities.
            </p>
        </div>

        <div class="section-card">
            <h5>3. Types of Cookies We Use</h5>
            <ul>
                <li><strong>Essential Cookies:</strong> Necessary for the platform to function, enable navigation, and
                    secure login.</li>
                <li><strong>Performance Cookies:</strong> Track usage to improve performance and fix issues.</li>
                <li><strong>Functional Cookies:</strong> Remember preferences like language and login details.</li>
                <li><strong>Targeting Cookies:</strong> Deliver relevant ads and measure campaign effectiveness.</li>
            </ul>
        </div>

        <div class="section-card">
            <h5>4. How We Use Cookies</h5>
            <ul>
                <li>Improve platform and community feature performance</li>
                <li>Personalize content and recommend relevant posts or challenges</li>
                <li>Analyze usage trends and interactions</li>
                <li>Serve relevant ads and track performance</li>
            </ul>
        </div>

        <div class="section-card">
            <h5>5. Managing Your Cookie Preferences</h5>
            <p>
                You can manage cookie preferences through your browser settings. Most browsers allow you to refuse, accept,
                or delete cookies. Disabling cookies may reduce platform functionality, including community features.
            </p>
        </div>

        <div class="section-card">
            <h5>6. Third-Party Cookies</h5>
            <p>
                We may use third-party cookies from trusted partners to analyze usage, deliver ads, and improve services.
                Please review their privacy policies for details.
            </p>
        </div>

        <div class="section-card">
            <h5>7. Changes to Cookie Preferences</h5>
            <p>
                We may update our Cookie Preferences notice from time to time. Any changes will be posted on this page.
                Continued use of the platform indicates acceptance of updates.
            </p>
        </div>

        <div class="section-card">
            <h5>8. Contact Us</h5>
            <ul>
                <li><strong>Email:</strong> <a href="mailto:support@fittelly.com"
                        style="color: orange;">support@fittelly.com</a></li>
                <li><strong>Phone:</strong> +919920888443</li>
            </ul>
        </div>
    </div>
@endsection