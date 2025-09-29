<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Instructor Dashboard') - fitlley</title>
    
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
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            font-weight: 400;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            background: linear-gradient(180deg, var(--bg-secondary) 0%, var(--bg-tertiary) 100%);
            border-right: 1px solid var(--border-primary);
            z-index: 1000;
            transition: var(--transition-normal);
            box-shadow: var(--shadow-lg);
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid var(--border-primary);
            background: var(--bg-card);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            transition: var(--transition-fast);
        }

        .sidebar-brand:hover {
            transform: translateX(4px);
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: var(--bg-primary);
            box-shadow: var(--shadow-md);
        }

        .brand-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.02em;
        }

        .instructor-badge {
            font-size: 0.75rem;
            color: var(--primary-color);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .sidebar-nav {
            padding: 1.5rem 0;
            overflow-y: auto;
            height: calc(100vh - 140px); /* Subtract header height */
            scrollbar-width: thin;
            scrollbar-color: var(--border-secondary) transparent;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background-color: var(--border-secondary);
            border-radius: 3px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background-color: var(--border-primary);
        }

        .nav-item {
            margin: 0.25rem 1rem;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.25rem;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 12px;
            transition: var(--transition-fast);
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(247, 163, 26, 0.1), transparent);
            transition: var(--transition-normal);
        }

        .nav-link:hover::before {
            left: 100%;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--text-primary);
            background: linear-gradient(135deg, rgba(247, 163, 26, 0.15), rgba(247, 163, 26, 0.05));
            border: 1px solid rgba(247, 163, 26, 0.2);
            transform: translateX(4px);
            box-shadow: var(--shadow-sm);
        }

        .nav-link.active {
            background: linear-gradient(135deg, rgba(247, 163, 26, 0.2), rgba(247, 163, 26, 0.1));
            border-color: var(--primary-color);
        }

        .nav-section {
            margin: 1.5rem 1rem 0.5rem;
        }

        .nav-section-title {
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0 1.25rem;
        }

        .nav-icon {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            background: var(--bg-primary);
        }

        .content-wrapper {
            padding: 2rem;
        }

        /* Header Styles */
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

        /* Card Styles */
        .netflix-card {
            background: linear-gradient(135deg, var(--bg-card), var(--bg-tertiary));
            border: 1px solid var(--border-primary);
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            transition: var(--transition-normal);
            overflow: hidden;
        }

        .netflix-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--border-accent);
        }

        .card-header {
            background: linear-gradient(135deg, var(--bg-secondary), var(--bg-card));
            border-bottom: 1px solid var(--border-primary);
            padding: 1.5rem 2rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .card-body {
            padding: 2rem;
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

        .btn-secondary {
            background: var(--bg-tertiary);
            border: 1px solid var(--border-primary);
            color: var(--text-secondary);
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            transition: var(--transition-fast);
        }

        .btn-secondary:hover {
            background: var(--bg-hover);
            border-color: var(--border-accent);
            color: var(--text-primary);
            transform: translateY(-2px);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success), #00b86b);
            border: none;
            color: white;
            font-weight: 600;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--error), #cc0812);
            border: none;
            color: white;
            font-weight: 600;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning), #e6a01a);
            border: none;
            color: var(--bg-primary);
            font-weight: 600;
        }

        /* Mobile Styles */
        .mobile-header {
            display: none;
            background: var(--bg-card);
            border-bottom: 1px solid var(--border-primary);
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .mobile-toggle {
            background: none;
            border: none;
            color: var(--text-primary);
            font-size: 1.25rem;
            padding: 0.5rem;
            border-radius: 8px;
            transition: var(--transition-fast);
        }

        .mobile-toggle:hover {
            background: var(--bg-hover);
        }

        .mobile-brand {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-left: 1rem;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .mobile-header {
                display: flex;
                align-items: center;
            }
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

        .form-label {
            color: var(--text-secondary);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        /* Table Styles */
        .table {
            color: var(--text-primary);
        }

        .table-dark {
            --bs-table-bg: var(--bg-card);
            --bs-table-border-color: var(--border-primary);
        }

        .table-dark th {
            background: var(--bg-secondary);
            border-color: var(--border-primary);
            color: var(--text-primary);
        }

        .table-dark td {
            border-color: var(--border-primary);
        }

        /* Alert Styles */
        .alert {
            border-radius: 12px;
            border: none;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(0, 208, 132, 0.1), rgba(0, 184, 107, 0.05));
            color: var(--success);
            border: 1px solid rgba(0, 208, 132, 0.2);
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(229, 9, 20, 0.1), rgba(204, 8, 18, 0.05));
            color: var(--error);
            border: 1px solid rgba(229, 9, 20, 0.2);
        }

        .alert-warning {
            background: linear-gradient(135deg, rgba(255, 176, 32, 0.1), rgba(230, 160, 26, 0.05));
            color: var(--warning);
            border: 1px solid rgba(255, 176, 32, 0.2);
        }

        .alert-info {
            background: linear-gradient(135deg, rgba(0, 168, 255, 0.1), rgba(0, 150, 230, 0.05));
            color: var(--info);
            border: 1px solid rgba(0, 168, 255, 0.2);
        }

        /* Badge Styles */
        .badge {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 0.75rem;
        }

        .badge.bg-success {
            background: linear-gradient(135deg, var(--success), #00b86b) !important;
        }

        .badge.bg-danger {
            background: linear-gradient(135deg, var(--error), #cc0812) !important;
        }

        .badge.bg-warning {
            background: linear-gradient(135deg, var(--warning), #e6a01a) !important;
            color: var(--bg-primary) !important;
        }

        .badge.bg-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)) !important;
            color: var(--bg-primary) !important;
        }

        /* Pagination Styles */
        .pagination {
            --bs-pagination-bg: var(--bg-card);
            --bs-pagination-border-color: var(--border-primary);
            --bs-pagination-color: var(--text-secondary);
            --bs-pagination-hover-bg: var(--bg-hover);
            --bs-pagination-hover-border-color: var(--border-accent);
            --bs-pagination-hover-color: var(--text-primary);
            --bs-pagination-active-bg: var(--primary-color);
            --bs-pagination-active-border-color: var(--primary-color);
            --bs-pagination-active-color: var(--bg-primary);
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

        /* ===== CONSISTENT UI COMPONENTS ===== */
        
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

        /* Modern Table Styles */
        .modern-table {
            width: 100%;
            color: var(--text-primary);
            border-collapse: separate;
            border-spacing: 0;
        }

        .modern-table thead th {
            background: var(--bg-secondary);
            color: var(--text-secondary);
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-primary);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .modern-table thead th:first-child {
            border-top-left-radius: 12px;
        }

        .modern-table thead th:last-child {
            border-top-right-radius: 12px;
        }

        .modern-table tbody tr {
            transition: var(--transition-fast);
        }

        .modern-table tbody tr:hover {
            background: rgba(247, 163, 26, 0.05);
        }

        .modern-table tbody td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-primary);
            vertical-align: middle;
        }

        /* Session Card Styles */
        .session-card {
            background: linear-gradient(135deg, var(--bg-card), var(--bg-tertiary));
            border: 1px solid var(--border-primary);
            border-radius: 16px;
            overflow: hidden;
            transition: var(--transition-normal);
            box-shadow: var(--shadow-md);
            height: 100%;
        }

        .session-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--border-accent);
        }

        .session-card-image {
            height: 200px;
            background: linear-gradient(135deg, var(--bg-secondary), var(--bg-card));
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .session-card-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            height: calc(100% - 200px);
        }

        .session-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .session-meta {
            color: var(--text-muted);
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .session-description {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 1rem;
            flex-grow: 1;
        }

        .session-details {
            background: var(--bg-secondary);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .session-actions {
            margin-top: auto;
        }

        /* Search and Controls */
        .table-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .search-box {
            position: relative;
            width: 300px;
        }

        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        .search-box .form-control {
            padding-left: 2.5rem;
            background: var(--bg-tertiary);
            border: 1px solid var(--border-primary);
            border-radius: 12px;
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

        /* Pagination */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
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
    </style>
    @stack('styles')
</head>
<body>
    <div class="instructor-layout">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('instructor.dashboard') }}" class="sidebar-brand">
                    <div class="brand-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div>
                        <div class="brand-text">fitlley</div>
                        <div class="instructor-badge">Instructor</div>
                    </div>
                </a>
            </div>
            
            <div class="sidebar-nav">
                <div class="nav-item">
                    <a class="nav-link {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}" href="{{ route('instructor.dashboard') }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
                
                <!-- Session Management -->
                <div class="nav-section">
                    <div class="nav-section-title">Session Management</div>
                </div>
                <div class="nav-item">
                    <a class="nav-link {{ request()->routeIs('instructor.sessions*') ? 'active' : '' }}" href="{{ route('instructor.sessions') }}">
                        <i class="nav-icon fas fa-broadcast-tower"></i>
                        <span>My Sessions</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link {{ request()->routeIs('instructor.sessions.create') ? 'active' : '' }}" href="{{ route('instructor.sessions.create') }}">
                        <i class="nav-icon fas fa-plus-circle"></i>
                        <span>Create Session</span>
                    </a>
                </div>
                
                <!-- FitArena Management -->
                <div class="nav-section">
                    <div class="nav-section-title">FitArena</div>
                </div>
                <div class="nav-item">
                    <a class="nav-link {{ request()->routeIs('instructor.fitarena*') ? 'active' : '' }}" href="{{ route('instructor.fitarena.sessions') }}">
                        <i class="nav-icon fas fa-trophy"></i>
                        <span>Arena Sessions</span>
                    </a>
                </div>
                
                <!-- Analytics & Profile -->
                <div class="nav-section">
                    <div class="nav-section-title">Account</div>
                </div>
                <div class="nav-item">
                    <a class="nav-link {{ request()->routeIs('instructor.analytics') ? 'active' : '' }}" href="{{ route('instructor.analytics') }}">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <span>Analytics</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link {{ request()->routeIs('instructor.profile*') ? 'active' : '' }}" href="{{ route('instructor.profile') }}">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <span>Profile</span>
                    </a>
                </div>
                
                <!-- Logout -->
                <div class="nav-item" style="margin-top: 2rem;">
                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                        <button type="submit" class="nav-link" style="background: none; border: none; width: 100%; text-align: left;">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                                    </form>
                </div>
        </div>
    </nav>

    <!-- Main Content -->
        <main class="main-content">
            <!-- Mobile Header with Sidebar Toggle -->
            <div class="mobile-header d-lg-none">
                <button class="mobile-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="mobile-brand">
                    <div class="brand-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="brand-text">fitlley</div>
                </div>
            </div>
            
            <div class="content-wrapper">
                @yield('content')
            </div>
        </main>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        // Mobile sidebar toggle
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('show');
        }
        
        // Active navigation highlighting
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href && currentPath.startsWith(href) && href !== '/') {
                    link.classList.add('active');
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html> 