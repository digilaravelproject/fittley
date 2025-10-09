<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'fitlley - Live Fitness Sessions')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Netflix-inspired Color Palette */
            --primary-color: #f7a31a;
            --primary-dark: #e8941a;
            --primary-light: #f9b847;
            
            /* Background Colors */
            --bg-primary: #0a0a0a;
            --bg-secondary: #141414;
            --bg-tertiary: #1a1a1a;
            --bg-card: #1f1f1f;
            --bg-hover: #2a2a2a;
            
            /* Text Colors */
            --text-primary: #ffffff;
            --text-secondary: #e5e5e5;
            --text-muted: #b3b3b3;
            --text-disabled: #6b6b6b;
            
            /* Border Colors */
            --border-primary: #333333;
            --border-secondary: #404040;
            --border-accent: #f7a31a;
            
            /* Status Colors */
            --success: #00d084;
            --error: #e50914;
            --warning: #ffb020;
            --info: #00a8ff;
            
            /* Shadows */
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 4px 8px rgba(0, 0, 0, 0.4);
            --shadow-lg: 0 8px 16px rgba(0, 0, 0, 0.5);
            --shadow-xl: 0 12px 24px rgba(0, 0, 0, 0.6);
            
            /* Transitions */
            --transition-fast: 0.15s ease-in-out;
            --transition-normal: 0.3s ease-in-out;
            --transition-slow: 0.5s ease-in-out;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            /* font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; */
            font-family: 'Roboto', sans-serif !important;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            font-weight: 400;
            overflow-x: hidden;
        }

        /* Navbar Styles - Frosted Glass Header */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(10, 10, 10, 0.15) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: rgba(26, 26, 26, 0.25) !important;
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
            text-shadow: 0 0 10px rgba(247, 163, 26, 0.3);
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            color: var(--primary-color);
            text-shadow: 0 0 20px rgba(247, 163, 26, 0.5);
        }

        .navbar-nav {
            gap: 2rem;
        }

        .nav-link {
            color: var(--text-secondary) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
            background: rgba(247, 163, 26, 0.1);
            backdrop-filter: blur(10px);
            transform: translateY(-2px);
        }

        .nav-link.active {
            color: var(--primary-color) !important;
            background: rgba(247, 163, 26, 0.15);
            backdrop-filter: blur(10px);
        }

        .dropdown-menu {
            background: rgba(26, 26, 26, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            border-radius: 12px;
            margin-top: 0.5rem;
        }

        .dropdown-item {
            color: var(--text-secondary);
            transition: all 0.3s ease;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin: 0.25rem;
        }

        .dropdown-item:hover {
            background: rgba(247, 163, 26, 0.1);
            color: var(--text-primary);
            transform: translateX(5px);
        }

        .btn-primary {
            background: var(--primary-color);
            border: 2px solid var(--primary-color);
            color: #000;
            padding: 0.6rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .btn-primary:hover {
            background: transparent;
            border-color: var(--primary-color);
            color: var(--primary-color);
            box-shadow: 0 0 20px rgba(247, 163, 26, 0.3);
            transform: translateY(-2px);
        }

        /* Main Content */
        .main-content {
            min-height: calc(100vh - 76px);
            padding-top: 6rem;
        }

        .container-fluid {
            max-width: 1400px;
        }

        /* Page Header Styles */
        .page-header {
            background: linear-gradient(135deg, var(--bg-card), var(--bg-tertiary));
            border: 1px solid var(--border-primary);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-md);
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .page-subtitle {
            font-size: 1.125rem;
            color: var(--text-muted);
            font-weight: 400;
            margin: 0;
        }

        /* Stats Grid */
        .stats-grid {
            margin-bottom: 2rem;
        }

        .stat-card {
            background: linear-gradient(135deg, var(--bg-card), var(--bg-tertiary));
            border: 1px solid var(--border-primary);
            border-radius: 16px;
            overflow: hidden;
            transition: var(--transition-normal);
            box-shadow: var(--shadow-md);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card-primary {
            border-left: 4px solid var(--primary-color);
        }

        .stat-card-success {
            border-left: 4px solid var(--success);
        }

        .stat-card-info {
            border-left: 4px solid var(--info);
        }

        .stat-card-warning {
            border-left: 4px solid var(--warning);
        }

        .stat-card-danger {
            border-left: 4px solid var(--error);
        }

        .stat-card-body {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--text-primary);
            background: rgba(247, 163, 26, 0.1);
            border: 1px solid rgba(247, 163, 26, 0.2);
        }

        .stat-content {
            flex: 1;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-top: 0.25rem;
            font-weight: 500;
        }

        .stat-trend {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        /* Content Cards */
        .content-card {
            background: linear-gradient(135deg, var(--bg-card), var(--bg-tertiary));
            border: 1px solid var(--border-primary);
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .content-card-header {
            background: linear-gradient(135deg, var(--bg-secondary), var(--bg-card));
            border-bottom: 1px solid var(--border-primary);
            padding: 1.5rem 2rem;
        }

        .content-card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
        }

        .content-card-subtitle {
            font-size: 1rem;
            color: var(--text-muted);
            margin: 0.5rem 0 0 0;
        }

        .content-card-body {
            padding: 2rem;
        }

        /* User Info Components */
        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--bg-primary);
            font-weight: 600;
        }

        .user-details {
            flex: 1;
        }

        .user-name {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.95rem;
        }

        .user-id {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        /* Role and Status Badges */
        .role-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.375rem 0.75rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .role-admin {
            background: linear-gradient(135deg, rgba(247, 163, 26, 0.15), rgba(247, 163, 26, 0.05));
            color: var(--primary-color);
            border: 1px solid rgba(247, 163, 26, 0.2);
        }

        .role-instructor {
            background: linear-gradient(135deg, rgba(0, 208, 132, 0.15), rgba(0, 208, 132, 0.05));
            color: var(--success);
            border: 1px solid rgba(0, 208, 132, 0.2);
        }

        .role-user {
            background: linear-gradient(135deg, rgba(0, 168, 255, 0.15), rgba(0, 168, 255, 0.05));
            color: var(--info);
            border: 1px solid rgba(0, 168, 255, 0.2);
        }

        /* Empty States */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-icon {
            font-size: 4rem;
            color: var(--text-disabled);
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: var(--text-muted);
            margin-bottom: 2rem;
        }

        /* Button Styles */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border: none;
            color: var(--bg-primary);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            transition: var(--transition-fast);
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-light), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: var(--bg-primary);
        }

        .btn-outline-primary {
            background: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            transition: var(--transition-fast);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: var(--bg-primary);
            transform: translateY(-2px);
        }

        .btn-outline-success {
            background: transparent;
            border: 1px solid var(--success);
            color: var(--success);
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            transition: var(--transition-fast);
        }

        .btn-outline-success:hover {
            background: var(--success);
            color: white;
            transform: translateY(-2px);
        }

        .btn-outline-info {
            background: transparent;
            border: 1px solid var(--info);
            color: var(--info);
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            transition: var(--transition-fast);
        }

        .btn-outline-info:hover {
            background: var(--info);
            color: white;
            transform: translateY(-2px);
        }

        .btn-outline-warning {
            background: transparent;
            border: 1px solid var(--warning);
            color: var(--warning);
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            transition: var(--transition-fast);
        }

        .btn-outline-warning:hover {
            background: var(--warning);
            color: var(--bg-primary);
            transform: translateY(-2px);
        }

        /* Form Styles */
        .form-control {
            background: var(--bg-secondary);
            border: 1px solid var(--border-primary);
            color: var(--text-primary);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: var(--transition-fast);
        }

        .form-control:focus {
            background: var(--bg-secondary);
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(247, 163, 26, 0.1);
            color: var(--text-primary);
        }

        .form-control::placeholder {
            color: var(--text-disabled);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Footer */
        .footer {
            background: var(--bg-secondary);
            border-top: 1px solid var(--border-primary);
            padding: 3rem 0 2rem;
            margin-top: 4rem;
        }

        .footer h5 {
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .footer p, .footer a {
            color: var(--text-muted);
            text-decoration: none;
            transition: var(--transition-fast);
        }

        .footer a:hover {
            color: var(--primary-color);
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-secondary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border-secondary);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-color);
        }

        /* Bottom Navigation for Mobile */
        .bottom-navbar {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(20, 20, 20, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 0.75rem 0;
            z-index: 1000;
        }

        .bottom-nav-items {
            display: flex;
            justify-content: space-around;
            align-items: center;
            max-width: 100%;
            margin: 0 auto;
        }

        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: var(--text-muted);
            transition: all 0.3s ease;
            padding: 0.25rem;
            min-width: 60px;
        }

        .bottom-nav-item.active {
            color: var(--primary-color);
        }

        .bottom-nav-item:hover {
            color: var(--primary-color);
            text-decoration: none;
        }

        .bottom-nav-icon {
            font-size: 1.2rem;
            margin-bottom: 0.25rem;
        }

        .bottom-nav-label {
            font-size: 0.7rem;
            font-weight: 500;
            text-transform: capitalize;
        }

        @media (max-width: 768px) {
            .bottom-navbar {
                display: block;
            }
            
            /* Add bottom padding to prevent content from being hidden behind bottom nav */
            body {
                padding-bottom: 70px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">

            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('storage/app/public/logos/app_logo.png') }}" height="50" class="me-2">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('fitlive.*') ? 'active' : '' }}" href="{{ route('fitlive.index') }}">
                            <!-- <i class="fas fa-broadcast-tower me-1"></i> -->
                            FitLive
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('fitnews.*') ? 'active' : '' }}" href="{{ route('fitnews.index') }}">
                            <!-- <i class="fas fa-newspaper me-1"></i> -->
                            FitNews
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('fitdoc.*') ? 'active' : '' }}" href="{{ route('fitdoc.index') }}">
                            <!-- <i class="fas fa-film me-1"></i> -->
                            FitDoc
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('fitarena.*') ? 'active' : '' }}" href="{{ route('fitarena.index') }}">
                            <!-- <i class="fas fa-trophy me-1"></i> -->
                            FitArena
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('fitguide.*') ? 'active' : '' }}" href="{{ route('fitguide.index') }}">
                            <!-- <i class="fas fa-dumbbell me-1"></i> -->
                            FitGuide
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('fitinsight.*') ? 'active' : '' }}" href="{{ route('fitinsight.index') }}">
                            <!-- <i class="fas fa-blog me-1"></i> -->
                            FitInsight
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('fitlive.*') ? 'active' : '' }}" href="{{ route('fitlive.vdo') }}">
                            <!-- <i class="fas fa-film me-1"></i> -->
                            FitFlix
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i>{{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a></li>
                                @if(auth()->user()->hasRole('admin'))
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-cog me-2"></i>Admin Panel
                                    </a></li>
                                @endif
                                @if(auth()->user()->hasRole('instructor'))
                                    <li><a class="dropdown-item" href="{{ route('instructor.dashboard') }}">
                                        <i class="fas fa-chalkboard-teacher me-2"></i>Instructor Panel
                                    </a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary ms-2" href="{{ route('register') }}">Sign Up</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        @if(Request::is('/'))
            @yield('content')
        @else
            <div class="container">
                @yield('content')
            </div>
        @endif
    </main>

    <!-- Bottom Navigation for Mobile -->
    <nav class="bottom-navbar">
        <div class="bottom-nav-items">
            <a href="{{ url('/') }}" class="bottom-nav-item {{ Request::is('/') ? 'active' : '' }}">
                <div class="bottom-nav-icon">
                    <i class="fas fa-home"></i>
                </div>
                <span class="bottom-nav-label">Home</span>
            </a>
            
            <a href="{{ route('fitlive.index') }}" class="bottom-nav-item {{ request()->routeIs('fitlive.*') ? 'active' : '' }}">
                <div class="bottom-nav-icon">
                    <i class="fas fa-broadcast-tower"></i>
                </div>
                <span class="bottom-nav-label">FitLive</span>
            </a>
            
            <a href="{{ route('fitguide.index') }}" class="bottom-nav-item {{ request()->routeIs('fitguide.*') ? 'active' : '' }}">
                <div class="bottom-nav-icon">
                    <i class="fas fa-dumbbell"></i>
                </div>
                <span class="bottom-nav-label">FitGuide</span>
            </a>
            
            <a href="{{ route('fitarena.index') }}" class="bottom-nav-item {{ request()->routeIs('fitarena.*') ? 'active' : '' }}">
                <div class="bottom-nav-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <span class="bottom-nav-label">FitArena</span>
            </a>
            
            <a href="{{ url('/tools') }}" class="bottom-nav-item {{ Request::is('tools*') ? 'active' : '' }}">
                <div class="bottom-nav-icon">
                    <i class="fas fa-tools"></i>
                </div>
                <span class="bottom-nav-label">Tools</span>
            </a>
        </div>
    </nav>

    <!-- Footer -->
    <!-- Footer -->
    <footer class="footer bg-dark text-light pt-5 pb-3">
        <div class="container text-center">
            {{-- Logo centered --}}
            <div class="mb-3">
                <img src="{{ asset('storage/app/public/logos/app_logo.png') }}" alt="FITTELLY Logo" height="50" class="mb-2">
            </div>

            {{-- Social icons centered --}}
            <div class="mb-3">
                <a href="#" class="text-light me-3 fs-5"><i class="fab fa-facebook"></i></a>
                <a href="#" class="text-light me-3 fs-5"><i class="fab fa-instagram"></i></a>
            </div>

            {{-- Links centered --}}
            <ul class="list-inline mb-2 small">
                <li class="list-inline-item"><a href="{{ route('legal_notice') }}" class="text-light">Legal Notice</a></li>
                <li class="list-inline-item"><a href="{{ route('cookie_preference') }}" class="text-light">Cookie Preference</a></li>
                <li class="list-inline-item"><a href="{{ route('privacy_policy') }}" class="text-light">Privacy Policy</a></li>
                <li class="list-inline-item"><a href="{{ route('refund_policy') }}" class="text-light">Refund Policy</a></li>
                <li class="list-inline-item"><a href="{{ route('terms_condition') }}" class="text-light">Terms & Condition</a></li>
                <li class="list-inline-item"><a href="{{ route('register') }}" class="text-light">Instructor Login</a></li>
            </ul>

            {{-- Copyright centered --}}
            <p class="mb-0 small">&copy; {{ date('Y') }} FITTELLY. All rights reserved.</p>
        </div>

        {{-- Orange bar at bottom --}}
        <div class="bg-warning mt-4" style="height:7px;"></div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <script>
        // Header scroll effect
        $(window).on('scroll', function() {
            if ($(window).scrollTop() > 50) {
                $('.navbar').addClass('scrolled');
            } else {
                $('.navbar').removeClass('scrolled');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html> 