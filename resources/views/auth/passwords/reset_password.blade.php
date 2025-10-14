@extends('layouts.public')
@section('title', 'FITTELLY - Reset Password')

@push('styles')
    <!-- Add custom styles for password validation and form layout -->
    <style>
        .forgot-password-card {
            max-width: 400px;
            margin: auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            border-radius: 20px;
        }

        .error-message,
        .success-message {
            display: none;
            padding: 10px;
            margin-top: 15px;
            border-radius: 4px;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
        }

        .password-strength {
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .password-strength .valid {
            color: green;
        }

        .password-strength .invalid {
            color: red;
        }

        .btn-disabled {
            cursor: not-allowed;
        }

        .sending {
            pointer-events: none;
            background-color: #007bff;
            color: #fff;
        }
    </style>
@endpush

@section('content')
    <!-- Reset Password Page -->
    <div class="container mt-5">
        <div class="forgot-password-card">
            <h3 class="text-center mb-4">Reset Your Password</h3>

            <!-- Error and Success Messages -->
            <div id="error-message" class="error-message text-center"></div>
            <div id="success-message" class="success-message text-center"></div>

            <form id="reset-password-form">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ request()->query('email') }}">

                <!-- New Password Field -->
                <div class="mb-3">
                    <label for="new-password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="new-password" name="new_password" required>
                    <div class="password-strength">
                        <div id="length" class="invalid">At least 8 characters</div>
                        <div id="uppercase" class="invalid">At least one uppercase letter</div>
                        <div id="lowercase" class="invalid">At least one lowercase letter</div>
                        <div id="number" class="invalid">At least one number</div>
                        <div id="special" class="invalid">At least one special character</div>
                    </div>
                </div>

                <!-- Confirm Password Field -->
                <div class="mb-3">
                    <label for="confirm-password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm-password" name="confirm_password" required>
                    <div id="matchCheck" class="text-danger"></div>
                </div>

                <button type="submit" id="submit-btn" class="btn btn-primary w-100">Reset Password</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Function to validate password strength
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

            // Check if passwords match
            function checkMatch() {
                const password = $("#new-password").val();
                const confirmPassword = $("#confirm-password").val();

                if (!confirmPassword) {
                    $("#matchCheck").text('');
                    return;
                }

                if (password === confirmPassword) {
                    $("#matchCheck").text('Passwords match ✅').removeClass('text-danger').addClass('text-success');
                } else {
                    $("#matchCheck").text('Passwords do not match ❌').removeClass('text-success').addClass('text-danger');
                }
            }

            // Password input field listener
            $("#new-password").on("input", function () {
                const password = $(this).val();
                validatePassword(password);
                checkMatch();
            });

            // Confirm password field listener
            $("#confirm-password").on("input", function () {
                checkMatch();
            });

            // Handle form submission
            $('#reset-password-form').on('submit', function (e) {
                e.preventDefault();

                let token = $("input[name='token']").val();
                let email = $("input[name='email']").val();
                let newPassword = $('#new-password').val();
                let confirmPassword = $('#confirm-password').val();

                // Clear previous messages
                $('#error-message').hide();
                $('#success-message').hide();

                // Check password validity and matching
                if (!validatePassword(newPassword)) {
                    $('#error-message').text('Please enter a valid password.').show();
                    return;
                }

                if (newPassword !== confirmPassword) {
                    $('#error-message').text('Passwords do not match!').show();
                    return;
                }

                // Disable button and show "Processing..."
                let $submitButton = $('#submit-btn');
                $submitButton.prop('disabled', true).text('Processing...').addClass('sending');

                $.ajax({
                    url: "{{ route('password.update') }}", // Laravel route for password reset
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        token: token,
                        email: email, // Pass email here
                        password: newPassword,
                        password_confirmation: confirmPassword
                    },
                    success: function (response) {
                        if (response.success) {
                            $('#success-message').text('Password reset successfully! You are now logged in.').show();
                            setTimeout(function () {
                                window.location.href = '{{ route('login') }}'; // Redirect to login page
                            }, 3000);
                        } else {
                            $('#error-message').text(response.message || 'Something went wrong, please try again.').show();
                        }
                    },
                    error: function (xhr, status, error) {
                        try {
                            let response = JSON.parse(xhr.responseText); // Attempt to parse response text
                            $('#error-message').text(response.message || 'An error occurred, please try again later.').show();
                        } catch (e) {
                            $('#error-message').text('An unexpected error occurred. Please try again later.').show();
                        }
                    },
                    complete: function () {
                        $submitButton.prop('disabled', false).text('Reset Password').removeClass('sending');
                    }
                });
            });
        });
    </script>
@endpush