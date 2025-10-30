@extends('layouts.public')

@section('title', 'Refund Policy')

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
        <h2>Refund Policy</h2>
        <div class="breadcrumb-custom mt-3">
            <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
            <span style="color: orange;"> > Refund Policy</span>
        </div>
    </div>

    <div class="container py-5">
        {{-- Refund Policy Sections --}}
        <div class="section-card">
            <h5>Refund Policy – Last Updated: July 2025</h5>
            <p>At Fittelly, we aim to provide high-quality content and services. This policy outlines circumstances under
                which refunds may be issued for paid subscriptions or purchases.</p>
        </div>

        <div class="section-card">
            <h5>1. Subscription Fees</h5>
            <p>Subscription fees are billed in advance and are generally non-refundable, except as required by law or
                described in this policy.</p>
        </div>

        <div class="section-card">
            <h5>2. Refund Eligibility</h5>
            <ul>
                <li><strong>Technical Issues:</strong> If significant technical issues prevent access and cannot be resolved
                    promptly by support.</li>
                <li><strong>Accidental Purchases:</strong> Contact us within 48 hours for evaluation.</li>
                <li><strong>Content or Feature Unavailability:</strong> If key services are unavailable for an extended
                    period.</li>
            </ul>
        </div>

        <div class="section-card">
            <h5>3. Non-Refundable Situations</h5>
            <ul>
                <li><strong>Change of Mind</strong></li>
                <li><strong>Partial Usage:</strong> No prorated refunds for early cancellations.</li>
                <li><strong>Community Violations:</strong> Accounts terminated or suspended are non-refundable.</li>
            </ul>
        </div>

        <div class="section-card">
            <h5>4. How to Request a Refund</h5>
            <p>Contact: <a href="mailto:fittelly24@gmail.com" style="color: orange;">fittelly24@gmail.com</a></p>
            <ul>
                <li>Full name and account details</li>
                <li>Reason for refund request</li>
                <li>Any supporting evidence or documentation</li>
            </ul>
            <p>We will respond within 3 business days. Refunds are at our sole discretion.</p>
        </div>

        <div class="section-card">
            <h5>5. Refund Process</h5>
            <p>If approved, refunds are processed to the original payment method within 7 business days. Timing may vary
                depending on your payment provider.</p>
        </div>

        <div class="section-card">
            <h5>6. Policy Updates</h5>
            <p>This policy may be updated. Continued use of the platform after updates implies acceptance.</p>
        </div>

        <div class="section-card">
            <h5>7. Contact Us</h5>
            <p>Email: <a href="mailto:support@fittelly.com" style="color: orange;">support@fittelly.com</a></p>
            <p>Phone: +919920888443</p>
        </div>
    </div>
@endsection