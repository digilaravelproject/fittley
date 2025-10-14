@extends('layouts.public')

@section('title', 'Choose Your Plan')

@section('content')
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
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        /* Hover only for enabled cards */
        .plan-card.enabled:hover {
            background-color: var(--bg-hover);
            transform: translateY(-6px);
        }

        .plan-card.disabled-card {
            background: #151515;
            border-color: #232323;
            opacity: 0.72;
            pointer-events: none;
            transform: none !important;
            box-shadow: none;
        }

        .plan-card .plan-body {
            flex: 1 1 auto;
        }

        .plan-card .plan-footer {
            margin-top: 14px;
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

        .btn-primary {
            background-color: var(--primary-dark);
            border: none;
        }

        .btn-primary:hover {
            background-color: var(--primary-light);
            color: var(--bg-primary);
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        .disabled-btn {
            background: #242424 !important;
            color: #8a8a8a !important;
            border: 1px solid #2b2b2b !important;
            cursor: not-allowed;
            opacity: .9;
        }

        .current-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: var(--success);
            color: #000;
            padding: 6px 8px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.8rem;
        }

        /* small screens tweak */
        @media (max-width: 780px) {
            .main-content {
                padding-top: 1rem;
            }
        }

        /* Referral Code Section */
        #referralCode {
            font-size: 1rem;
            padding: 0.75rem;
            max-width: 250px;
            border-radius: 8px;
        }

        #referralCode:focus {
            border-color: var(--primary-dark);
            box-shadow: 0 0 5px rgba(232, 148, 26, 0.5);
        }

        /* Referral button styling with your root color */
        .btn-referral {
            background-color: var(--primary-dark);
            color: var(--white-color);
            border: 1px solid var(--primary-dark);
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .btn-referral:hover {
            background-color: var(--primary-light);
            border-color: var(--primary-light);
            color: var(--bg-primary);
        }

        /* Make sure it fits smaller screens */
        @media (max-width: 768px) {
            #referralCode {
                max-width: 200px;
            }

            .btn-referral {
                width: 100%;
                margin-top: 10px;
            }
        }
    </style>

    <div class="container py-5">
        @if(isset($isUpgrade) && $isUpgrade)
            <div class="alert alert-info text-center">
                Select a new plan to upgrade your current subscription.
            </div>
        @endif

        <div class="text-center mb-5">
            <h1 class="fw-bold text-white">Choose Your Subscription</h1>
            <p class="text-muted">Get full access to live sessions, expert content, and more</p>
        </div>
        <!-- Referral Code -->
        <div class="mb-5 d-flex flex-column align-items-center">
            <h5 class="text-white mb-3">Have a referral code?</h5>
            <div class="d-flex flex-column flex-md-row align-items-center w-100 justify-content-center">
                <input type="text" id="referralCode"
                    class="form-control bg-transparent text-white border border-secondary rounded-3 me-md-2"
                    placeholder="Enter referral code" aria-label="Referral Code" style="max-width: 300px;">
                <button class="btn btn-referral me-md-2 mt-2 mt-md-0" onclick="applyReferral()">Apply</button>
            </div>
            <div id="referralMessage" class="text-success mt-2 small"></div>
        </div>


        <div class="row g-4">
            @foreach($plans as $plan)
                @php
                    // Determine if user has a current subscription and current plan price
                    $isCurrentPlan = false;
                    $isDisabledForUpgrade = false;
                    $isEnabledCard = true;

                    if (isset($userSubscription) && $userSubscription) {
                        // Try common relation names to fetch plan/price safely
                        $currentPlanPrice = optional(optional($userSubscription)->subscriptionPlan)->price
                            ?? optional(optional($userSubscription)->plan)->price
                            ?? ($userSubscription->amount_paid ?? null);

                        // If userSubscription includes subscription_plan_id, try fallback lookup (safe)
                        if (!isset($currentPlanPrice) && isset($userSubscription->subscription_plan_id)) {
                            try {
                                $tmpPlan = \App\Models\SubscriptionPlan::find($userSubscription->subscription_plan_id);
                                $currentPlanPrice = $tmpPlan ? $tmpPlan->price : null;
                            } catch (\Throwable $e) {
                                $currentPlanPrice = null;
                            }
                        }

                        // If current plan id matches this plan id -> current plan
                        if (isset($userSubscription->subscription_plan_id) && $userSubscription->subscription_plan_id == $plan->id) {
                            $isCurrentPlan = true;
                        } elseif (isset($userSubscription->subscription_plan_id) && $userSubscription->subscription_plan_id != $plan->id) {
                            $isCurrentPlan = false;
                        }

                        // Decide if this plan should be disabled in upgrade mode:
                        if (!empty($currentPlanPrice) && isset($isUpgrade) && $isUpgrade) {
                            // disable same or lower price plans (prevent downgrade or same plan)
                            if ($plan->price <= $currentPlanPrice) {
                                $isDisabledForUpgrade = true;
                            }
                        }
                    } else {
                        $currentPlanPrice = null;
                    }

                    // final card enabled flag
                    $isEnabledCard = !($isDisabledForUpgrade || $isCurrentPlan && isset($isUpgrade) && $isUpgrade);
                @endphp

                <div class="col-md-6 col-lg-4">
                    <div class="position-relative plan-card {{ $isEnabledCard ? 'enabled' : 'disabled-card' }}">
                        {{-- Current Plan badge --}}
                        @if(isset($userSubscription) && $isCurrentPlan)
                            <div class="current-badge">Current Plan</div>
                        @endif

                        {{-- Popular badge --}}
                        @if($plan->is_popular)
                            <div class="popular-badge">Most Popular</div>
                        @endif

                        <div class="plan-body">
                            <h4 class="fw-bold">{{ $plan->name }}</h4>
                            <p class="text-muted small">{{ $plan->description }}</p>

                            <div class="mb-3">
                                <h5 class="fw-bold">₹{{ number_format($plan->price, 0) }}
                                    <small class="text-muted">/ {{ $plan->billing_cycle }}</small>
                                </h5>
                                @if($plan->trial_days > 0)
                                    <div class="text-success small">{{ $plan->trial_days }}-day free trial</div>
                                @endif
                            </div>

                            <ul class="list-unstyled small mb-4">
                                @if($plan->features['access_fitlive'] ?? false)
                                    <li><i class="bi bi-check2-circle text-success me-2"></i> Live Fitness Sessions</li>
                                @endif

                                <li><i class="bi bi-check2-circle text-success me-2"></i>
                                    {{ $plan->features['max_devices'] ?? 1 }} Device(s)
                                </li>

                                @foreach($plan->features as $key => $feature)
                                    @if(!in_array($key, ['access_fitlive', 'max_devices']))
                                        <li><i class="bi bi-check2-circle text-success me-2"></i> {{ $feature }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>

                        <div class="plan-footer">
                            {{-- Button / Disabled logic --}}
                            @if(isset($isUpgrade) && $isUpgrade && isset($userSubscription) && $userSubscription)
                                @if($isCurrentPlan)
                                    {{-- Current plan: show disabled "Current Plan" button --}}
                                    <button class="btn btn-success w-100" disabled>Current Plan</button>

                                @elseif($isDisabledForUpgrade)
                                    {{-- Downgrade / same price: whole card already disabled; show Not Available --}}
                                    <button class="btn disabled-btn w-100" disabled>Not Available</button>

                                @else
                                    {{-- Valid upgrade: active card --}}
                                    <button class="btn btn-primary w-100"
                                        onclick="startRazorpay('{{ $plan->id }}', '{{ $plan->name }}', {{ $plan->price }})">
                                        Upgrade to {{ $plan->name }}
                                    </button>
                                @endif

                            @else
                                {{-- Normal subscribe flow (no existing plan / not in upgrade mode) --}}
                                <button class="btn btn-primary w-100"
                                    onclick="startRazorpay('{{ $plan->id }}', '{{ $plan->name }}', {{ $plan->price }})">
                                    Choose {{ $plan->name }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
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
                        if (!orderData || !orderData.order_id) {
                            console.error('Invalid order response', orderData);
                            alert("Could not initiate payment. Please try again.");
                            return;
                        }

                        const options = {
                            key: orderData.razorpay_key,
                            amount: orderData.amount,
                            currency: "INR",
                            name: "Fittelly",
                            description: "Subscription: " + planName,
                            image: "{{ getImagePath('default-profile1.png') }}",
                            order_id: orderData.order_id,
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