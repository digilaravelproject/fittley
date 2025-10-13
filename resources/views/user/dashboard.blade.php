@extends('layouts.public')

@section('title', 'User Dashboard')

@section('content')
    @php
        use Carbon\CarbonInterval;

        $user = auth()->user();
        $createdAt = $user->created_at;
        $now = now();
        $diff = $createdAt->diff($now);
        $daysSinceJoin = $createdAt->diffInDays($now);

        $interval = CarbonInterval::create($diff->y, $diff->m, $diff->d)->cascade();

        $humanReadable =
            $daysSinceJoin === 0
            ? 'Joined Today'
            : $interval->forHumans([
                'parts' => 2,
                'join' => true,
                'short' => false,
                'syntax' => Carbon\CarbonInterface::DIFF_ABSOLUTE,
            ]);

        // Avatar initials (e.g. "AM")
        $nameParts = explode(' ', $user->name);
        $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
    @endphp

    <div class="user-dashboard fade-in-up">
        <!-- Header Section -->
        <div class="page-header mb-5 d-none">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="page-title">
                        <i class="fas fa-user-circle me-3"></i>
                        Welcome back, {{ $user->name }}!
                    </h1>
                    <p class="page-subtitle">Your learning dashboard and progress overview</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('fitlive.index') }}" class="btn btn-primary">
                        <i class="fas fa-broadcast-tower me-2"></i>
                        Browse Live Sessions
                    </a>
                </div>
            </div>
        </div>
        <div class="profile-section mb-4 d-flex flex-wrap align-items-center justify-content-between stat-card p-4">
            <!--<div class="profile-section mb-4 d-flex flex-wrap align-items-center justify-content-between stat-card " style="background:#fff; border-radius:12px; padding:12px 16px; box-shadow:0 2px 10px rgba(0,0,0,0.04);">-->

            <!-- Left: Avatar + Name + Email -->
            <div class="d-flex align-items-center">
                <!-- Avatar -->
                @if ($user->avatar)
                    <img src="{{ getImagePath($user->avatar) }}" alt="Avatar" class="rounded-circle"
                        style="width:60px; height:60px; object-fit:cover; border:3px solid #f0f0f0;">
                @else
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white"
                        style="width:60px; height:60px; font-size:1.3rem; font-weight:600; background:linear-gradient(135deg, #4e73df, #1cc88a);">
                        {{ $initials }}
                    </div>
                @endif

                <!-- User Info -->
                <div class="ms-3" style="line-height:1.2;">
                    <h5 class="mb-1" style="font-weight:600; font-size:1.05rem; color:#e0e0e0;">
                        {{ $user->name }}
                    </h5>
                    <span style="font-size:0.9rem; color:#666;">
                        {{ $user->email }}
                    </span>
                </div>
            </div>

            <!-- Right: Edit Button -->
            <div class="mt-3 mt-md-0">
                <a href="https://fittelly.com/account/settings#profile" class="btn btn-sm"
                    style="border: 1px solid #f7a31a;color: #f7a31a;padding:6px 14px;border-radius:6px;font-size:0.85rem;">
                    <i class="fas fa-pencil-alt me-1"></i> Edit Profile
                </a>
            </div>
        </div>



        <!-- Quick Stats -->
        <div class="stats-grid mb-5">
            <div class="row g-4">
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="stat-card stat-card-primary">
                        <div class="stat-card-body">
                            <div class="stat-icon">
                                <i class="fas fa-play-circle"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">0</div>
                                <div class="stat-label">Sessions Watched</div>
                                <div class="stat-trend">
                                    <i class="fas fa-clock"></i>
                                    <span>This month</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="stat-card stat-card-success">
                        <div class="stat-card-body">
                            <div class="stat-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">0</div>
                                <div class="stat-label">Favorites</div>
                                <div class="stat-trend">
                                    <i class="fas fa-bookmark"></i>
                                    <span>Saved content</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="stat-card stat-card-info">
                        <div class="stat-card-body">
                            <div class="stat-icon">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">0</div>
                                <div class="stat-label">Achievements</div>
                                <div class="stat-trend">
                                    <i class="fas fa-medal"></i>
                                    <span>Unlocked</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="stat-card stat-card-warning">
                        <div class="stat-card-body">
                            <div class="stat-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number" title="Time since you joined">{{ $humanReadable }}</div>
                                <div class="stat-label">Time Active</div>
                                <div class="stat-trend">
                                    <i class="fas fa-user-clock"></i>
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
                <div class="content-card">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-history me-2"></i>
                            Recent Activity
                        </h3>
                        <p class="content-card-subtitle">Your latest interactions and progress</p>
                    </div>
                    <div class="content-card-body">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h3>No Activity Yet</h3>
                            <p>Start watching sessions to see your activity here!</p>
                            <a href="{{ route('fitlive.index') }}" class="btn btn-primary">
                                <i class="fas fa-play me-2"></i>
                                Start Watching
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-lg-4">
                <div class="content-card">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-bolt me-2"></i>
                            Quick Actions
                        </h3>
                    </div>
                    <div class="content-card-body">
                        <div class="d-grid gap-3">
                            <a href="{{ route('fitlive.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-broadcast-tower me-2"></i>
                                Browse Live Sessions
                            </a>
                            <a href="{{ route('fitnews.index') }}" class="btn btn-outline-success">
                                <i class="fas fa-newspaper me-2"></i>
                                Read Fitness News
                            </a>
                            <!--<a href="{{ route('account.index') }}" class="btn btn-outline-info">-->
                            <!--    <i class="fas fa-user-edit me-2"></i>-->
                            <!--    Update Profile-->
                            <!--</a>-->
                            <a href="{{ route('account.settings') }}" class="btn btn-outline-warning">
                                <i class="fas fa-cog me-2"></i>
                                Account Settings
                            </a>

                        </div>
                    </div>
                </div>

                <!-- Account Info -->
                <div class="content-card">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-user me-2"></i>
                            Account Info
                        </h3>
                    </div>
                    <div class="content-card-body">
                        <div class="user-info mb-3 d-flex align-items-center">
                            @if ($user->avatar)
                                <!-- Show uploaded profile image -->
                                <img src="{{ getImagePath($user->avatar) }}" alt="Avatar" class="rounded-circle"
                                    style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <!-- Show initials fallback -->
                                <div class="user-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px; font-size: 1.25rem; font-weight: bold;">
                                    {{ $initials }}
                                </div>
                            @endif

                            <div class="user-details ms-3">
                                <div class="user-name">{{ $user->name }}</div>
                                <div class="user-id">{{ $user->email }}</div>
                            </div>
                        </div>

                        <div class="role-badges">
                            @foreach ($user->roles as $role)
                                <span class="role-badge role-{{ $role->name }}">
                                    @if ($role->name === 'admin')
                                        <i class="fas fa-crown"></i>
                                    @elseif($role->name === 'instructor')
                                        <i class="fas fa-chalkboard-teacher"></i>
                                    @else
                                        <i class="fas fa-user"></i>
                                    @endif
                                    {{ ucfirst($role->name) }}
                                </span>
                            @endforeach
                        </div>

                        @if ($planName)
                            <div class="mt-3 text-white">
                                <i class="fas fa-star"></i>
                                Current Plan: <strong>{{ $planName }}</strong>
                            </div>

                            <div class="mt-1 text-white">
                                <i class="fas fa-clock"></i>
                                Expires {{ $timeLeft }}
                            </div>
                        @else
                            <div class="mt-3 text-white">
                                <i class="fas fa-star"></i>
                                No Active Plan
                            </div>
                        @endif





                        <div class="mt-3">
                            <small class="text-white">
                                <i class="fas fa-calendar"></i>
                                Joined {{ $createdAt->format('M d, Y') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
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
        }

        .role-admin {
            background-color: #ffc107;
            color: #000;
        }

        .role-instructor {
            background-color: #28a745;
            color: #fff;
        }
    </style>
@endsection