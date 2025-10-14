<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - fitlley</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <link rel="icon" href="{{ asset('public/favicon.ico') }}" type="image/x-icon">

    <style>
        :root {
            --primary-color: #f7a31a;
            --bg-dark: #000000;
            --bg-secondary: #1a1a1a;
        }

        body {
            background: linear-gradient(135deg, var(--bg-dark) 0%, var(--bg-secondary) 100%);
            min-height: 100vh;
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .register-container {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .register-card {
            background: rgba(26, 26, 26, 0.9);
            border: 1px solid #333;
            border-radius: 15px;
            padding: 1rem;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
        }

        .brand-logo {
            text-align: center;
            margin-bottom: 1rem;
        }

        .brand-logo h2 {
            color: var(--primary-color);
            font-weight: bold;
            margin: 0;
        }

        .form-control {
            background: var(--bg-dark);
            border: 1px solid #444;
            color: white;
            border-radius: 8px;
            padding: 0.75rem;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(247, 163, 26, 0.25);
            background: var(--bg-dark);
            color: white;
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            border-radius: 8px;
            padding: 0.75rem;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: #e8941a;
        }

        .form-label {
            color: #ccc;
            font-weight: 500;
        }

        .alert {
            border: none;
            border-radius: 8px;
        }

        .text-center a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .text-center a:hover {
            color: #e8941a;
        }

        .text-muted {
            color: rgb(118 118 118) !important;
        }

        .password-validation {
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        .password-validation li {
            list-style: none;
            margin-bottom: 5px;
        }

        .password-validation li.valid {
            color: #28a745;
        }

        .password-validation li.invalid {
            color: #dc3545;
        }

        .password-toggle {
            position: relative;
        }

        .password-toggle i {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #aaa;
        }

        /* Add padding to make room for eye icon */
        .form-control {
            padding-right: 2.5rem;
        }

        /* Proper positioning of eye icon inside input */
        .position-relative .toggle-password {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #aaa;
            z-index: 2;
            font-size: 1rem;
        }

        .form-control:disabled {
            background-color: #525456;
            opacity: 1;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-card">
            <div class="brand-logo">
                <a class="navbar-brand" href="{{ url('/') }}">

                    <img src="{{ asset('storage/app/public/logos/app_logo.png') }}" alt="fitlley Logo"
                        style="max-width: 150px;">
                </a>
                <p class="text-muted">Create your account to get started.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label"><i class="fas fa-user"></i> Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required
                        autofocus placeholder="Enter your full name">
                </div>

                <div class="mb-3 position-relative">
                    <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email Address</label>
                    <div class="input-group">
                        <input type="email" class="form-control" id="email" name="email" required
                            placeholder="Enter your email">
                        <button type="button" class="btn btn-outline-warning" id="sendOtpBtn">Send OTP</button>
                    </div>
                    <div id="emailCheck" class="small mt-1"></div>
                </div>

                <div class="mb-3" id="otpSection" style="display:none;">
                    <label for="otp" class="form-label"><i class="fas fa-key"></i> Enter OTP</label>
                    <input type="text" class="form-control" id="otp" placeholder="Enter 6-digit OTP">
                    <div id="otpFeedback" class="small mt-1"></div>
                    <div id="timer" class="text-warning small mt-1"></div>
                </div>


                <!-- Password Field -->
                <div class="mb-3">
                    <label for="password" class="form-label"><i class="fas fa-lock"></i> Password</label>
                    <div class="position-relative">
                        <input type="password" class="form-control" id="password" name="password" required
                            placeholder="Enter your password">
                        <i class="fas fa-eye-slash toggle-password" toggle="#password"></i>
                    </div>

                    <ul class="password-validation mt-2 px-2">
                        <li id="length" class="invalid">Minimum 8 characters</li>
                        <li id="uppercase" class="invalid">At least one uppercase letter</li>
                        <li id="lowercase" class="invalid">At least one lowercase letter</li>
                        <li id="number" class="invalid">At least one number</li>
                        <li id="special" class="invalid">At least one special character</li>
                    </ul>
                </div>

                <!-- Confirm Password Field -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label"><i class="fas fa-lock"></i> Confirm
                        Password</label>
                    <div class="position-relative">
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" required placeholder="Confirm your password">
                        <i class="fas fa-eye-slash toggle-password" toggle="#password_confirmation"></i>
                    </div>
                    <div id="matchCheck" class="mt-2 px-1 small text-danger"></div>
                </div>


                <button type="submit" class="btn btn-primary w-100 mb-3">
                    <i class="fas fa-user-plus"></i> Create Account
                </button>

                <div class="text-center">
                    <p class="mb-0">Already have an account? <a href="{{ route('login') }}">Sign in here</a></p>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS + jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            function validatePassword(password) {
                const validations = {
                    length: password.length >= 8,
                    uppercase: /[A-Z]/.test(password),
                    lowercase: /[a-z]/.test(password),
                    number: /[0-9]/.test(password),
                    special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
                };

                for (const [key, valid] of Object.entries(validations)) {
                    $("#" + key).toggleClass("valid", valid).toggleClass("invalid", !valid);
                }

                return Object.values(validations).every(Boolean);
            }

            $("#password").on("input", function () {
                const password = $(this).val();
                validatePassword(password);
                checkMatch();
            });

            $("#password_confirmation").on("input", function () {
                checkMatch();
            });

            function checkMatch() {
                const password = $("#password").val();
                const confirmPassword = $("#password_confirmation").val();
                if (!confirmPassword) {
                    $("#matchCheck").text('');
                    return;
                }

                if (password === confirmPassword) {
                    $("#matchCheck").text('Passwords match ✅').removeClass('text-danger').addClass('text-success');
                } else {
                    $("#matchCheck").text('Passwords do not match ❌').removeClass('text-success').addClass(
                        'text-danger');
                }
            }

            // Toggle password visibility
            $(".toggle-password").click(function () {
                const input = $($(this).attr("toggle"));
                const type = input.attr("type") === "password" ? "text" : "password";
                input.attr("type", type);
                $(this).toggleClass("fa-eye fa-eye-slash");
            });

        });

        //
        $(function () {
            let timerInterval;
            const timerDuration = 300; // 5 minutes
            let timeLeft = timerDuration;
            let emailVerified = false;

            const otpInput = $("#otp");
            const sendOtpBtn = $("#sendOtpBtn");
            const otpFeedback = $("#otpFeedback");
            const timerDisplay = $("#timer");

            // Check email existence
            $("#email").on("blur", function () {
                const email = $(this).val();
                if (!email) return;
                $.post("{{ route('check.email') }}", { email, _token: "{{ csrf_token() }}" }, function (res) {
                    if (res.exists) {
                        $("#emailCheck").text("❌ Email already exists.").removeClass("text-success").addClass("text-danger");
                        sendOtpBtn.prop("disabled", true);
                    } else {
                        $("#emailCheck").text("✅ Email available.").removeClass("text-danger").addClass("text-success");
                        sendOtpBtn.prop("disabled", false);
                    }
                });
            });

            // Send / Resend OTP
            sendOtpBtn.click(function () {
                const email = $("#email").val();
                if (!email) {
                    alert("Please enter your email first.");
                    return;
                }

                $(this).prop("disabled", true).text("Sending...");
                $.post("{{ route('send.otp') }}", { email, _token: "{{ csrf_token() }}" }, function (res) {
                    if (res.success) {
                        $("#otpSection").slideDown();
                        otpFeedback.text("OTP sent successfully!").removeClass("text-danger").addClass("text-success");

                        // ✅ Enable OTP input & reset verification
                        otpInput.prop("disabled", false).val('');
                        emailVerified = false;

                        // ✅ Restart timer
                        startTimer();
                    } else {
                        otpFeedback.text(res.message).removeClass("text-success").addClass("text-danger");
                    }
                    sendOtpBtn.prop("disabled", false).text("Resend OTP");
                });
            });

            // Verify OTP
            otpInput.on("keyup", function () {
                const otp = $(this).val();
                const email = $("#email").val();
                if (otp.length === 6) {
                    $.post("{{ route('verify.otp') }}", { email, otp, _token: "{{ csrf_token() }}" }, function (res) {
                        if (res.success) {
                            emailVerified = true;

                            otpFeedback.text("✅ OTP verified successfully!").removeClass("text-danger").addClass("text-success");

                            // ✅ Disable OTP input & stop timer
                            otpInput.prop("disabled", true);
                            clearInterval(timerInterval);
                            timerDisplay.hide();
                        } else {
                            emailVerified = false;
                            otpFeedback.text(res.message).removeClass("text-success").addClass("text-danger");
                        }
                    });
                }
            });

            // Prevent form submit if OTP not verified
            $("form").on("submit", function (e) {
                if (!emailVerified) {
                    e.preventDefault();
                    alert("Please verify your email with OTP first.");
                }
            });

            // Timer function
            function startTimer() {
                timeLeft = timerDuration;
                clearInterval(timerInterval);
                timerDisplay.show();
                timerDisplay.removeClass("text-danger");

                timerInterval = setInterval(() => {
                    if (emailVerified) {
                        clearInterval(timerInterval); // ✅ Stop timer if OTP already verified
                        return;
                    }

                    if (timeLeft <= 0) {
                        clearInterval(timerInterval);
                        timerDisplay.text("OTP expired. Please resend.").addClass("text-danger");

                        // ✅ Re-enable OTP input on expiry so user can resend
                        otpInput.prop("disabled", false);
                        emailVerified = false;
                        return;
                    }
                    const minutes = Math.floor(timeLeft / 60);
                    const seconds = timeLeft % 60;
                    timerDisplay.text(`OTP valid for ${minutes}:${seconds < 10 ? "0" : ""}${seconds}`);
                    timeLeft--;
                }, 1000);
            }
        });


    </script>
</body>

</html>