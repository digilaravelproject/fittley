<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use App\Mail\WelcomeMail;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Mail\OtpMail; // Create this new mail


class AuthController extends Controller
{
    /**
     * Handle user login (Web)
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect based on user role
            if ($user->hasRole('admin')) {
                return redirect()->intended('/admin');
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle user login (API)
     */
    public function apiLogin(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = Auth::user();
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user->load('roles', 'permissions'),
            'token' => $token,
        ]);
    }

    /**
     * Handle user registration (Web)
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        // ✅ 1. Check OTP verification
        $otpVerified = session()->get('otp_verified_' . $request->email, false);

        if (!$otpVerified) {
            return back()
                ->withErrors(['email' => 'Please verify your email with OTP before registering.'])
                ->withInput();
        }

        // ✅ 2. Encrypt password
        $data['password'] = Hash::make($data['password']);

        // ✅ 3. Mark email as verified
        $data['email_verified_at'] = now();

        // ✅ 4. Create the user
        $user = User::create($data);

        // ✅ 5. Assign default role
        $user->assignRole('user');

        // ✅ 6. Send welcome mail
        try {
            Mail::to($user->email)->send(new WelcomeMail($user));
        } catch (\Exception $e) {
            \Log::error('Welcome email failed: ' . $e->getMessage());
        }

        // ✅ 7. Trigger event
        event(new Registered($user));

        // ✅ 8. Clean up session key
        session()->forget('otp_verified_' . $data['email']);

        // ✅ 9. Auto-login user
        Auth::login($user);

        // ✅ 10. Redirect
        return redirect('/dashboard')->with('success', 'Welcome to Fitlley!');
    }


    /**
     * Handle user registration (API)
     */
    public function apiRegister(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);


        // Assign default role
        $user->assignRole('user');

        // Directly send the welcome email
        Mail::to($user->email)->send(new WelcomeMail($user));
        event(new Registered($user));

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful',
            'user' => $user->load('roles', 'permissions'),
            'token' => $token,
        ], 201);
    }

    /**
     * Handle user logout (Web)
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Handle user logout (API)
     */
    public function apiLogout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout successful'
        ]);
    }

    /**
     * Get authenticated user (API)
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user()->load('roles', 'permissions')
        ]);
    }

    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Show registration form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    public function showLinkRequestForm()
    {
        return view('auth.passwords.forgot_password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $email = $request->email;
        $rateKey = 'pwreset:' . $request->ip() . ':' . $email;

        if (RateLimiter::tooManyAttempts($rateKey, 5)) {
            return response()->json(['success' => false, 'message' => 'Too many requests. Please try again later.'], 429);
        }

        RateLimiter::hit($rateKey, 3600); // allow 5 attempts per hour

        $user = User::where('email', $email)->first();

        // create token
        $token = Password::createToken($user);

        // store token in cache for 10 minutes
        Cache::put('password_reset_' . $token, $user->email, now()->addMinutes(10));

        // queue the email (do not block)
        Mail::to($user->email)->send(new PasswordResetMail($user, $token));

        return response()->json(['success' => true]);
    }



    public function showResetForm($token)
    {
        $email = Cache::get('password_reset_' . $token);
        if (!$email) {
            abort(404);
        }
        return view('auth.passwords.reset_password', ['token' => $token, 'email' => $email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // verify token from cache
        $cachedEmail = Cache::get('password_reset_' . $request->token);
        if (!$cachedEmail || $cachedEmail !== $request->email) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired token.'], 400);
        }

        // perform password reset (You can still use Password::reset for built-in flow)
        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => Hash::make($password)])->save();
                Auth::login($user);
            }
        );

        // remove token from cache so it can't be reused
        Cache::forget('password_reset_' . $request->token);

        if ($response == Password::PASSWORD_RESET) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Failed to reset password.'], 400);
    }


    // Check if email exists
    public function checkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $exists = \App\Models\User::where('email', $request->email)->exists();
        return response()->json(['exists' => $exists]);
    }

    // Send OTP
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Prevent sending if already registered
        if (User::where('email', $request->email)->exists()) {
            return response()->json(['success' => false, 'message' => 'Email already registered.']);
        }

        // Generate 6-digit OTP
        $otp = random_int(100000, 999999);

        // Store in cache for 5 mins
        Cache::put('otp_' . $request->email, $otp, now()->addMinutes(5));

        // Send mail
        Mail::to($request->email)->send(new OtpMail($otp));

        return response()->json(['success' => true, 'message' => 'OTP sent successfully.']);
    }

    // Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $cachedOtp = Cache::get('otp_' . $request->email);

        if (!$cachedOtp) {
            return response()->json(['success' => false, 'message' => 'OTP expired. Please resend.']);
        }

        if ($cachedOtp != $request->otp) {
            return response()->json(['success' => false, 'message' => 'Invalid OTP.']);
        }

        // ✅ Mark as verified for this session
        session(['otp_verified_' . $request->email => true]);

        // ✅ Remove OTP so it can’t be reused
        Cache::forget('otp_' . $request->email);

        return response()->json(['success' => true, 'message' => 'OTP verified successfully.']);
    }
}
