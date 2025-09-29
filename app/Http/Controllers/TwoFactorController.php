<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class TwoFactorController extends Controller
{
    protected $google2fa;

    public function __construct()
    {
        $this->middleware('auth');
        // $this->google2fa = new Google2FA(); // Temporarily commented out due to missing package
    }

    /**
     * Show the two-factor authentication setup page.
     */
    public function index()
    {
        $user = Auth::user();
        
        return view('auth.two-factor.index', [
            'user' => $user,
            'enabled' => $user->hasTwoFactorEnabled()
        ]);
    }

    /**
     * Generate and show QR code for 2FA setup.
     */
    public function setup()
    {
        $user = Auth::user();
        
        if ($user->hasTwoFactorEnabled()) {
            return redirect()->route('two-factor.index')->with('error', 'Two-factor authentication is already enabled.');
        }

        // Generate secret key
        $secret = $this->google2fa->generateSecretKey();
        
        // Store temporarily in session
        session(['two_factor_secret' => $secret]);
        
        // Generate QR code
        $qrCodeUrl = $this->google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );
        
        // Generate QR code image
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new ImagickImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCodeImage = base64_encode($writer->writeString($qrCodeUrl));
        
        return view('auth.two-factor.setup', [
            'secret' => $secret,
            'qrCodeImage' => $qrCodeImage
        ]);
    }

    /**
     * Enable two-factor authentication.
     */
    public function enable(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required|string|size:6'
        ]);

        $user = Auth::user();
        $secret = session('two_factor_secret');

        if (!$secret) {
            return back()->with('error', 'Invalid session. Please start the setup process again.');
        }

        // Verify the code
        $valid = $this->google2fa->verifyKey($secret, $request->one_time_password);

        if (!$valid) {
            return back()->with('error', 'Invalid verification code. Please try again.');
        }

        // Save to user
        $user->google2fa_secret = $secret;
        $user->google2fa_enabled = true;
        $user->two_factor_confirmed_at = now();
        $user->save();

        // Generate recovery codes
        $recoveryCodes = $user->generateRecoveryCodes();

        // Clear session
        session()->forget('two_factor_secret');

        return view('auth.two-factor.recovery-codes', [
            'recoveryCodes' => $recoveryCodes
        ]);
    }

    /**
     * Disable two-factor authentication.
     */
    public function disable(Request $request)
    {
        $request->validate([
            'password' => 'required|string'
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid password.');
        }

        $user->google2fa_secret = null;
        $user->google2fa_enabled = false;
        $user->recovery_codes = null;
        $user->two_factor_confirmed_at = null;
        $user->save();

        return redirect()->route('two-factor.index')->with('success', 'Two-factor authentication has been disabled.');
    }

    /**
     * Show recovery codes.
     */
    public function recoveryCodes()
    {
        $user = Auth::user();
        
        if (!$user->hasTwoFactorEnabled()) {
            return redirect()->route('two-factor.index')->with('error', 'Two-factor authentication is not enabled.');
        }

        return view('auth.two-factor.recovery-codes', [
            'recoveryCodes' => $user->recovery_codes ?? []
        ]);
    }

    /**
     * Regenerate recovery codes.
     */
    public function regenerateRecoveryCodes(Request $request)
    {
        $request->validate([
            'password' => 'required|string'
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid password.');
        }

        $recoveryCodes = $user->generateRecoveryCodes();

        return view('auth.two-factor.recovery-codes', [
            'recoveryCodes' => $recoveryCodes
        ])->with('success', 'Recovery codes have been regenerated.');
    }

    /**
     * Verify two-factor authentication code during login.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required|string',
            'recovery_code' => 'nullable|string'
        ]);

        $user = Auth::user();

        if (!$user->hasTwoFactorEnabled()) {
            return redirect()->route('dashboard');
        }

        // Check if using recovery code
        if ($request->recovery_code) {
            if ($user->useRecoveryCode($request->recovery_code)) {
                session(['two_factor_verified' => true]);
                return redirect()->intended('dashboard');
            } else {
                return back()->with('error', 'Invalid recovery code.');
            }
        }

        // Verify the 2FA code
        $valid = $this->google2fa->verifyKey($user->google2fa_secret, $request->one_time_password);

        if (!$valid) {
            return back()->with('error', 'Invalid verification code.');
        }

        session(['two_factor_verified' => true]);
        return redirect()->intended('dashboard');
    }

    /**
     * Show 2FA verification form during login.
     */
    public function challenge()
    {
        return view('auth.two-factor.challenge');
    }
}
