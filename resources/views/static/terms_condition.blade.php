@extends('layouts.public')

@section('title', 'Terms and Conditions')

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
        <h2>Terms and Conditions</h2>
        <div class="breadcrumb-custom mt-3">
            <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
            <span style="color: orange;"> > Terms and Conditions</span>
        </div>
    </div>

    <div class="container py-5">
        <div class="section-card">
            <h5>Terms and Conditions – Last Updated: July 2025</h5>
            <p>Welcome to Fittelly ("we," "our," or "us"), an OTT platform owned by Fittelly Private Limited, headquartered
                in Mumbai, India. By accessing our platform, you agree to these Terms and Conditions.</p>
        </div>

        <div class="section-card">
            <h5>1. Eligibility</h5>
            <p>You must be at least 18 years old or have permission from a legal guardian to use our platform.</p>
        </div>

        <div class="section-card">
            <h5>2. Account Registration</h5>
            <p>Some features require account creation. You are responsible for your account and must notify us immediately
                of unauthorized access.</p>
        </div>

        <div class="section-card">
            <h5>3. Subscription and Billing</h5>
            <p>Subscriptions are billed in advance and non-refundable unless otherwise stated in our <a
                    href="#refund-policy" style="color: orange;">Refund Policy</a>.</p>
        </div>

        <div class="section-card">
            <h5>4. Content</h5>
            <p><strong>a. Platform Content:</strong> Owned/licensed by Fittelly. Unauthorized use is prohibited.</p>
            <p><strong>b. User-Generated Content:</strong> By posting content, you grant Fittelly rights to use it for
                service, marketing, and moderation purposes.</p>
        </div>

        <div class="section-card">
            <h5>5. Community Guidelines</h5>
            <ul>
                <li><strong>a. Respectful Interaction:</strong> No harassment or abuse.</li>
                <li><strong>b. Prohibited Content:</strong> No offensive, harmful, or illegal content.</li>
                <li><strong>c. Privacy Consideration:</strong> Avoid sharing sensitive personal information.</li>
                <li><strong>d. Reporting:</strong> Report violations using our tools.</li>
                <li><strong>e. No Spam or Unauthorized Advertising:</strong> Strictly prohibited.</li>
            </ul>
        </div>

        <div class="section-card">
            <h5>6. Health Disclaimer</h5>
            <p>All content is informational and not a substitute for professional advice. Consult a qualified professional
                before starting fitness or dietary routines.</p>
        </div>

        <div class="section-card">
            <h5>7. Compliance with Local Laws</h5>
            <p>You must comply with all applicable local laws when using the platform.</p>
        </div>

        <div class="section-card">
            <h5>8. Contact Us</h5>
            <p>Email: <a href="mailto:support@fittelly.com" style="color: orange;">support@fittelly.com</a></p>
            <p>Phone: +919920888443</p>
        </div>
    </div>
@endsection