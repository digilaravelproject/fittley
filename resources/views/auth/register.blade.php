<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - fitlley</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }

        .register-card {
            background: rgba(26, 26, 26, 0.9);
            border: 1px solid #333;
            border-radius: 15px;
            padding: 2rem;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
        }

        .brand-logo {
            text-align: center;
            margin-bottom: 2rem;
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
            background: var(--bg-dark);
            border-color: var(--primary-color);
            color: white;
            box-shadow: 0 0 0 0.2rem rgba(247, 163, 26, 0.25);
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
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-card">
            <div class="brand-logo">
                <img src="{{ asset('storage/app/public/logos/app_logo.png') }}" alt="fitlley Logo" style="max-width: 150px;">
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
                    <label for="name" class="form-label">
                        <i class="fas fa-user"></i> Full Name
                    </label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name') }}" required autofocus
                        placeholder="Enter your full name">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope"></i> Email Address
                    </label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email') }}" required placeholder="Enter your email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" required placeholder="Enter your password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">
                        <i class="fas fa-lock"></i> Confirm Password
                    </label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                        required placeholder="Confirm your password">
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">
                    <i class="fas fa-user-plus"></i> Create Account
                </button>

                <div class="text-center">
                    <p class="mb-0">Already have an account?
                        <a href="{{ route('login') }}">Sign in here</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
