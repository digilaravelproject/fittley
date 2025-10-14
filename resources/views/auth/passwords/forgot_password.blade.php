@extends('layouts.public')
@section('title', 'FITTELLY - Forget Password')

@push('styles')
    <!-- Optional custom styles for the card and form -->
    <style>
        .forgot-password-card {
            max-width: 400px;
            margin: auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .forgot-password-card .form-control {
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
    <!-- Forgot Password Page -->
    <div class="container mt-5">
        <div class="forgot-password-card">
            <h3 class="text-center mb-4">Reset Your Password</h3>

            <!-- Error and Success Messages -->
            <div id="error-message" class="error-message text-center"></div>
            <div id="success-message" class="success-message text-center"></div>

            <form id="forgot-password-form">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Enter your email address</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="Email">
                    <div id="email-error" class="text-danger d-none">Email not found!</div>
                </div>

                <button type="submit" id="submit-btn" class="btn btn-primary w-100">Send Password Reset Link</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Handle Forgot Password form submission
        $('#forgot-password-form').on('submit', function (e) {
            e.preventDefault();

            let email = $('#email').val();
            let $submitButton = $('#submit-btn');

            // Clear previous messages
            $('#error-message').hide();
            $('#success-message').hide();
            $('#email-error').addClass('d-none');

            // Disable the submit button and show 'Sending...' message
            $submitButton.prop('disabled', true).text('Sending...').addClass('sending');

            try {
                // Validate email format before making the request
                if (!email || !/\S+@\S+\.\S+/.test(email)) {
                    $('#error-message').text('Please enter a valid email address.').show();
                    $submitButton.prop('disabled', false).text('Send Password Reset Link').removeClass('sending');
                    return;
                }

                $.ajax({
                    url: "{{ route('password.email') }}", // Laravel password reset route
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        email: email
                    },
                    success: function (response) {
                        // On success
                        if (response.success) {
                            $('#success-message').text('Check your email for the password reset link.').show();
                        } else {
                            // Show error message if email is not found
                            $('#email-error').removeClass('d-none');
                        }
                    },
                    error: function (xhr, status, error) {
                        // On failure, handle various error scenarios
                        try {
                            let response = JSON.parse(xhr.responseText); // Try to parse error response
                            $('#error-message').text(response.message || 'An error occurred, please try again later.').show();
                        } catch (e) {
                            $('#error-message').text('An unexpected error occurred. Please try again later.').show();
                        }
                    },
                    complete: function () {
                        // Re-enable the submit button after the request completes
                        $submitButton.prop('disabled', false).text('Send Password Reset Link').removeClass('sending');
                    }
                });
            } catch (error) {
                // Handle unexpected errors
                console.error('Error during password reset request:', error);
                $('#error-message').text('An error occurred. Please try again later.').show();
                $submitButton.prop('disabled', false).text('Send Password Reset Link').removeClass('sending');
            }
        });
    </script>
@endpush