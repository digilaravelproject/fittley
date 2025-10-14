<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    protected function deleteProfilePicture($user)
    {
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
    }

    /**
     * Show account settings page.
     */
    public function index()
    {
        $user = Auth::user();
        return view('account.index', compact('user'));
    }

    /**
     * Update profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = request()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['name', 'email', 'phone', 'date_of_birth', 'gender']);

        // Handle profile picture upload
        if ($request->hasFile('avatar')) {
            // Delete old profile picture
            $this->deleteProfilePicture($user);

            $path = $request->file('avatar')->store('profile-pictures', 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);

        return back()->with('success', 'Profile updated successfully.');
    }


    /**
     * Update password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = request()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password updated successfully.');
    }

    /**
     * Update preferences.
     */

    public function updatePreferences(Request $request)
    {
        $request->validate([
            'email_notifications' => 'boolean',
            'push_notifications' => 'boolean',
            'marketing_emails' => 'boolean',
            'workout_reminders' => 'boolean',
            'live_session_alerts' => 'boolean',
            'community_notifications' => 'boolean',
            'privacy_profile' => 'in:public,friends,private',
            'show_online_status' => 'boolean',
            'allow_friend_requests' => 'boolean'
        ]);

        $user = request()->user();
        $preferences = $user->preferences ?? [];

        // Update preferences
        $preferences = array_merge($preferences, $request->only([
            'email_notifications',
            'push_notifications',
            'marketing_emails',
            'workout_reminders',
            'live_session_alerts',
            'community_notifications',
            'privacy_profile',
            'show_online_status',
            'allow_friend_requests'
        ]));

        $user->update(['preferences' => $preferences]);

        return back()->with('success', 'Preferences updated successfully.');
    }

    /**
     * Show account deletion confirmation page.
     */
    public function deleteAccount()
    {
        return view('account.delete');
    }

    /**
     * Delete user account permanently.
     */
    public function destroyAccount(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'confirmation' => 'required|in:DELETE'
        ]);

        $user = request()->user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password is incorrect.']);
        }

        DB::beginTransaction();

        try {
            // Delete profile picture if it exists
            $this->deleteProfilePicture($user);

            $user->email = 'deleted_' . $user->id . '@fittelly.com';
            $user->name = 'Deleted User';
            $user->avatar = null;
            $user->phone = null;
            $user->google2fa_secret = null;
            $user->google2fa_enabled = false;
            $user->recovery_codes = null;
            $user->deleted_at = now();

            // Example of future related data deletion:
            // $user->orders()->delete();

            $user->save();

            DB::commit();

            Auth::logout();

            return redirect('/')->with('success', 'Your account has been deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting user account: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Something went wrong. Please try again later.']);
        }
    }


    /**
     * Download account data (GDPR compliance).
     */
    public function downloadData()
    {
        try {
            // Retrieve the authenticated user
            $user = Auth::user();

            // Prepare the data to be included in the download
            $data = [
                'personal_information' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'date_of_birth' => $user->date_of_birth,
                    'gender' => $user->gender,
                    'fitness_level' => $user->fitness_level,
                    'goals' => $user->goals,
                    'timezone' => $user->timezone,
                    'created_at' => $user->created_at,
                    'preferences' => $user->preferences
                ],
                'subscription_data' => $user->currentSubscription(),
                'community_posts' => $user->communityPosts()->get(),
                'community_comments' => $user->postComments()->get(),
                'fitlive_sessions_attended' => $user->fitliveSessions()->get(),
                'fittalk_sessions' => $user->fittalkClientSessions()->get()
            ];

            // Generate a file name for the download
            $filename = 'fittelly_data_' . $user->id . '_' . now()->format('Y-m-d') . '.json';

            // Return the response with the data in JSON format
            return response()
                ->json($data, 200, [], JSON_PRETTY_PRINT)
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        } catch (\Exception $e) {
            // Log the exception message
            Log::error('Error downloading user data: ' . $e->getMessage());

            // Return a generic error message to the user
            return back()->withErrors(['error' => 'An error occurred while processing your request. Please try again later.']);
        }
    }


    /**
     * Show privacy settings.
     */
    public function privacy()
    {
        $user = Auth::user();
        return view('account.privacy', compact('user'));
    }

    /**
     * Show security settings.
     */
    public function security()
    {
        $user = Auth::user();
        return view('account.security', compact('user'));
    }
    public function settings()
    {
        $user = Auth::user();
        return view('account.settings', compact('user'));
    }
}
