{{-- resources/views/account/settings.blade.php --}}
@extends('layouts.public')

@section('title', 'Account Settings')

@section('content')
    @php
        $user = $user ?? auth()->user();
        $prefs = $user->preferences ?? [];
    @endphp


    <div class="container py-4">
        <div class="row">
            <div class="col-12 mb-3 d-flex align-items-center justify-content-between">
                <h2 class="m-0">Account Settings</h2>
                <div>
                    <a href="{{ route('account.download') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-file-download me-2"></i>Download Data
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Sidebar -->
            <aside class="col-lg-3">
                <div class="card sticky-top dark-theme" style="top:20px;z-index:999">
                    <div class="card-body p-2">
                        <nav class="nav flex-column" id="settingsNav" aria-label="Account settings">
                            <a href="#profile" class="nav-link py-2 active" data-section="profile">
                                <i class="fas fa-user me-2"></i>Profile
                            </a>
                            <!--<a href="#preferences" class="nav-link py-2" data-section="preferences">-->
                            <!--    <i class="fas fa-sliders-h me-2"></i>Preferences-->
                            <!--</a>-->
                            <a href="#privacy" class="nav-link py-2" data-section="privacy">
                                <i class="fas fa-user-shield me-2"></i>Privacy
                            </a>
                            <a href="#security" class="nav-link py-2" data-section="security">
                                <i class="fas fa-lock me-2"></i>Security
                            </a>
                            <a href="#delete" class="nav-link text-danger py-2" data-section="delete">
                                <i class="fas fa-trash-alt me-2"></i>Delete Account
                            </a>

                            <hr class="my-2">

                            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-primary w-100 mb-2">
                                <i class="fas fa-arrow-left me-2"></i>Back to Profile
                            </a>
                            <a href="{{ url('/dashboard') }}" class="btn btn-sm btn-outline-secondary w-100">
                                <i class="fas fa-home me-2"></i>Dashboard
                            </a>
                        </nav>
                    </div>
                </div>
            </aside>

            <!-- Content -->
            <main class="col-lg-9">
                {{-- Flash messages --}}
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>There were some problems with your input.</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card dark-theme">
                    <div class="card-body">
                        {{-- PROFILE SECTION --}}
                        <section id="profileSection" class="settings-section">
                            <h4 class="mb-3"><i class="fas fa-user me-2"></i>Profile Information</h4>

                            <form action="{{ route('account.updateProfile') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Name</label>
                                        <input name="name" value="{{ old('name', $user->name) }}" class="form-control"
                                            required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input name="email" type="email" value="{{ old('email', $user->email) }}"
                                            class="form-control" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Phone</label>
                                        <input name="phone" value="{{ old('phone', $user->phone) }}" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Date of Birth</label>
                                        <input name="date_of_birth" type="date"
                                            value="{{ old('date_of_birth', optional($user->date_of_birth)->format('Y-m-d')) }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Gender</label>
                                        <select name="gender" class="form-select">
                                            <option value="" {{ old('gender', $user->gender) == '' ? 'selected' : ''
                                                                                                                                                                                                                }}>Prefer not to
                                                say</option>
                                            <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : ''
                                                                                                                                                                                                                }}>Male
                                            </option>
                                            <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected'
        : '' }}>Female
                                            </option>
                                            <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' :
        '' }}>Other
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Fitness Level</label>
                                        <select name="fitness_level" class="form-select">
                                            <option value="" {{ old('fitness_level', $user->fitness_level) == '' ?
        'selected' : '' }}>
                                                Not set</option>
                                            <option value="beginner" {{ old('fitness_level', $user->fitness_level) ==
        'beginner' ? 'selected' : '' }}>
                                                Beginner</option>
                                            <option value="intermediate" {{ old('fitness_level', $user->fitness_level) ==
        'intermediate' ? 'selected' : '' }}>
                                                Intermediate</option>
                                            <option value="advanced" {{ old('fitness_level', $user->fitness_level) ==
        'advanced' ? 'selected' : '' }}>
                                                Advanced</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Timezone</label>
                                        <input name="timezone" value="{{ old('timezone', $user->timezone) }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Goals</label>
                                        <textarea name="goals" class="form-control"
                                            rows="3">{{ old('goals', $user->goals) }}</textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Profile Picture</label>
                                        <input type="file" name="avatar" class="form-control">
                                        @if ($user->avatar)
                                            <div class="mt-2">
                                                <img src="{{ getImagePath($user->avatar) }}" alt="avatar"
                                                    style="width:80px; height:80px; object-fit:cover;" class="rounded">
                                                <div class="small text-muted mt-1">Current profile picture</div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary mt-2">
                                            <i class="fas fa-save me-2"></i>Save Profile
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </section>


                        {{-- PREFERENCES SECTION --}}
                        <section id="preferencesSection" class="settings-section" style="display:none;">
                            <hr class="my-4">
                            <h4 class="mb-3"><i class="fas fa-sliders-h me-2"></i>Preferences</h4>

                            <form action="{{ route('account.updatePreferences') }}" method="POST">
                                @csrf

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="email_notifications"
                                                name="email_notifications" value="1" {{ old(
        'email_notifications',
        $prefs['email_notifications'] ?? false
    ) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="email_notifications">Email
                                                notifications</label>
                                        </div>

                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="push_notifications"
                                                name="push_notifications" value="1" {{ old(
        'push_notifications',
        $prefs['push_notifications'] ?? false
    ) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="push_notifications">Push
                                                notifications</label>
                                        </div>

                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="marketing_emails"
                                                name="marketing_emails" value="1" {{ old(
        'marketing_emails',
        $prefs['marketing_emails'] ?? false
    ) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="marketing_emails">Marketing
                                                emails</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="workout_reminders"
                                                name="workout_reminders" value="1" {{ old(
        'workout_reminders',
        $prefs['workout_reminders'] ?? false
    ) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="workout_reminders">Workout
                                                reminders</label>
                                        </div>

                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="live_session_alerts"
                                                name="live_session_alerts" value="1" {{ old(
        'live_session_alerts',
        $prefs['live_session_alerts'] ?? false
    ) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="live_session_alerts">Live session
                                                alerts</label>
                                        </div>

                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="community_notifications"
                                                name="community_notifications" value="1" {{ old(
        'community_notifications',
        $prefs['community_notifications'] ?? false
    ) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="community_notifications">Community
                                                notifications</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Profile visibility</label>
                                        <select name="privacy_profile" class="form-select">
                                            <option value="public" {{ old(
        'privacy_profile',
        $prefs['privacy_profile'] ?? ''
    ) == 'public' ? 'selected' : '' }}>
                                                Public</option>
                                            <option value="friends" {{ old('privacy_profile', $prefs['privacy_profile']
        ?? '') == 'friends' ? 'selected' : '' }}>
                                                Friends</option>
                                            <option value="private" {{ old('privacy_profile', $prefs['privacy_profile']
        ?? '') == 'private' ? 'selected' : '' }}>
                                                Private</option>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check mt-3">
                                            <input class="form-check-input" type="checkbox" id="show_online_status"
                                                name="show_online_status" value="1" {{ old(
        'show_online_status',
        $prefs['show_online_status'] ?? false
    ) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="show_online_status">Show online
                                                status</label>
                                        </div>

                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="allow_friend_requests"
                                                name="allow_friend_requests" value="1" {{ old(
        'allow_friend_requests',
        $prefs['allow_friend_requests'] ?? false
    ) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="allow_friend_requests">Allow friend
                                                requests</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-success mt-3">
                                            <i class="fas fa-save me-2"></i>Save Preferences
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </section>


                        {{-- PRIVACY SECTION --}}
                        <section id="privacySection" class="settings-section" style="display:none;">
                            <hr class="my-4">
                            <h4 class="mb-3"><i class="fas fa-user-shield me-2"></i>Privacy</h4>

                            <form action="{{ route('account.updatePreferences') }}" method="POST">
                                @csrf
                                {{-- We reuse updatePreferences route for sustained preference-like privacy fields --}}
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Profile visibility</label>
                                        <select name="privacy_profile" class="form-select">
                                            <option value="public" {{ old(
        'privacy_profile',
        $prefs['privacy_profile'] ?? ''
    ) == 'public' ? 'selected' : '' }}>
                                                Public</option>
                                            <option value="friends" {{ old('privacy_profile', $prefs['privacy_profile']
        ?? '') == 'friends' ? 'selected' : '' }}>
                                                Friends</option>
                                            <option value="private" {{ old('privacy_profile', $prefs['privacy_profile']
        ?? '') == 'private' ? 'selected' : '' }}>
                                                Private</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Who can message you</label>
                                        <select name="who_can_message" class="form-select">
                                            <option value="everyone" {{ old('who_can_message', $prefs['who_can_message']
        ?? '') == 'everyone' ? 'selected' : '' }}>
                                                Everyone</option>
                                            <option value="friends" {{ old('who_can_message', $prefs['who_can_message']
        ?? '') == 'friends' ? 'selected' : '' }}>
                                                Friends</option>
                                            <option value="no_one" {{ old(
        'who_can_message',
        $prefs['who_can_message'] ?? ''
    ) == 'no_one' ? 'selected' : '' }}>
                                                No one</option>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <small class="text-muted">
                                            You can always download your data or request full account deletion from the
                                            Delete Account tab.
                                        </small>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary mt-3">
                                            <i class="fas fa-save me-2"></i>Save Privacy Settings
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </section>


                        {{-- SECURITY SECTION --}}
                        <section id="securitySection" class="settings-section" style="display:none;">
                            <hr class="my-4">
                            <h4 class="mb-3"><i class="fas fa-lock me-2"></i>Security</h4>

                            {{-- Change Password --}}
                            <div class="mb-4">
                                <form action="{{ route('account.updatePassword') }}" method="POST">
                                    @csrf

                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Current Password</label>
                                            <input type="password" name="current_password" class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">New Password</label>
                                            <input type="password" name="password" class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Confirm New Password</label>
                                            <input type="password" name="password_confirmation" class="form-control"
                                                required>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-warning mt-2">
                                                <i class="fas fa-key me-2"></i>Change Password
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- 2FA Placeholder --}}
                            {{--
                            <div class="card border-0 bg-light p-3">
                                <h6>Two Factor Authentication (2FA)</h6>
                                <p class="small text-muted mb-2">Manage two-factor authentication for your account.</p>
                                @if ($user->google2fa_enabled ?? false)
                                <div class="mb-2"><span class="badge bg-success">Enabled</span></div>
                                <a href="{{ route('account.security') }}" class="btn btn-outline-danger btn-sm">Disable
                                    2FA</a>
                                @else
                                <div class="mb-2"><span class="badge bg-secondary">Disabled</span></div>
                                <a href="{{ route('account.security') }}" class="btn btn-outline-primary btn-sm">Set
                                    up 2FA</a>
                                @endif
                            </div> --}}
                        </section>


                        {{-- DELETE ACCOUNT SECTION --}}
                        <section id="deleteSection" class="settings-section" style="display:none;">
                            <hr class="my-4">
                            <h4 class="mb-3 text-danger"><i class="fas fa-trash-alt me-2"></i>Delete Account</h4>

                            <div class="alert alert-warning">
                                <strong>Warning:</strong> Deleting your account is permanent. All personal data will be
                                anonymized and you will be logged out.
                            </div>

                            <form action="{{ route('account.destroy') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Enter your password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Type <code>DELETE</code> to confirm</label>
                                    <input type="text" name="confirmation" class="form-control" placeholder="DELETE"
                                        required>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash me-2"></i>Delete my account
                                    </button>

                                    <a href="{{ route('account.download') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-file-export me-2"></i>Download my data
                                    </a>
                                </div>
                            </form>
                        </section>

                    </div>
                </div>
            </main>
        </div>
    </div>

    {{-- Inline styles for small tweaks --}}
    <style>
        .dark-theme {
            background: #222;
            color: #fff;
        }

        .settings-section {
            animation: fadeIn .18s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(6px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        /* Make sidebar responsive: collapse into top nav on small screens */
        @media (max-width: 991.98px) {
            aside.col-lg-3 {
                order: 1;
            }

            main.col-lg-9 {
                order: 2;
            }

            .sticky-top {
                position: static !important;
                top: auto;
            }
        }
    </style>

    {{-- JS: Minimal tab/section navigation + deep-linking via hash --}}
    <script>
        (function () {
            const navLinks = document.querySelectorAll('#settingsNav a[data-section]');
            const sections = {
                profile: document.getElementById('profileSection'),
                preferences: document.getElementById('preferencesSection'),
                privacy: document.getElementById('privacySection'),
                security: document.getElementById('securitySection'),
                delete: document.getElementById('deleteSection')
            };

            function showSection(name, pushHistory = true) {
                // hide all
                Object.values(sections).forEach(s => s.style.display = 'none');
                navLinks.forEach(a => a.classList.remove('active'));

                // show target (default to profile)
                const target = sections[name] || sections.profile;
                target.style.display = '';
                // highlight nav
                const activeLink = document.querySelector(`#settingsNav a[data-section="${name}"]`);
                if (activeLink) activeLink.classList.add('active');

                // update hash without scrolling
                if (pushHistory) {
                    history.replaceState(null, '', '#' + name);
                }
            }

            // click handlers
            navLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    showSection(this.dataset.section);
                    // small smooth scroll to top of card on mobile
                    if (window.innerWidth < 992) {
                        const cardTop = document.querySelector('.card').getBoundingClientRect().top +
                            window.scrollY - 10;
                        window.scrollTo({
                            top: cardTop,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // on load: check hash
            const initialHash = location.hash.replace('#', '') || 'profile';
            showSection(initialHash, false);

            // if server returns validation errors, keep user on the relevant section:
            @if ($errors->any())
                // heuristic: choose section from error keys
                const errKeys = {!! json_encode(array_keys($errors->messages())) !!};
                const sectionMap = {
                    current_password: 'security',
                    password: 'security',
                    avatar: 'profile',
                    email_notifications: 'preferences',
                    privacy_profile: 'preferences',
                    confirmation: 'delete'
                };
                let picked = null;
                for (let k of errKeys) {
                    if (sectionMap[k]) {
                        picked = sectionMap[k];
                        break;
                    }
                }
                if (picked) {
                    showSection(picked);
                }
            @endif
                    })();
    </script>
@endsection