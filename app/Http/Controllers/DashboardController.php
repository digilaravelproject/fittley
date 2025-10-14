<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Role redirect
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->hasRole('instructor')) {
            return redirect()->route('instructor.dashboard');
        }

        // Subscription (optimized)
        $subscription = $user->currentSubscription()->first();
        $planName = null;
        $timeLeft = null;

        if ($subscription) {
            $plan = SubscriptionPlan::find($subscription->subscription_plan_id);
            $planName = $plan?->name;

            $timeLeft = now()->diffForHumans(
                $subscription->ends_at,
                [
                    'parts' => 2,
                    'short' => false,
                    'syntax' => \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW,
                ]
            );
        }
        // Call the function to generate or get the referral code
        $referralCode = $user->generateReferralCode();

        // Ensure profile exists or null (we won't auto-create here; updates will create if missing)
        $profile = $user->profile;

        // Build bodyStats array exactly in the structure you requested.
        $bodyStats = [
            [
                'key' => 'height',
                'label' => 'Height',
                'value' => $profile && $profile->height ? (string) ($profile->height) . ' cm' : '0 cm',
            ],
            [
                'key' => 'weight',
                'label' => 'Weight',
                'value' => $profile && $profile->weight ? (string) ($profile->weight) . ' kg' : '0 kg',
            ],
            [
                'key' => 'body_fat',
                'label' => 'Body Fat',
                'value' => $profile && $profile->body_fat_percentage ? (string) ($profile->body_fat_percentage) . '%' : '0%',
            ],
            [
                'key' => 'chest_waist_hips',
                'label' => 'Chest / Waist / Hips',
                'value' => $profile
                    ? (
                        ($profile->chest_measurement ?? 0) . ' / ' .
                        ($profile->waist_measurement ?? 0) . ' / ' .
                        ($profile->hips_measurement ?? 0) . ' cm'
                    )
                    : '0 / 0 / 0 cm',
            ],
            [
                'key' => 'arms_thighs',
                'label' => 'Arms / Thighs',
                'value' => $profile
                    ? (
                        ($profile->arms_measurement ?? 0) . ' / ' . ($profile->thighs_measurement ?? 0) . ' cm'
                    )
                    : '0 / 0 cm',
            ],
        ];

        // Interests (stored as JSON in user_profiles.interests). If missing -> empty.
        $interests = [];
        if ($profile && $profile->interests) {
            // try decode safely
            $decoded = json_decode($profile->interests, true);
            if (is_array($decoded)) {
                $interests = array_values($decoded);
            } else {
                // fallback: if it's a comma-separated string
                $interests = array_values(array_filter(array_map('trim', explode(',', (string)$profile->interests))));
            }
        }

        // Visibility flags
        $showBodyStats = $profile->show_body_stats ?? 0;
        $showInterests = $profile->show_interests ?? 1;
        $showGoals     = $profile->show_goals ?? 1;

        return view('user.dashboard', compact(
            'user',
            'planName',
            'timeLeft',
            'bodyStats',
            'interests',
            'showBodyStats',
            'showInterests',
            'showGoals',
            'profile',
            'referralCode'
        ));
    }

    /**
     * Update a single body stat (AJAX).
     * Expects: key (height|weight|body_fat|chest_waist_hips|arms_thighs), value (string)
     */
    public function updateStat(Request $request)
    {
        $user = Auth::user();

        // ✅ 1) Allowed keys
        $allowedKeys = ['height', 'weight', 'body_fat_percentage', 'chest_waist_hips', 'arms_thighs'];

        // ✅ 2) Validate using $request->validate (auto handles errors)
        $request->validate([
            'key'   => 'required|in:' . implode(',', $allowedKeys),
            'value' => 'required|string|max:255',
        ]);

        $key   = $request->input('key');
        $value = trim($request->input('value'));

        // ✅ 3) Ensure profile exists
        $profile = $user->profile ?? UserProfile::create(['user_id' => $user->id]);

        try {
            DB::beginTransaction();

            // ✅ 4) Handle each key
            if ($key === 'height') {
                $profile->height = $this->extractNumber($value);
            } elseif ($key === 'weight') {
                $profile->weight = $this->extractNumber($value);
            } elseif ($key === 'body_fat_percentage') {
                $profile->body_fat_percentage = $this->extractNumber($value);
            } elseif ($key === 'chest_waist_hips') {
                $value = str_replace('cm', '', $value);
                $parts = array_map('trim', preg_split('/[\/,]+/', $value));
                $profile->chest_measurement = isset($parts[0]) ? $this->extractNumber($parts[0]) : null;
                $profile->waist_measurement = isset($parts[1]) ? $this->extractNumber($parts[1]) : null;
                $profile->hips_measurement  = isset($parts[2]) ? $this->extractNumber($parts[2]) : null;
            } elseif ($key === 'arms_thighs') {
                $value = str_replace('cm', '', $value);
                $parts = array_map('trim', preg_split('/[\/,]+/', $value));
                $profile->arms_measurement   = isset($parts[0]) ? $this->extractNumber($parts[0]) : null;
                $profile->thighs_measurement = isset($parts[1]) ? $this->extractNumber($parts[1]) : null;
            }

            // ✅ 5) Save profile
            $profile->save();
            DB::commit();

            // ✅ 6) Return formatted response like index()
            $responseValue = $this->buildResponseValueForKey($profile, $key);

            return response()->json([
                'success' => true,
                'key'     => $key,
                'value'   => $responseValue,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('updateStat error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Could not update.',
            ], 500);
        }
    }


    /**
     * Add an interest (AJAX).
     * Expects: interest (string)
     */
    public function addInterest(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'interest' => ['required', 'string', 'max:120'],
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid interest', 'errors' => $validator->errors()], 422);
        }

        $interest = trim($request->input('interest'));
        if ($interest === '') {
            return response()->json(['success' => false, 'message' => 'Interest cannot be empty'], 422);
        }

        // Ensure profile exists
        $profile = $user->profile ?? UserProfile::create(['user_id' => $user->id]);

        // decode existing interests
        $existing = [];
        if ($profile->interests) {
            $decoded = json_decode($profile->interests, true);
            if (is_array($decoded)) $existing = $decoded;
            else $existing = array_values(array_filter(array_map('trim', explode(',', (string)$profile->interests))));
        }

        // prevent duplicates (case-insensitive)
        foreach ($existing as $e) {
            if (Str::lower($e) === Str::lower($interest)) {
                return response()->json(['success' => false, 'message' => 'Interest already exists'], 409);
            }
        }

        $existing[] = $interest;
        $profile->interests = json_encode(array_values($existing));
        $profile->save();

        return response()->json(['success' => true, 'interests' => $existing]);
    }

    /**
     * Remove interest (AJAX).
     * Expects: interest (string)
     */
    public function removeInterest(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'interest' => ['required', 'string', 'max:120'],
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid interest', 'errors' => $validator->errors()], 422);
        }

        $interest = trim($request->input('interest'));

        $profile = $user->profile;
        if (!$profile || !$profile->interests) {
            return response()->json(['success' => false, 'message' => 'No interests found'], 404);
        }

        $existing = json_decode($profile->interests, true);
        if (!is_array($existing)) $existing = array_values(array_filter(array_map('trim', explode(',', (string)$profile->interests))));

        $new = [];
        $removed = false;
        foreach ($existing as $e) {
            if (Str::lower($e) === Str::lower($interest)) {
                $removed = true;
                continue;
            }
            $new[] = $e;
        }

        if (!$removed) {
            return response()->json(['success' => false, 'message' => 'Interest not found'], 404);
        }

        $profile->interests = json_encode(array_values($new));
        $profile->save();

        return response()->json(['success' => true, 'interests' => $new]);
    }

    /* -------------------------
       Helper methods (private)
       ------------------------- */

    /**
     * Extract first numeric value from a string, return as float or null.
     * Accepts "175", "175 cm", "14%", "95.5"
     */
    private function extractNumber(string $s)
    {
        // Match float or int (handles negative too but not expected)
        if (preg_match('/(-?\d+(\.\d+)?)/', $s, $m)) {
            return (float) $m[1];
        }
        return null;
    }

    /**
     * Build response string that matches the display format for the given key
     */
    private function buildResponseValueForKey(UserProfile $profile, string $key)
    {
        if ($key === 'height') {
            return $profile->height ? $profile->height . ' cm' : '0 cm';
        }
        if ($key === 'weight') {
            return $profile->weight ? $profile->weight . ' kg' : '0 kg';
        }
        if ($key === 'body_fat') {
            return $profile->body_fat_percentage ? $profile->body_fat_percentage . '%' : '0%';
        }
        if ($key === 'chest_waist_hips') {
            return ($profile->chest_measurement ?? 0) . ' / ' . ($profile->waist_measurement ?? 0) . ' / ' . ($profile->hips_measurement ?? 0) . ' cm';
        }
        if ($key === 'arms_thighs') {
            return ($profile->arms_measurement ?? 0) . ' / ' . ($profile->thighs_measurement ?? 0) . ' cm';
        }
        return '';
    }
}
