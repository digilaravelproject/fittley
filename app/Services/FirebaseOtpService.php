<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class FirebaseOtpService
{
    private $apiKey;
    private $projectId;
    private $baseUrl = 'https://identitytoolkit.googleapis.com/v1';

    public function __construct()
    {
        $this->apiKey = config('services.firebase.api_key');
        $this->projectId = config('services.firebase.project_id');
    }

    /**
     * Send OTP to phone number
     */
    public function sendOtp(string $phoneNumber): array
    {
        try {
            $response = Http::post("{$this->baseUrl}/accounts:sendVerificationCode", [
                'phoneNumber' => $phoneNumber,
                'recaptchaToken' => null, // Optional for testing
            ])->withHeaders([
                'X-Goog-Api-Key' => $this->apiKey,
                'X-Goog-Firebase-Project' => $this->projectId,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Store session info for verification
                $sessionInfo = $data['sessionInfo'] ?? null;
                if ($sessionInfo) {
                    Cache::put("firebase_session_{$phoneNumber}", $sessionInfo, 300); // 5 minutes
                }

                return [
                    'success' => true,
                    'message' => 'OTP sent successfully',
                    'session_info' => $sessionInfo
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to send OTP',
                'error' => $response->json()
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error sending OTP',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Verify OTP code
     */
    public function verifyOtp(string $phoneNumber, string $otpCode): array
    {
        try {
            $sessionInfo = Cache::get("firebase_session_{$phoneNumber}");
            
            if (!$sessionInfo) {
                return [
                    'success' => false,
                    'message' => 'Session expired. Please request OTP again.'
                ];
            }

            $response = Http::post("{$this->baseUrl}/accounts:confirmVerificationCode", [
                'phoneNumber' => $phoneNumber,
                'sessionInfo' => $sessionInfo,
                'code' => $otpCode,
            ])->withHeaders([
                'X-Goog-Api-Key' => $this->apiKey,
                'X-Goog-Firebase-Project' => $this->projectId,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Clear session info
                Cache::forget("firebase_session_{$phoneNumber}");
                
                return [
                    'success' => true,
                    'message' => 'OTP verified successfully',
                    'id_token' => $data['idToken'] ?? null,
                    'refresh_token' => $data['refreshToken'] ?? null,
                    'expires_in' => $data['expiresIn'] ?? null
                ];
            }

            return [
                'success' => false,
                'message' => 'Invalid OTP code',
                'error' => $response->json()
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error verifying OTP',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Generate a mock OTP for development/testing
     */
    public function sendMockOtp(string $phoneNumber): array
    {
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store OTP in cache for 5 minutes
        Cache::put("mock_otp_{$phoneNumber}", $otp, 300);
        
        return [
            'success' => true,
            'message' => 'Mock OTP sent successfully',
            'otp' => $otp, // Only for development
            'phone_number' => $phoneNumber
        ];
    }

    /**
     * Verify mock OTP
     */
    public function verifyMockOtp(string $phoneNumber, string $otpCode): array
    {
        $storedOtp = Cache::get("mock_otp_{$phoneNumber}");
        
        if (!$storedOtp) {
            return [
                'success' => false,
                'message' => 'OTP expired. Please request again.'
            ];
        }

        if ($storedOtp !== $otpCode) {
            return [
                'success' => false,
                'message' => 'Invalid OTP code'
            ];
        }

        // Clear OTP from cache
        Cache::forget("mock_otp_{$phoneNumber}");
        
        return [
            'success' => true,
            'message' => 'OTP verified successfully',
            'phone_number' => $phoneNumber
        ];
    }

    /**
     * Check if phone number is already registered
     */
    public function isPhoneRegistered(string $phoneNumber): bool
    {
        return \App\Models\User::where('phone', $phoneNumber)->exists();
    }
} 