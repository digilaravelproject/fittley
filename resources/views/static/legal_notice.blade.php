@extends('layouts.public')

@section('title', 'Legal Notice')

@section('content')
    <style>
        .legal-header {
            background: linear-gradient(135deg, #141E30, #243B55);
            color: white;
            text-align: center;
            padding: 100px 20px 80px;
        }

        .legal-header h2 {
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

        .legal-section {
            background-color: var(--dark-color);
            color: #ddd;
            padding: 60px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            margin-bottom: 40px;
            transition: transform 0.3s ease;
        }

        .legal-section:hover {
            transform: translateY(-5px);
        }

        .legal-section h5 {
            color: orange;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .legal-section p {
            line-height: 1.7;
            font-size: 0.95rem;
        }

        body {
            background-color: #0b0b14;
        }
    </style>

    <div class="legal-header">
        <h2>Legal Notice</h2>
        <div class="breadcrumb-custom mt-3">
            <a href="{{ url('/') }}">
                <i class="fa fa-home"></i> Home
            </a>
            <span style="color: orange;"> > Legal Notice</span>
        </div>
    </div>

    <div class="container py-5">
        <div class="legal-section">
            <h5>1. Copyright Notice</h5>
            <p>© 2024. Fittelly Private Limited. All rights reserved.</p>
            <p>
                The content, features, and functionality on the Fittelly platform, including but not limited to text,
                graphics, logos, images, audio clips, video clips, user-generated content, and community interactions, are
                the exclusive property of Fittelly Private Limited or its licensors and are protected by copyright,
                trademark, and other intellectual property laws. Unauthorized use of any content or materials from this
                platform, including community-generated content, is prohibited.
            </p>
            <p>
                For permission requests or inquiries, please contact us at
                <a href="mailto:fittelly24@gmail.com" style="color: orange;">fittelly24@gmail.com</a>.
            </p>
        </div>

        <div class="legal-section">
            <h5>2. Trademark Notice</h5>
            <p>
                The trademarks, service marks, and logos used and displayed on the Fittelly platform are registered and
                unregistered trademarks of Fittelly Private Limited. Other company, product, and service names may be
                trademarks or service marks of their respective owners. Nothing on this platform should be construed as
                granting any license or right to use any trademark without prior written permission.
            </p>
        </div>

        <div class="legal-section">
            <h5>3. Disclaimer Notice</h5>
            <p>
                The information provided on the Fittelly platform is for general informational purposes only. While we
                strive for accuracy, we make no warranties or representations of any kind regarding reliability or
                completeness. Your use of the platform and its community features is at your own risk.
            </p>
        </div>

        <div class="legal-section">
            <h5>4. Limitation of Liability Notice</h5>
            <p>
                To the fullest extent permitted by law, Fittelly Private Limited and its affiliates shall not be liable for
                any direct, indirect, incidental, or consequential damages arising from your use of the platform or its
                content.
            </p>
        </div>

        <div class="legal-section">
            <h5>5. Indemnification Notice</h5>
            <p>
                You agree to indemnify and hold harmless Fittelly Private Limited and its affiliates from any claims,
                damages, or expenses resulting from your use of the platform or violation of these terms.
            </p>
        </div>

        <div class="legal-section">
            <h5>6. Governing Law and Jurisdiction Notice</h5>
            <p>
                These notices shall be governed by the laws of India. Any disputes shall be subject to the exclusive
                jurisdiction of courts in Mumbai, Maharashtra.
            </p>
        </div>
    </div>
@endsection