@extends('layouts.static_header')

@section('title', 'Terms and Conditions')

@section('content')
    <div class="page-header text-center py-5 mt-4" style="background-color: #1a1a1a; color: white;">
        <h2 class="mb-3">Terms and Conditions</h2>
        <div>
            <a href="{{ url('/') }}" style="color: white; text-decoration: none;">
                <i class="fa fa-home"></i> Home
            </a>
            <span style="color: orange;"> > Terms and Conditions</span>
        </div>
    </div>

    <div class="container py-5" style="background-color: #000; color: white;">
        {{-- TERMS AND CONDITIONS --}}
        <h3 class="mt-5 mb-4">Terms and Conditions</h3>
        <p><strong>Last Updated:</strong> July 2025</p>

        <h5>1. Introduction</h5>
        <p>Welcome to Fittelly ("we," "our," or "us"), the brand name of Fittelly Private Limited, headquartered in Mumbai, India. Fittelly provides an OTT platform offering access to live fitness events, shows, workouts, yoga sessions, healthy cooking recipes, and community interaction features. By accessing or using our platform, you agree to be bound by these Terms and Conditions ("Terms"). If you do not agree with any part of these Terms, please do not use our services.</p>

        <h5 class="mt-4">2. Eligibility</h5>
        <p>You must be at least 18 years old or have permission from a legal guardian. By using the platform, you confirm you meet this requirement.</p>

        <h5 class="mt-4">3. Account Registration</h5>
        <p>To access certain features, including community activities, you must create an account and are responsible for its use. Notify us immediately of unauthorized access.</p>

        <h5 class="mt-4">4. Subscription and Billing</h5>
        <p>Subscriptions are billed in advance and non-refundable unless stated in our <a href="#refund-policy" style="color: orange;">Refund Policy</a>.</p>

        <h5 class="mt-4">5. Content</h5>
        <p><strong>a. Platform Content:</strong> Owned/licensed by Fittelly. No unauthorized use allowed.</p>
        <p><strong>b. User-Generated Content:</strong> By posting, you grant us rights to use the content for service and marketing. We may moderate content.</p>

        <h5 class="mt-4">6. Community Guidelines</h5>
        <ul>
            <li><strong>a. Respectful Interaction:</strong> No harassment or abuse.</li>
            <li><strong>b. Prohibited Content:</strong> No offensive, harmful, or illegal content.</li>
            <li><strong>c. Privacy Consideration:</strong> Avoid sharing sensitive personal info.</li>
            <li><strong>d. Reporting:</strong> Report violations using our tools.</li>
            <li><strong>e. No Spam or Unauthorized Advertising:</strong> Strictly prohibited.</li>
        </ul>

        <h5 class="mt-4">7. Health Disclaimer</h5>
        <p>Content is informational and not medical advice. Always consult a professional before starting fitness or dietary routines.</p>

        <h5 class="mt-4">8. Compliance with Local Laws</h5>
        <p>You must follow local laws while using the platform, especially for content, privacy, and consumer protec
    </div>
@endsection
