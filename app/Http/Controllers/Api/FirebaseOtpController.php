<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FirebaseOtpService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class FirebaseOtpController extends Controller
{
    private $firebaseOtpService;

    public function __construct(FirebaseOtpService $firebaseOtpService)
    {
        $this->firebaseOtpService = $firebaseOtpService;
    }

    /**
     * Send OTP for login/registration
     */
    public function sendOtp(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'required|string|regex:/^\+[1-9]\d{1,14}$/',
            'action' => 'required|in:login,register'
        ]);

        $phone = $request->phone;
        $action = $request->action;

        // Check if phone is registered for login
        if ($action === 'login' && !$this->firebaseOtpService->isPhoneRegistered($phone)) {
            return response()->json([
                'success' => false,
                'message' => 'Phone number not registered. Please register first.'
            ], 404);
        }

        // Check if phone is already registered for registration
        if ($action === 'register' && $this->firebaseOtpService->isPhoneRegistered($phone)) {
            return response()->json([
                'success' => false,
                'message' => 'Phone number already registered. Please login instead.'
            ], 409);
        }

        // Use mock OTP for development (you can switch to real Firebase later)
        $result = $this->firebaseOtpService->sendMockOtp($phone);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'phone' => $phone,
                'otp' => $result['otp'] // Remove this in production
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message']
        ], 500);
    }

    /**
     * Verify OTP and login/register user
     */
    public function verifyOtp(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'required|string|regex:/^\+[1-9]\d{1,14}$/',
            'otp' => 'required|string|size:6',
            'action' => 'required|in:login,register',
            'name' => 'required_if:action,register|string|max:255',
            'email' => 'required_if:action,register|email|unique:users,email',
        ]);

        $phone = $request->phone;
        $otp = $request->otp;
        $action = $request->action;

        // Verify OTP
        $result = $this->firebaseOtpService->verifyMockOtp($phone, $otp);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 400);
        }

        if ($action === 'login') {
            return $this->handleLogin($phone);
        } else {
            return $this->handleRegister($request);
        }
    }

    /**
     * Handle OTP-based login
     */
    private function handleLogin(string $phone): JsonResponse
    {
        $user = User::where('phone', $phone)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found with this phone number.'
            ], 404);
        }

        // Generate token
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'user' => $user->load('roles', 'permissions'),
            'token' => $token,
        ]);
    }

    /**
     * Handle OTP-based registration
     */
    private function handleRegister(Request $request): JsonResponse
    {
        $phone = $request->phone;
        $name = $request->name;
        $email = $request->email;

        // Check if user already exists
        if (User::where('phone', $phone)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Phone number already registered.'
            ], 409);
        }

        if (User::where('email', $email)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Email already registered.'
            ], 409);
        }

        // Create user
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => Hash::make(str_random(16)), // Random password for OTP users
            'email_verified_at' => now(), // Mark as verified since OTP was verified
        ]);

        // Assign default role
        $user->assignRole('user');

        // Generate token
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registration successful',
            'user' => $user->load('roles', 'permissions'),
            'token' => $token,
        ], 201);
    }

    /**
     * Check if phone number is registered
     */
    public function checkPhone(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'required|string|regex:/^\+[1-9]\d{1,14}$/'
        ]);

        $phone = $request->phone;
        $isRegistered = $this->firebaseOtpService->isPhoneRegistered($phone);

        return response()->json([
            'success' => true,
            'is_registered' => $isRegistered,
            'phone' => $phone
        ]);
    }
} 