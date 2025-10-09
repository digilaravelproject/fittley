<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - fitlley</title>
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
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: rgba(26, 26, 26, 0.9);
            border: 1px solid #333;
            border-radius: 15px;
            padding: 2rem;
            width: 100%;
            max-width: 400px;
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
    <div class="login-container">
        <div class="login-card">
            <div class="brand-logo">
                <img src="<?php echo e(asset('storage/app/public/logos/app_logo.png')); ?>" alt="fitlley Logo" style="max-width: 150px;">
                <p class="text-muted">Welcome back! Please sign in to your account.</p>
            </div>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>
                
                <div class="mb-3">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope"></i> Email Address
                    </label>
                    <input type="email" 
                           class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="email" 
                           name="email" 
                           value="<?php echo e(old('email')); ?>" 
                           required 
                           autofocus
                           placeholder="Enter your email">
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <input type="password" 
                           class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="password" 
                           name="password" 
                           required
                           placeholder="Enter your password">
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">
                        Remember me
                    </label>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>

                <div class="text-center">
                    <p class="mb-0">Don't have an account? 
                        <a href="<?php echo e(route('register')); ?>">Sign up here</a>
                    </p>
                </div>
            </form>

            <hr class="my-4 border-secondary">
            
            <div class="text-center d-none">
                <small class="text-muted">
                    <strong>Demo Credentials:</strong><br>
                        Admin: admin@fitlley.com / admin123<br>
                        User: user@fitlley.com / user123
                </small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> <?php /**PATH /home/u945294333/domains/fittelly.com/public_html/resources/views/auth/login.blade.php ENDPATH**/ ?>