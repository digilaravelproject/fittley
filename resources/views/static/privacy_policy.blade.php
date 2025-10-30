@extends('layouts.public')

@section('title', 'Privacy Policy')

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
        <h2>Privacy Policy</h2>
        <div class="breadcrumb-custom mt-3">
            <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
            <span style="color: orange;"> > Privacy Policy</span>
        </div>
    </div>

    <div class="container py-5">
        {{-- Copyright & Legal Notices --}}
        <div class="section-card">
            <h5>1. Copyright Notice</h5>
            <p>© 2024. Fittelly Private Limited. All rights reserved.</p>
            <p>The content, features, and functionality on the Fittelly platform, including user-generated content, are the
                exclusive property of Fittelly Private Limited or its licensors and protected by IP laws. Unauthorized use
                is prohibited.</p>
            <p>Contact: <a href="mailto:fittelly24@gmail.com" style="color: orange;">fittelly24@gmail.com</a></p>
        </div>

        <div class="section-card">
            <h5>2. Trademark Notice</h5>
            <p>Trademarks and logos on Fittelly are owned by Fittelly Private Limited or third parties. No rights to use
                them are granted without permission.</p>
        </div>

        <div class="section-card">
            <h5>3. Disclaimer & Limitation of Liability</h5>
            <p>All information is for general purposes only. Fittelly Private Limited shall not be liable for any damages
                arising from platform use.</p>
        </div>

        <div class="section-card">
            <h5>4. Indemnification</h5>
            <p>You agree to indemnify Fittelly Private Limited and affiliates for any claims arising from your platform use.
            </p>
        </div>

        <div class="section-card">
            <h5>5. Governing Law & Jurisdiction</h5>
            <p>All disputes shall be governed by Indian law, with courts in Mumbai having exclusive jurisdiction.</p>
        </div>

        {{-- Cookie Preferences --}}
        <div class="section-card">
            <h5>Cookie Preferences</h5>
            <p>We use cookies and similar technologies to enhance your experience, analyze usage, and support community
                interactions.</p>
        </div>

        <div class="section-card">
            <h5>Types of Cookies</h5>
            <ul>
                <li><strong>Essential:</strong> Required for operation.</li>
                <li><strong>Performance:</strong> Track usage and fix issues.</li>
                <li><strong>Functional:</strong> Remember preferences and login info.</li>
                <li><strong>Targeting:</strong> Deliver ads and measure campaigns.</li>
            </ul>
        </div>

        <div class="section-card">
            <h5>Managing Cookies</h5>
            <p>Manage preferences via your browser. Disabling may impact experience.</p>
            <p>Third-party cookies may be used for analytics and advertising.</p>
        </div>

        {{-- Privacy Policy Details --}}
        <div class="section-card">
            <h5>Privacy Policy – Last Updated: July 2025</h5>
            <p>Fittelly Private Limited values your privacy and is committed to protecting your personal data.</p>
        </div>

        <div class="section-card">
            <h5>Information We Collect</h5>
            <ul>
                <li>Personal Info: Name, email, phone, payments.</li>
                <li>Usage Data: IP, device info, pages visited, interactions.</li>
                <li>Community Content: Photos, comments, public posts.</li>
                <li>Cookies: For tracking and personalization.</li>
            </ul>
        </div>

        <div class="section-card">
            <h5>How We Use Your Information</h5>
            <ul>
                <li>Manage account and provide services</li>
                <li>Enhance community features</li>
                <li>Personalized content recommendations</li>
                <li>Marketing & promotions</li>
                <li>Analytics and optimization</li>
                <li>Legal compliance</li>
            </ul>
        </div>

        <div class="section-card">
            <h5>Sharing & Security</h5>
            <ul>
                <li>With service providers</li>
                <li>Public community content</li>
                <li>Legal obligations</li>
                <li>Business acquisitions or transfers</li>
            </ul>
            <p>We implement safeguards, but no system is 100% secure. Protect your credentials.</p>
        </div>

        <div class="section-card">
            <h5>Your Rights & Community Privacy</h5>
            <ul>
                <li>Access, correct, or delete data</li>
                <li>Object to marketing processing</li>
                <li>Request data portability</li>
            </ul>
            <p>Community content may be visible publicly. Moderation may take time; we cannot guarantee instant removals.
            </p>
        </div>

        <div class="section-card">
            <h5>Policy Updates & Contact</h5>
            <p>This Privacy Policy may be updated. Continued use confirms acceptance.</p>
            <p>Email: <a href="mailto:support@fittelly.com" style="color: orange;">support@fittelly.com</a></p>
            <p>Phone: +919920888443</p>
        </div>
    </div>
@endsection