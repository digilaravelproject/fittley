@extends('layouts.public')

@section('title', 'User Dashboard')

@section('content')

    @php
        use Carbon\Carbon;
        use Carbon\CarbonInterval;

        // Ensure optional variables exist
        $planName = isset($planName) ? $planName : null;
        $timeLeft = isset($timeLeft) ? $timeLeft : null;

        // Auth user (assumes authenticated)
        $user = auth()->user();

        // ------------------------------
        // 1️⃣ USER PROFILE (from DB)
        // ------------------------------
        $profile = $user->profile ?? null;

        // ------------------------------
        // 2️⃣ TIME ACTIVE (your original logic - unchanged)
        // ------------------------------
        $createdAtRaw = $user->created_at ?? null;
        $createdAt = $createdAtRaw ? Carbon::parse($createdAtRaw) : Carbon::now();

        $now = Carbon::now();
        $diff = $createdAt->diff($now);
        $daysSinceJoin = $createdAt->diffInDays($now);

        $interval = CarbonInterval::create(max(0, $diff->y), max(0, $diff->m), max(0, $diff->d))->cascade();

        $humanReadable =
            $daysSinceJoin === 0
            ? 'Joined Today'
            : $interval->forHumans([
                'parts' => 2,
                'join' => true,
                'short' => false,
                'syntax' => Carbon::DIFF_ABSOLUTE,
            ]);

        // ------------------------------
        // 3️⃣ AVATAR + NAME + INITIALS (unchanged)
        // ------------------------------
        $avatarPath = $user->avatar ? getImagePath($user->avatar) : null;

        $rawName = trim((string) ($user->name ?? ''));
        $nameParts = array_values(array_filter(preg_split('/\s+/', $rawName)));
        $displayName = !empty($rawName) ? $rawName : 'User';

        $initials = strtoupper(
            (isset($nameParts[0]) ? mb_substr($nameParts[0], 0, 1) : 'U') .
            (isset($nameParts[1]) ? mb_substr($nameParts[1], 0, 1) : ''),
        );
        if ($initials === '') {
            $initials = 'U';
        }

        // ------------------------------
        // 4️⃣ ROLES (unchanged)
        // ------------------------------
        $roles = is_iterable($user->roles) ? $user->roles : [];

        function safe_role_class($roleName)
        {
            return \Illuminate\Support\Str::slug($roleName ?: 'role');
        }

        // ------------------------------
        // 5️⃣ INTERESTS (comes from DB OR fallback)
        // Format in DB: JSON or comma separated
        // ------------------------------
        $interests = [];
        if ($profile && $profile->interests) {
            $decoded = json_decode($profile->interests, true);
            if (is_array($decoded)) {
                $interests = $decoded;
            } else {
                $interests = array_filter(array_map('trim', explode(',', $profile->interests)));
            }
        }

        if (empty($interests)) {
            $interests = [
                'Bodybuilding',
                'Calisthenics',
                'CrossFit',
                'Powerlifting',
                'Yoga & Meditation',
                'Strength & Conditioning',
                'Weight Loss',
            ];
        }

        // ------------------------------
        // 6️⃣ BODY STATS (from DB OR default display)
        // ------------------------------
        $bodyStats = [
            [
                'key' => 'height',
                'label' => 'Height',
                'value' => $profile && $profile->height ? $profile->height . ' cm' : '0 cm',
            ],
            [
                'key' => 'weight',
                'label' => 'Weight',
                'value' => $profile && $profile->weight ? $profile->weight . ' kg' : '0 kg',
            ],
            [
                'key' => 'body_fat_percentage',
                'label' => 'Body Fat',
                'value' => $profile && $profile->body_fat_percentage ? $profile->body_fat_percentage . '%' : '0%',
            ],
            [
                'key' => 'chest_waist_hips',
                'label' => 'Chest / Waist / Hips',
                'value' =>
                    $profile && $profile->chest_measurement && $profile->waist_measurement && $profile->hips_measurement
                    ? "{$profile->chest_measurement} / {$profile->waist_measurement} / {$profile->hips_measurement} cm"
                    : '0 / 0 / 0 cm',
            ],
            [
                'key' => 'arms_thighs',
                'label' => 'Arms / Thighs',
                'value' =>
                    $profile && $profile->arms_measurement && $profile->thighs_measurement
                    ? "{$profile->arms_measurement} / {$profile->thighs_measurement} cm"
                    : '0 / 0 cm',
            ],
        ];
    @endphp


    <!-- CSRF for AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <main role="main" class="user-dashboard fade-in-up" aria-label="User dashboard main content">
        <!-- ====================
                                             UPDATED PROFILE SECTION (replaces previous markup for profile-section)
                                             ==================== -->
        <div class="profile-section mb-4 stat-card p-4"
            style="border-radius:12px; background: linear-gradient(180deg,#0f0f0f,#070707);">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="d-flex align-items-center" style="gap:1rem; min-width: 0;">
                    @if ($avatarPath)
                        <img src="{{ $avatarPath }}" alt="{{ $displayName }}'s avatar" class="rounded-circle profile-avatar-lg"
                            style="width:80px; height:80px; object-fit:cover; border:2px solid rgba(255,255,255,0.06);">
                    @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center avatar-initials profile-avatar-lg"
                            style="width:80px; height:80px; font-size:1.4rem; font-weight:700;">
                            {{ $initials }}
                        </div>
                    @endif

                    <div style="min-width:0;">
                        <h3
                            style="margin:0; font-size:1.15rem; font-weight:700; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                            {{ $displayName }}
                        </h3>
                        <div style="color:#bdbdbd; font-size:0.95rem;">{{ $user->email ?? '-' }}</div>
                        <div style="margin-top:8px; display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                            <span
                                style="background:rgba(255,255,255,0.03); padding:6px 10px; border-radius:10px; font-weight:600; color:#f7a31a;">
                                Member since
                                {{ isset($user->created_at) ? \Carbon\Carbon::parse($user->created_at)->format('M Y') : '-' }}
                            </span>
                            <a href="https://fittelly.com/account/settings#profile" class="btn btn-sm edit-profile-btn"
                                style="border: 1px solid #f7a31a;color: #f7a31a;padding:6px 12px;border-radius:6px;font-size:0.85rem;">
                                <i class="fas fa-pencil-alt me-1"></i> Edit Profile
                            </a>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center" style="gap:10px; margin-top:8px;">
                    <a class="btn action-cta"
                        href="{{ $planName ? route('subscription.plans', ['upgrade' => 1]) : route('subscription.plans') }}">
                        <i class="fas fa-th-large me-2"></i>
                        {{ $planName ? 'Upgrade Plan' : 'Subscribe' }}
                    </a>


                    <!-- Referrals Button -->
                    <a class="btn action-cta" href="#" aria-label="Referrals"
                        style="padding:10px 16px; border-radius:10px; border:1px solid rgba(255,255,255,0.06);"
                        data-bs-toggle="modal" data-bs-target="#referralModal">
                        <i class="fas fa-user-friends me-2"></i> Referrals
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="referralModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered d-flex justify-content-center">
                <div class="modal-content" style="
                            background:#1d1d1d;
                            color:#fff;
                            border-radius:12px;
                            padding:20px;
                            width:100%;
                            max-width:350px;
                            text-align:center;
                            border:1px solid rgba(255,255,255,0.1);
                        ">

                    <!-- Referral Text -->
                    <div style="font-size:1rem; opacity:0.8; margin-bottom:8px;">
                        Your Referral Code
                    </div>

                    <!-- Code Box -->
                    <div id="referralCodeBox" style="
                                background:#2a2a2a;
                                padding:12px;
                                border-radius:6px;
                                font-size:1.1rem;
                                user-select:all;
                                word-break:break-all;
                            ">
                        {{ $referralCode->code }}
                    </div>

                    <!-- Copy Button -->
                    <button id="copyReferralBtn" style="
                                margin-top:15px;
                                padding:8px 16px;
                                border-radius:6px;
                                border:none;
                                cursor:pointer;
                                background:#3a3a3a;
                                color:#fff;
                                transition:0.2s;
                            " onmouseover="this.style.background='#4a4a4a'" onmouseout="this.style.background='#3a3a3a'">
                        Copy
                    </button>

                </div>
            </div>
        </div>

        <!-- ====================
                                             INTERESTS SECTION (temporary static tags)
                                             ==================== -->
        <section class="interests-section mb-3">
            <h5 style="color:#fff; margin-bottom:8px; font-weight:700;">Interests</h5>

            <div id="interests-wrap" style="display:flex; flex-wrap:wrap; gap:10px; align-items:center;">
                @foreach ($interests as $i)
                    <div class="interest-pill-wrapper" style="position:relative; display:inline-flex; align-items:center;">
                        <button type="button" class="interest-pill btn-pill" data-interest="{{ $i }}"
                            style="padding:8px 12px; border-radius:10px; background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.06); color:#fff; font-weight:600;">
                            {{ $i }}
                        </button>
                        <!-- remove button (hidden by default; toggled when adding) -->
                        <button class="interest-remove btn-remove" data-interest="{{ $i }}"
                            style="display:none; margin-left:6px; background:transparent; border:none; color:#ff6b6b; cursor:pointer;">✕</button>
                    </div>
                @endforeach

                <!-- Add interest control -->
                <div id="add-interest-wrapper" style="display:inline-flex; align-items:center;">
                    <button id="add-interest-btn" class="interest-pill btn-pill"
                        style="padding:8px 12px; border-radius:10px; background:rgba(255,255,255,0.02); border:1px dashed rgba(255,255,255,0.06); color:#fff; font-weight:600;">
                        + Add Interest
                    </button>
                </div>
            </div>
        </section>


        <!-- ====================
                                             BODY STATS (editable inline, structure ready for DB)
                                             ==================== -->
        <section class="body-stats-section mb-4">
            <h5 style="color:#fff; margin-bottom:10px; font-weight:700;">Body Stats & Check-ins</h5>

            <div id="stats-cards" style="display:flex; flex-direction:column; gap:12px;">
                @foreach ($bodyStats as $stat)
                    <div class="stat-row" data-key="{{ $stat['key'] }}"
                        style="display:flex; align-items:center; justify-content:space-between; background:#111; padding:12px; border-radius:10px; border:1px solid rgba(255,255,255,0.03);">
                        <div class="stat-label" style="color:#f7a31a; font-weight:700;">{{ $stat['label'] }}</div>

                        <div class="stat-value-wrapper"
                            style="display:flex; align-items:center; gap:8px; min-width:140px; justify-content:flex-end; position:relative;">
                            <span class="stat-value" tabindex="0" role="button" aria-label="Edit {{ $stat['label'] }}"
                                title="Click to edit"
                                style="color:#fff; font-weight:700; cursor:pointer; padding:6px 10px; border-radius:8px;">
                                {{ $stat['value'] }}
                            </span>

                            <input class="stat-input" type="text" value="{{ $stat['value'] }}"
                                aria-label="{{ $stat['label'] }} input"
                                style="display:none; min-width:140px; max-width:260px; padding:8px 10px; border-radius:8px; border:1px solid rgba(255,255,255,0.06); background:transparent; color:#fff;" />

                            <div class="stat-saving" aria-hidden="true"
                                style="display:none; position:absolute; right:-4px; top:100%; margin-top:6px; font-size:0.8rem; color:#bdbdbd;">
                                Saving…</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- ====================
                                             NOW continue with your existing content (Quick Stats ... Recent Activity ... Account Info)
                                             (I will paste your existing code below exactly as you provided, but with small accessibility / style merges preserved)
                                             ==================== -->

        <!-- Quick Stats -->
        <div class="stats-grid mb-5">
            <div class="row g-4">
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="stat-card stat-card-primary" role="region" aria-label="Sessions watched">
                        <div class="stat-card-body">
                            <div class="stat-icon" aria-hidden="true">
                                <i class="fas fa-play-circle"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number" aria-live="polite" aria-atomic="true">0</div>
                                <div class="stat-label">Sessions Watched</div>
                                <div class="stat-trend">
                                    <i class="fas fa-clock" aria-hidden="true"></i>
                                    <span>This month</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="stat-card stat-card-success" role="region" aria-label="Favorites">
                        <div class="stat-card-body">
                            <div class="stat-icon" aria-hidden="true">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number" aria-live="polite" aria-atomic="true">0</div>
                                <div class="stat-label">Favorites</div>
                                <div class="stat-trend">
                                    <i class="fas fa-bookmark" aria-hidden="true"></i>
                                    <span>Saved content</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="stat-card stat-card-info" role="region" aria-label="Achievements">
                        <div class="stat-card-body">
                            <div class="stat-icon" aria-hidden="true">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number" aria-live="polite" aria-atomic="true">0</div>
                                <div class="stat-label">Achievements</div>
                                <div class="stat-trend">
                                    <i class="fas fa-medal" aria-hidden="true"></i>
                                    <span>Unlocked</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="stat-card stat-card-warning" role="region" aria-label="Time active">
                        <div class="stat-card-body">
                            <div class="stat-icon" aria-hidden="true">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number" title="Time since you joined" aria-live="polite"
                                    aria-atomic="true">
                                    {{ $humanReadable }}
                                </div>
                                <div class="stat-label">Time Active</div>
                                <div class="stat-trend">
                                    <i class="fas fa-user-clock" aria-hidden="true"></i>
                                    <span>Member since {{ $createdAt->format('M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <!-- Recent Activity -->
            <div class="col-lg-8">
                <div class="content-card" role="region" aria-label="Recent activity">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-history me-2" aria-hidden="true"></i>
                            Recent Activity
                        </h3>
                        <p class="content-card-subtitle">Your latest interactions and progress</p>
                    </div>
                    <div class="content-card-body">
                        <div class="empty-state text-center">
                            <div class="empty-icon" aria-hidden="true">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h3>No Activity Yet</h3>
                            <p>Start watching sessions to see your activity here!</p>
                            <a href="{{ route('fitlive.index') }}" class="btn btn-primary"
                                aria-label="Start watching sessions">
                                <i class="fas fa-play me-2" aria-hidden="true"></i>
                                Start Watching
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-lg-4">
                <div class="content-card" role="region" aria-label="Quick actions">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-bolt me-2" aria-hidden="true"></i>
                            Quick Actions
                        </h3>
                    </div>
                    <div class="content-card-body">
                        <div class="d-grid gap-3">
                            <a href="{{ route('fitlive.index') }}" class="btn btn-outline-primary"
                                aria-label="Browse live sessions">
                                <i class="fas fa-broadcast-tower me-2" aria-hidden="true"></i>
                                Browse Live Sessions
                            </a>
                            <a href="{{ route('fitnews.index') }}" class="btn btn-outline-success"
                                aria-label="Read fitness news">
                                <i class="fas fa-newspaper me-2" aria-hidden="true"></i>
                                Read Fitness News
                            </a>
                            <a href="{{ route('account.settings') }}" class="btn btn-outline-warning"
                                aria-label="Account settings">
                                <i class="fas fa-cog me-2" aria-hidden="true"></i>
                                Account Settings
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Account Info -->
                <div class="content-card" role="region" aria-label="Account information">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-user me-2" aria-hidden="true"></i>
                            Account Info
                        </h3>
                    </div>
                    <div class="content-card-body">
                        <div class="user-info mb-3 d-flex align-items-center">
                            @if ($avatarPath)
                                <img src="{{ $avatarPath }}" alt="{{ $displayName }}'s avatar"
                                    class="rounded-circle user-avatar-img" style="width: 50px; height: 50px; object-fit: cover;"
                                    loading="lazy" decoding="async" width="50" height="50">
                            @else
                                <div class="user-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px; font-size: 1.25rem; font-weight: bold;" role="img"
                                    aria-label="{{ $displayName }}'s initials avatar">
                                    {{ $initials }}
                                </div>
                            @endif

                            <div class="user-details ms-3">
                                <div class="user-name">{{ $displayName }}</div>
                                <div class="user-id">{{ $user->email ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="role-badges" aria-hidden="{{ empty($roles) ? 'true' : 'false' }}">
                            @foreach ($roles as $role)
                                @php
                                    $rName = $role->name ?? (is_string($role) ? $role : 'user');
                                    $rClass = safe_role_class($rName);
                                @endphp
                                <span class="role-badge role-{{ $rClass }}">
                                    @if (strtolower($rName) === 'admin')
                                        <i class="fas fa-crown" aria-hidden="true"></i>
                                    @elseif(strtolower($rName) === 'instructor')
                                        <i class="fas fa-chalkboard-teacher" aria-hidden="true"></i>
                                    @else
                                        <i class="fas fa-user" aria-hidden="true"></i>
                                    @endif
                                    {{ ucfirst($rName) }}
                                </span>
                            @endforeach
                        </div>

                        @if ($planName)
                            <div class="mt-3 text-white">
                                <i class="fas fa-star" aria-hidden="true"></i>
                                Current Plan: <strong>{{ $planName }}</strong>
                            </div>

                            <div class="mt-1 text-white">
                                <i class="fas fa-clock" aria-hidden="true"></i>
                                Expires {{ $timeLeft }}
                            </div>
                        @else
                            <div class="mt-3 text-white">
                                <i class="fas fa-star" aria-hidden="true"></i>
                                No Active Plan
                            </div>
                        @endif

                        <div class="mt-3">
                            <small class="text-white">
                                <i class="fas fa-calendar" aria-hidden="true"></i>
                                Joined {{ $createdAt->format('M d, Y') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- ====================
                                         Styles (merged - new styles first, then preserved existing tweaks)
                                         ==================== -->
    <style>
        :root {
            --bg: #0b0b0b;
            --card: #131313;
            --muted: #bdbdbd;
            --accent: #f7a31a;
            --pill-bg: rgba(255, 255, 255, 0.04);
            --pill-border: rgba(255, 255, 255, 0.08);
        }

        body {
            background: var(--bg);
            color: #fff;
        }

        /* Profile avatar sizes */
        .profile-avatar-lg {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }

        .avatar-initials {
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            color: #ffffff;
        }

        .action-cta {
            color: var(--accent);
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.04);
            padding: 8px 12px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .interest-pill {
            padding: 8px 12px;
            border-radius: 10px;
            background: var(--pill-bg);
            border: 1px solid var(--pill-border);
            color: #fff;
            font-weight: 600;
            cursor: pointer;
        }

        .interest-pill:focus {
            outline: 2px solid rgba(247, 163, 26, 0.18);
        }

        /* Stats rows */
        .stat-row {
            transition: box-shadow .15s ease;
        }

        .stat-row:focus-within {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.6);
        }

        /* Small screen tweaks */
        @media (max-width:720px) {
            .profile-section {
                padding: 12px;
                border-radius: 6px;
            }

            .profile-avatar-lg {
                width: 64px;
                height: 64px;
            }
        }

        /* Existing styles copied / preserved below */

        .stat-card-body {
            min-height: 140px;
        }

        .stat-number {
            font-size: 1.2rem;
        }

        @media (max-width: 490px) {
            .stat-number {
                font-size: 1.5rem;
            }
        }

        .user-avatar {
            background: #007bff;
        }

        .role-badge {
            display: inline-block;
            background: #eee;
            color: #333;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            margin-right: 5px;
            vertical-align: middle;
        }

        .role-admin {
            background-color: #ffc107;
            color: #000;
        }

        .role-instructor {
            background-color: #28a745;
            color: #fff;
        }

        /* Slightly reduce margin on very small screens */
        @media (max-width: 380px) {
            .profile-section {
                padding: 12px !important;
            }
        }

        /* Keep text readable against gradients */
        .user-name-heading,
        .user-email,
        .user-details .user-name,
        .user-details .user-id {
            color: #e0e0e0;
        }

        /* Buttons */
        .edit-profile-btn {
            background: transparent;
        }

        /* Improve empty state alignment */
        .empty-state .empty-icon {
            font-size: 2.4rem;
            margin-bottom: 0.6rem;
            color: rgba(255, 255, 255, 0.85);
        }
    </style>

    <!-- ====================
                                         JavaScript: inline editing + live AJAX update (placeholder URL)
                                         ==================== -->
    <!-- jQuery must be loaded before this script. If you include jQuery globally, omit the CDN include. -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        document.getElementById('copyReferralBtn').addEventListener('click', function () {
            const code = document.getElementById('referralCodeBox').innerText.trim();

            navigator.clipboard.writeText(code)
                .then(() => {
                    this.textContent = 'Copied!';
                    setTimeout(() => this.textContent = 'Copy', 2000);
                })
                .catch(() => alert('Copy failed!'));
        });
    </script>


    <script>
        (function ($) {
            const UPDATE_STAT_URL = "{{ route('profile.update.stat') }}";
            const ADD_INTEREST_URL = "{{ route('profile.interest.add') }}";
            const REMOVE_INTEREST_URL = "{{ route('profile.interest.remove') }}";
            const CSRF = $('meta[name="csrf-token"]').attr('content');

            // Debounce helper
            function debounce(fn, wait) {
                let timer = null;
                return function () {
                    const ctx = this,
                        args = arguments;
                    clearTimeout(timer);
                    timer = setTimeout(function () {
                        fn.apply(ctx, args);
                    }, wait);
                };
            }

            // ---------- INLINE STATS ----------
            // When user clicks the visible stat value, show the input
            $('#stats-cards').on('click', '.stat-value', function () {
                const wrapper = $(this).closest('.stat-value-wrapper');
                const display = $(this);
                const input = wrapper.find('.stat-input');

                display.hide();
                input.show().focus().val(display.text());
            });

            // Press Enter => blur to save
            $('#stats-cards').on('keydown', '.stat-input', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    $(this).blur(); // trigger blur save
                }
                if (e.key === 'Escape') {
                    // cancel edit
                    $(this).hide();
                    $(this).closest('.stat-value-wrapper').find('.stat-value').show();
                }
            });

            // Blur -> save via PATCH
            $('#stats-cards').on('blur', '.stat-input', function () {
                const input = $(this);
                const wrapper = input.closest('.stat-value-wrapper');
                const row = input.closest('.stat-row');
                const display = row.find('.stat-value');
                const saving = row.find('.stat-saving');
                const key = row.data('key');
                const newValue = input.val().trim();

                // If empty, cancel and restore original display
                if (newValue === '') {
                    input.hide();
                    display.show();
                    return;
                }

                // show saving indicator
                saving.show();

                $.ajax({
                    url: UPDATE_STAT_URL,
                    type: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': CSRF
                    },
                    data: {
                        key: key,
                        value: newValue
                    },
                }).done(function (res) {
                    if (res && res.success) {
                        // use server formatted value if returned
                        display.text(res.value || newValue);
                    } else {
                        alert(res.message || 'Update failed');
                    }
                }).fail(function (xhr) {
                    console.error('Stat update failed:', xhr.responseText);
                    alert('Could not update stat.');
                }).always(function () {
                    saving.hide();
                    input.hide();
                    display.show();
                });
            });

            // ---------- INTERESTS (add/remove) ----------
            let addMode = false;

            $('#add-interest-btn').on('click', function () {
                if (addMode) return;
                addMode = true;

                // show small remove icons while editing
                $('#interests-wrap').addClass('editing-interests');

                // create input and hide add button
                const input = $(
                    '<input type="text" id="add-interest-input" placeholder="Type interest and press Enter" />'
                )
                    .css({
                        padding: '8px 10px',
                        borderRadius: '8px',
                        border: '1px solid rgba(255,255,255,0.06)',
                        background: 'transparent',
                        color: '#fff',
                        minWidth: '160px'
                    });

                $('#add-interest-btn').hide();
                $('#add-interest-wrapper').append(input);
                input.focus();

                input.on('keydown', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        $(this).trigger('addInterest');
                    } else if (e.key === 'Escape') {
                        finishAddMode();
                    }
                });

                input.on('addInterest', function () {
                    const val = $(this).val().trim();
                    if (!val) {
                        alert('Please enter an interest');
                        return;
                    }

                    $.ajax({
                        url: ADD_INTEREST_URL,
                        type: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': CSRF
                        },
                        data: {
                            interest: val
                        },
                    }).done(function (res) {
                        if (res && res.success) {
                            renderInterests(res.interests || []);
                            finishAddMode();
                        } else {
                            alert(res.message || 'Could not add interest');
                        }
                    }).fail(function (xhr) {
                        console.error('Add interest failed:', xhr.responseText);
                        const json = xhr.responseJSON;
                        alert((json && json.message) ? json.message : 'Could not add interest');
                    });
                });

                // On blur: if has text -> add, else cancel
                input.on('blur', function () {
                    const self = $(this);
                    setTimeout(function () {
                        const val = self.val().trim();
                        if (val) self.trigger('addInterest');
                        else finishAddMode();
                    }, 150);
                });
            });

            // Remove interest (delegated)
            $('#interests-wrap').on('click', '.interest-remove', function (e) {
                e.preventDefault();
                const btn = $(this);
                const interest = btn.data('interest');
                if (!interest) return;

                if (!confirm('Remove interest "' + interest + '" ?')) return;

                $.ajax({
                    url: REMOVE_INTEREST_URL,
                    type: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': CSRF
                    },
                    data: {
                        interest: interest
                    },
                }).done(function (res) {
                    if (res && res.success) {
                        renderInterests(res.interests || []);
                    } else {
                        alert(res.message || 'Could not remove interest');
                    }
                }).fail(function (xhr) {
                    console.error('Remove interest failed:', xhr.responseText);
                    alert('Could not remove interest');
                });
            });

            // finish add mode helper
            function finishAddMode() {
                addMode = false;
                $('#interests-wrap').removeClass('editing-interests');
                $('#add-interest-input').remove();
                $('#add-interest-btn').show();
            }

            // re-render interests list from array
            function renderInterests(list) {
                const wrap = $('#interests-wrap');
                // remove existing pills except add wrapper
                wrap.find('.interest-pill-wrapper').remove();

                if (!Array.isArray(list)) list = [];

                for (let i = 0; i < list.length; i++) {
                    const val = list[i];
                    const pillWrap = $(
                        '<div class="interest-pill-wrapper" style="position:relative; display:inline-flex; align-items:center; margin-right:8px;"></div>'
                    );
                    const btn = $('<button type="button" class="interest-pill btn-pill" data-interest="' + escapeHtml(
                        val) + '"></button>')
                        .text(val)
                        .css({
                            padding: '8px 12px',
                            borderRadius: '10px',
                            background: 'rgba(255,255,255,0.04)',
                            border: '1px solid rgba(255,255,255,0.06)',
                            color: '#fff',
                            fontWeight: 600
                        });
                    const remove = $('<button class="interest-remove btn-remove" data-interest="' + escapeHtml(val) +
                        '">✕</button>')
                        .css({
                            display: $('#interests-wrap').hasClass('editing-interests') ? 'inline-block' : 'none',
                            marginLeft: '6px',
                            background: 'transparent',
                            border: 'none',
                            color: '#ff6b6b',
                            cursor: 'pointer'
                        });

                    pillWrap.append(btn).append(remove);
                    $('#add-interest-wrapper').before(pillWrap);
                }

                // if no interests, keep the add button visible
                if (list.length === 0) {
                    $('#add-interest-btn').show();
                }
            }

            // XSS-safe escape for injecting strings
            function escapeHtml(unsafe) {
                if (typeof unsafe !== 'string') return '';
                return unsafe
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            // optional: keyboard shortcut 'E' to focus first stat
            $(document).on('keydown', function (e) {
                if (e.key.toLowerCase() === 'e' && !e.ctrlKey && !e.metaKey && !e.altKey) {
                    const first = $('.stat-value').first();
                    if (first.length) first.focus();
                }
            });

        })(jQuery);
    </script>

@endsection