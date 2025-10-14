@extends('layouts.public')

@section('title', 'Choose Your Plan')

@section('content')
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary-dark: #e8941a;
            --primary-light: #f9b847;
            --bg-primary: #0a0a0a;
            --bg-secondary: #141414;
            --bg-tertiary: #1a1a1a;
            --bg-card: #1f1f1f;
            --bg-hover: #2a2a2a;
            --text-primary: #ffffff;
            --text-secondary: #e5e5e5;
            --text-muted: #b3b3b3;
            --border-primary: #333333;
            --border-accent: #f7a31a;
            --success: #00d084;
            --error: #e50914;
            --white-color: #ffffff;
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
        }

        .plan-card {
            background-color: var(--bg-card);
            color: var(--text-primary);
            border: 1px solid var(--border-primary);
            border-radius: 12px;
            padding: 24px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .plan-card:hover {
            background-color: var(--bg-hover);
            transform: translateY(-6px);
        }

        .btn-primary {
            background-color: var(--primary-dark);
            border: none;
        }

        .btn-primary:hover {
            background-color: var(--primary-light);
            color: var(--bg-primary);
        }

        .popular-badge {
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background-color: var(--primary-dark);
            color: var(--white-color);
            padding: 4px 12px;
            font-size: 0.75rem;
            border-radius: 6px;
        }

        .dropdown-toggle::after {
            content: none;
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        @media (max-width: 780px) {
            .main-content {
                padding-top: 1rem;
            }
        }
    </style>

    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="fw-bold text-white">Choose Your Subscription</h1>
            <p class="text-muted">Get full access to live sessions, expert content, and more</p>
        </div>

        <div class="row g-4">
            @foreach($plans as $plan)
                <div class="col-md-6 col-lg-4">
                    <div class="position-relative plan-card h-100">
                        @if($plan->is_popular)
                            <div class="popular-badge">Most Popular</div>
                        @endif

                        <h4 class="fw-bold">{{ $plan->name }}</h4>
                        <p class="text-muted small">{{ $plan->description }}</p>

                        <div class="mb-3">
                            <h5 class="fw-bold">₹{{ number_format($plan->price, 0) }} <small
                                    class="text-muted">/{{ $plan->billing_cycle }}</small></h5>
                            @if($plan->trial_days > 0)
                                <div class="text-success small">{{ $plan->trial_days }}-day free trial</div>
                            @endif
                        </div>

                        <ul class="list-unstyled small mb-4">
                            @if($plan->features['access_fitlive'] ?? false)
                                <li><i class="bi bi-check2-circle text-success me-2"></i> Live Fitness Sessions</li>
                            @endif

                            <li><i class="bi bi-check2-circle text-success me-2"></i> {{ $plan->features['max_devices'] ?? 1 }}
                                Device(s)</li>

                            @foreach($plan->features as $key => $feature)
                                @if(!in_array($key, ['access_fitlive', 'max_devices']))
                                    <li><i class="bi bi-check2-circle text-success me-2"></i> {{ $feature }}</li>
                                @endif
                            @endforeach
                        </ul>

                        <button class="btn btn-primary w-100"
                            onclick="startRazorpay('{{ $plan->id }}', '{{ $plan->name }}', {{ $plan->price }})">
                            Choose {{ $plan->name }}
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Referral Code -->
        <div class="mt-5 bg-dark p-4 rounded">
            <h5>Have a referral code?</h5>
            <div class="input-group mt-2">
                <input type="text" id="referralCode" class="form-control bg-secondary text-white border-secondary"
                    placeholder="Enter referral code">
                <button class="btn btn-outline-success" onclick="applyReferral()">Apply</button>
            </div>
            <div id="referralMessage" class="text-success mt-2 small"></div>
        </div>
    </div>

    <!-- Razorpay Script -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        function applyReferral() {
            const code = document.getElementById('referralCode').value.trim();
            if (!code) {
                document.getElementById('referralMessage').innerText = 'Please enter a valid code.';
                return;
            }
            document.getElementById('referralMessage').innerText = 'Referral applied! You’ll see the discount at checkout.';
        }

        function startRazorpay(planId, planName, planPrice) {
            try {
                fetch("/razorpay/order", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        plan_id: planId,
                        referral_code: document.getElementById("referralCode").value.trim(),
                    }),
                })
                    .then(res => res.json())
                    .then(orderData => {

                        const options = {
                            key: orderData.razorpay_key,
                            amount: orderData.amount,
                            currency: "INR",
                            name: "Fittelly",
                            description: "Subscription: " + planName,
                            image: "{{ getImagePath('default-profile1.png') }}",
                            // image: "{{ asset('images/logo.png') }}",
                            order_id: orderData.order_id, // ✅ FIXED
                            handler: function (response) {
                                confirmPayment(response, planId);
                            },
                            prefill: {
                                name: "{{ auth()->user()->name }}",
                                email: "{{ auth()->user()->email }}"
                            },
                            theme: {
                                color: "#f7a31a"
                            }
                        };

                        const rzp = new Razorpay(options);
                        rzp.open();
                    })
                    .catch(err => {
                        console.error("Failed to create Razorpay order", err);
                        alert("Something went wrong while initiating payment.");
                    });

            } catch (err) {
                console.error("Razorpay JS Error:", err);
                alert("Something went wrong. Try again later.");
            }
        }

        function confirmPayment(response, planId) {
            try {
                fetch("/razorpay/confirm", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        razorpay_payment_id: response.razorpay_payment_id,
                        razorpay_order_id: response.razorpay_order_id,
                        razorpay_signature: response.razorpay_signature,
                        plan_id: planId,
                        referral_code: document.getElementById("referralCode").value.trim(),
                    }),
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = "/dashboard";
                        } else {
                            alert("Subscription failed: " + (data.message || "Please contact support."));
                        }
                    })
                    .catch(err => {
                        console.error("Subscription confirmation failed", err);
                        alert("Could not confirm subscription.");
                    });
            } catch (err) {
                console.error("Error confirming Razorpay payment:", err);
                alert("Something went wrong. Try again later.");
            }
        }
    </script>
@endsection