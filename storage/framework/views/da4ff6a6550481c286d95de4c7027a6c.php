<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Admin Dashboard'); ?> - fitlley</title>
    
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

        .fitarena_status {
            color: #000; /* black */
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
            background: linear-gradient(135deg, rgba(247, 163, 26, 0.85), rgba(247, 163, 26, 0.6));
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
            position: relative;
        }

        .content-wrapper {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Dashboard Specific Styles */
        .admin-dashboard {
            animation: fadeInUp 0.6s ease-out;
        }

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

        /* Dashboard Header */
        .dashboard-header {
            margin-bottom: 3rem;
        }

        .dashboard-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .dashboard-subtitle {
            font-size: 1.125rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        .dashboard-time {
            background: var(--bg-card);
            padding: 1rem 1.5rem;
            border-radius: 16px;
            border: 1px solid var(--border-primary);
            color: var(--text-secondary);
            font-weight: 500;
            box-shadow: var(--shadow-sm);
        }

        /* Statistics Cards */
        .stats-grid {
            margin-bottom: 3rem;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-primary);
            border-radius: 20px;
            padding: 0;
            transition: var(--transition-normal);
            position: relative;
            overflow: hidden;
            height: 100%;
            box-shadow: var(--shadow-md);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
            border-color: var(--border-accent);
        }

        .stat-card-primary::before { background: linear-gradient(90deg, var(--primary-color), var(--primary-light)); }
        .stat-card-success::before { background: linear-gradient(90deg, var(--success), #00e693); }
        .stat-card-info::before { background: linear-gradient(90deg, var(--info), #33b8ff); }
        .stat-card-warning::before { background: linear-gradient(90deg, var(--warning), #ffc84d); }

        .stat-card-body {
            padding: 2rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .stat-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--text-primary);
            background: linear-gradient(135deg, rgba(247, 163, 26, 0.2), rgba(247, 163, 26, 0.1));
            border: 1px solid rgba(247, 163, 26, 0.3);
        }

        .stat-card-success .stat-icon {
            background: linear-gradient(135deg, rgba(0, 208, 132, 0.2), rgba(0, 208, 132, 0.1));
            border-color: rgba(0, 208, 132, 0.3);
        }

        .stat-card-info .stat-icon {
            background: linear-gradient(135deg, rgba(0, 168, 255, 0.2), rgba(0, 168, 255, 0.1));
            border-color: rgba(0, 168, 255, 0.3);
        }

        .stat-card-warning .stat-icon {
            background: linear-gradient(135deg, rgba(255, 176, 32, 0.2), rgba(255, 176, 32, 0.1));
            border-color: rgba(255, 176, 32, 0.3);
        }

        .stat-content {
            flex: 1;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1rem;
            color: var(--text-secondary);
            font-weight: 500;
            margin-bottom: 0.75rem;
        }

        .stat-trend {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .stat-trend i {
            color: var(--success);
        }

        /* Content Cards */
        .content-card {
            background: var(--bg-card);
            border: 1px solid var(--border-primary);
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            transition: var(--transition-normal);
            overflow: hidden;
        }

        .content-card:hover {
            border-color: var(--border-secondary);
            box-shadow: var(--shadow-lg);
        }

        .content-card-header {
            padding: 2rem 2rem 1rem;
            border-bottom: 1px solid var(--border-primary);
            background: linear-gradient(135deg, var(--bg-tertiary), var(--bg-card));
        }

        .content-card-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .content-card-subtitle {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin: 0;
        }

        .content-card-body {
            padding: 2rem;
        }

        /* Action Cards */
        .action-card {
            display: block;
            background: var(--bg-tertiary);
            border: 1px solid var(--border-primary);
            border-radius: 16px;
            padding: 1.5rem;
            text-decoration: none;
            color: var(--text-primary);
            transition: var(--transition-normal);
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(247, 163, 26, 0.05), transparent);
            transition: var(--transition-normal);
        }

        .action-card:hover::before {
            left: 100%;
        }

        .action-card:hover {
            transform: translateY(-4px);
            border-color: var(--border-accent);
            box-shadow: var(--shadow-lg);
            color: var(--text-primary);
        }

        .action-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: var(--bg-primary);
            margin-bottom: 1rem;
            box-shadow: var(--shadow-sm);
        }

        .action-content h4 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .action-content p {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin: 0;
            line-height: 1.5;
        }

        .action-arrow {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            color: var(--text-muted);
            transition: var(--transition-fast);
        }

        .action-card:hover .action-arrow {
            color: var(--primary-color);
            transform: translateX(4px);
        }

        /* System Info */
        .system-info {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .info-item {
            display: flex;
            justify-content: between;
            align-items: center;
            padding: 1rem;
            background: var(--bg-tertiary);
            border-radius: 12px;
            border: 1px solid var(--border-primary);
        }

        .info-label {
            font-size: 0.95rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .info-value {
            font-size: 0.95rem;
            color: var(--text-primary);
            font-weight: 600;
        }

        /* Status Indicator */
        .status-indicator {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .status-online {
            background: var(--success);
        }

        .status-text {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Activity Placeholder */
        .activity-placeholder {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-muted);
        }

        .placeholder-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, rgba(247, 163, 26, 0.1), rgba(247, 163, 26, 0.05));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--primary-color);
            margin: 0 auto 2rem;
            border: 1px solid rgba(247, 163, 26, 0.2);
        }

        .placeholder-content h4 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .placeholder-content p {
            font-size: 1rem;
            color: var(--text-muted);
            margin-bottom: 0;
            line-height: 1.6;
        }

        /* Buttons */
        .btn {
            border-radius: 12px;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border: none;
            transition: var(--transition-fast);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: var(--bg-primary);
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: var(--bg-primary);
        }

        /* Mobile Header */
        .mobile-header {
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border-primary);
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
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
            color: var(--primary-color);
        }

        .mobile-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .mobile-brand .brand-icon {
            width: 32px;
            height: 32px;
            font-size: 1rem;
        }

        .mobile-brand .brand-text {
            font-size: 1.25rem;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .sidebar {
                width: 260px;
            }
            
            .main-content {
                margin-left: 260px;
            }
        }

        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .content-wrapper {
                padding: 1.5rem;
            }
            
            .dashboard-title {
                font-size: 2rem;
            }
            
            .stat-card-body {
                padding: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .content-wrapper {
                padding: 1rem;
            }
            
            .dashboard-header {
                margin-bottom: 2rem;
            }
            
            .dashboard-title {
                font-size: 1.75rem;
            }
            
            .dashboard-subtitle {
                font-size: 1rem;
            }
            
            .stat-card-body {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
            
            .stats-grid {
                margin-bottom: 2rem;
            }
        }

        /* Netflix-inspired Material Design Components */
        
        /* Enhanced Page Header */
        .page-header {
            margin-bottom: 2.5rem;
        }

        .custom-breadcrumb {
            background: none;
            padding: 0;
            margin-bottom: 1rem;
        }

        .breadcrumb-link {
            color: var(--text-muted);
            text-decoration: none;
            transition: var(--transition-fast);
            display: flex;
            align-items: center;
        }

        .breadcrumb-link:hover {
            color: var(--primary-color);
        }

        .breadcrumb-current {
            color: var(--text-secondary);
        }

        .page-title-section {
            display: flex;
            align-items: center;
        }

        .page-title {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin: 0;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .title-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--bg-primary);
            box-shadow: var(--shadow-md);
        }

        .title-content {
            display: flex;
            flex-direction: column;
        }

        .title-main {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .title-subtitle {
            font-size: 1.125rem;
            color: var(--text-muted);
            font-weight: 400;
            margin-top: 0.25rem;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        /* Enhanced Alert System */
        .custom-alert {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.5rem;
            border-radius: 16px;
            border: none;
            position: relative;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(0, 208, 132, 0.15), rgba(0, 208, 132, 0.05));
            border-left: 4px solid var(--success);
        }

        .alert-error {
            background: linear-gradient(135deg, rgba(229, 9, 20, 0.15), rgba(229, 9, 20, 0.05));
            border-left: 4px solid var(--error);
        }

        .alert-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.125rem;
        }

        .alert-success .alert-icon {
            background: rgba(0, 208, 132, 0.2);
            color: var(--success);
        }

        .alert-error .alert-icon {
            background: rgba(229, 9, 20, 0.2);
            color: var(--error);
        }

        .alert-content {
            flex: 1;
        }

        .alert-title {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .alert-message {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .alert-close {
            background: none;
            border: none;
            color: var(--text-muted);
            padding: 0.5rem;
            border-radius: 8px;
            transition: var(--transition-fast);
        }

        .alert-close:hover {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-primary);
        }

        /* Netflix-style Cards */
        .netflix-card {
            background: var(--bg-card);
            border: 1px solid var(--border-primary);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            transition: var(--transition-normal);
            position: relative;
        }

        .netflix-card:hover {
            border-color: var(--border-secondary);
            box-shadow: var(--shadow-xl);
            transform: translateY(-4px);
        }

        .netflix-card .card-header {
            background: linear-gradient(135deg, var(--bg-tertiary), var(--bg-card));
            padding: 2rem;
            border-bottom: 1px solid var(--border-primary);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .netflix-card .header-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: var(--bg-primary);
            box-shadow: var(--shadow-sm);
        }

        .netflix-card .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            flex: 1;
        }

        .netflix-card .header-badge {
            background: rgba(247, 163, 26, 0.2);
            color: var(--primary-color);
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
            border: 1px solid rgba(247, 163, 26, 0.3);
        }

        .netflix-card .card-body {
            padding: 2rem;
        }

        /* Series Information Styling */
        .series-poster {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            aspect-ratio: 3/4;
            box-shadow: var(--shadow-lg);
        }

        .poster-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition-normal);
        }

        .poster-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent 50%, rgba(0, 0, 0, 0.8));
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: var(--transition-normal);
        }

        .series-poster:hover .poster-overlay {
            opacity: 1;
        }

        .series-poster:hover .poster-image {
            transform: scale(1.05);
        }

        .play-button {
            width: 64px;
            height: 64px;
            background: rgba(247, 163, 26, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--bg-primary);
            transition: var(--transition-fast);
        }

        .play-button:hover {
            background: var(--primary-color);
            transform: scale(1.1);
        }

        .poster-placeholder {
            width: 100%;
            height: 100%;
            background: var(--bg-tertiary);
            border: 2px dashed var(--border-primary);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 2rem;
        }

        .poster-placeholder span {
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .series-details {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .series-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .series-description {
            color: var(--text-secondary);
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            flex: 1;
        }

        .metadata-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: var(--bg-tertiary);
            border-radius: 12px;
            border: 1px solid var(--border-primary);
            transition: var(--transition-fast);
        }

        .meta-item:hover {
            border-color: var(--border-secondary);
            transform: translateY(-2px);
        }

        .meta-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, rgba(247, 163, 26, 0.2), rgba(247, 163, 26, 0.1));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            border: 1px solid rgba(247, 163, 26, 0.3);
        }

        .meta-content {
            display: flex;
            flex-direction: column;
        }

        .meta-label {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .meta-value {
            font-size: 1rem;
            color: var(--text-primary);
            font-weight: 600;
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
            border: 1px solid;
        }

        .status-published {
            background: rgba(0, 208, 132, 0.15);
            color: var(--success);
            border-color: rgba(0, 208, 132, 0.3);
        }

        .status-draft {
            background: rgba(255, 176, 32, 0.15);
            color: var(--warning);
            border-color: rgba(255, 176, 32, 0.3);
        }

        /* Seasons Grid */
        .seasons-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
        }

        .season-card {
            background: var(--bg-tertiary);
            border: 1px solid var(--border-primary);
            border-radius: 16px;
            overflow: hidden;
            transition: var(--transition-normal);
            position: relative;
        }

        .season-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
            border-color: var(--border-secondary);
        }

        .season-poster {
            position: relative;
            aspect-ratio: 16/9;
            overflow: hidden;
        }

        .season-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition-normal);
        }

        .season-image-placeholder {
            width: 100%;
            height: 100%;
            background: var(--bg-secondary);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 2rem;
        }

        .season-image-placeholder span {
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .season-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3), transparent 30%, transparent 70%, rgba(0, 0, 0, 0.8));
            opacity: 0;
            transition: var(--transition-normal);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 1rem;
        }

        .season-card:hover .season-overlay {
            opacity: 1;
        }

        .season-card:hover .season-image {
            transform: scale(1.05);
        }

        .season-number-badge {
            background: rgba(247, 163, 26, 0.9);
            color: var(--bg-primary);
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.875rem;
            align-self: flex-start;
            backdrop-filter: blur(10px);
        }

        .season-actions {
            display: flex;
            gap: 0.5rem;
            align-self: flex-end;
        }

        .season-actions .btn {
            padding: 0.5rem;
            border-radius: 8px;
            backdrop-filter: blur(10px);
            border: none;
            transition: var(--transition-fast);
        }

        .season-actions .btn-primary {
            background: rgba(247, 163, 26, 0.9);
            color: var(--bg-primary);
        }

        .season-actions .btn-warning {
            background: rgba(255, 176, 32, 0.9);
            color: var(--bg-primary);
        }

        .season-actions .btn-danger {
            background: rgba(229, 9, 20, 0.9);
            color: white;
        }

        .season-actions .btn:hover {
            transform: scale(1.1);
        }

        .season-info {
            padding: 1.5rem;
        }

        .season-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
            line-height: 1.3;
        }

        .season-description {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        .season-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .stat-item i {
            color: var(--primary-color);
        }

        .status-indicator {
            font-weight: 500;
        }

        .status-indicator.status-published {
            color: var(--success);
        }

        .status-indicator.status-draft {
            color: var(--warning);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-illustration {
            max-width: 400px;
            margin: 0 auto;
        }

        .empty-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, rgba(247, 163, 26, 0.15), rgba(247, 163, 26, 0.05));
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: var(--primary-color);
            margin: 0 auto 2rem;
            border: 2px solid rgba(247, 163, 26, 0.2);
        }

        .empty-content h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .empty-content p {
            font-size: 1.1rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        /* Enhanced Modal Styling */
        .netflix-modal {
            background: var(--bg-card);
            border: 1px solid var(--border-primary);
            border-radius: 20px;
            box-shadow: var(--shadow-xl);
        }

        .netflix-modal .modal-header {
            background: linear-gradient(135deg, var(--bg-tertiary), var(--bg-card));
            border-bottom: 1px solid var(--border-primary);
            border-radius: 20px 20px 0 0;
            padding: 2rem;
        }

        .modal-title-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .modal-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.125rem;
            color: var(--bg-primary);
        }

        .netflix-modal .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .netflix-modal .btn-close {
            background: var(--bg-hover);
            border: 1px solid var(--border-primary);
            border-radius: 8px;
            padding: 0.5rem;
            color: var(--text-muted);
            opacity: 1;
            transition: var(--transition-fast);
        }

        .netflix-modal .btn-close:hover {
            background: var(--bg-tertiary);
            color: var(--text-primary);
            transform: scale(1.1);
        }

        .netflix-modal .modal-body {
            padding: 2rem;
        }

        /* Form Styling */
        .form-section {
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--border-primary);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            background: var(--bg-tertiary);
            border: 1px solid var(--border-primary);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            color: var(--text-primary);
            font-size: 0.95rem;
            transition: var(--transition-fast);
        }

        .form-control:focus {
            background: var(--bg-secondary);
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(247, 163, 26, 0.1);
            color: var(--text-primary);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .form-hint {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-top: 0.25rem;
        }

        /* Enhanced Button Styling */
        .btn {
            border-radius: 12px;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border: none;
            transition: var(--transition-fast);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: var(--transition-normal);
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: var(--bg-primary);
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: var(--bg-primary);
        }

        .btn-lg {
            padding: 1rem 2rem;
            font-size: 1rem;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .btn-outline-secondary {
            background: transparent;
            color: var(--text-secondary);
            border: 1px solid var(--border-primary);
        }

        .btn-outline-secondary:hover {
            background: var(--bg-hover);
            color: var(--text-primary);
            border-color: var(--border-secondary);
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning), #ffc84d);
            color: var(--bg-primary);
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--error), #ff1f32);
            color: white;
        }

        /* Episodes List Styling */
        .episodes-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .episode-card {
            background: var(--bg-tertiary);
            border: 1px solid var(--border-primary);
            border-radius: 16px;
            overflow: hidden;
            transition: var(--transition-normal);
            display: flex;
            position: relative;
        }

        .episode-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
            border-color: var(--border-secondary);
        }

        .episode-thumbnail {
            position: relative;
            width: 300px;
            aspect-ratio: 16/9;
            overflow: hidden;
            flex-shrink: 0;
        }

        .episode-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition-normal);
        }

        .thumbnail-placeholder {
            width: 100%;
            height: 100%;
            background: var(--bg-secondary);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 2rem;
        }

        .thumbnail-placeholder span {
            font-size: 0.875rem;
            margin-top: 0.5rem;
            font-weight: 600;
        }

        .episode-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.4), transparent 30%, transparent 70%, rgba(0, 0, 0, 0.8));
            opacity: 0;
            transition: var(--transition-normal);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 1rem;
        }

        .episode-card:hover .episode-overlay {
            opacity: 1;
        }

        .episode-card:hover .episode-image {
            transform: scale(1.05);
        }

        .episode-number-badge {
            background: rgba(247, 163, 26, 0.95);
            color: var(--bg-primary);
            padding: 0.25rem 0.75rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            align-self: flex-start;
            backdrop-filter: blur(10px);
        }

        .episode-actions {
            display: flex;
            gap: 0.5rem;
            align-self: flex-end;
        }

        .episode-actions .btn {
            padding: 0.5rem;
            border-radius: 8px;
            backdrop-filter: blur(10px);
            border: none;
            transition: var(--transition-fast);
        }

        .episode-actions .btn:hover {
            transform: scale(1.1);
        }

        .episode-content {
            flex: 1;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
        }

        .episode-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .episode-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            line-height: 1.3;
            flex: 1;
            margin-right: 1rem;
        }

        .episode-meta-badges {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            flex-shrink: 0;
        }

        .badge-free {
            background: linear-gradient(135deg, var(--success), #00e693);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .episode-description {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 1.5rem;
            flex: 1;
        }

        .episode-metadata {
            margin-top: auto;
        }

        .meta-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .stat-icon {
            width: 24px;
            height: 24px;
            background: linear-gradient(135deg, rgba(247, 163, 26, 0.2), rgba(247, 163, 26, 0.1));
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 0.75rem;
            border: 1px solid rgba(247, 163, 26, 0.3);
        }

        .stat-value {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Responsive Episodes */
        @media (max-width: 768px) {
            .episode-card {
                flex-direction: column;
            }

            .episode-thumbnail {
                width: 100%;
                aspect-ratio: 16/9;
            }

            .episode-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }

            .episode-meta-badges {
                align-self: flex-start;
            }

            .meta-stats {
                gap: 1rem;
            }
        }

        /* Enhanced Form Elements */
        .form-switch {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .form-switch input[type="checkbox"] {
            appearance: none;
            width: 48px;
            height: 24px;
            background: var(--bg-tertiary);
            border: 1px solid var(--border-primary);
            border-radius: 12px;
            position: relative;
            cursor: pointer;
            transition: var(--transition-fast);
        }

        .form-switch input[type="checkbox"]:checked {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-switch input[type="checkbox"]::before {
            content: '';
            position: absolute;
            top: 1px;
            left: 1px;
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            transition: var(--transition-fast);
            box-shadow: var(--shadow-sm);
        }

        .form-switch input[type="checkbox"]:checked::before {
            transform: translateX(24px);
        }

        .form-switch label {
            font-weight: 500;
            color: var(--text-primary);
            cursor: pointer;
            margin: 0;
        }

        .form-file {
            position: relative;
            display: block;
        }

        .form-file input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .form-file-label {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: var(--bg-tertiary);
            border: 2px dashed var(--border-primary);
            border-radius: 12px;
            transition: var(--transition-fast);
            cursor: pointer;
        }

        .form-file:hover .form-file-label {
            border-color: var(--primary-color);
            background: rgba(247, 163, 26, 0.05);
        }

        .form-file-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, rgba(247, 163, 26, 0.2), rgba(247, 163, 26, 0.1));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 1.125rem;
        }

        .form-file-content {
            flex: 1;
        }

        .form-file-title {
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .form-file-description {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin: 0;
        }

        .form-select {
            background: var(--bg-tertiary);
            border: 1px solid var(--border-primary);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            color: var(--text-primary);
            font-size: 0.95rem;
            transition: var(--transition-fast);
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

        .form-select:focus {
            background: var(--bg-secondary);
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(247, 163, 26, 0.1);
            color: var(--text-primary);
        }

        .form-select option {
            background: var(--bg-card);
            color: var(--text-primary);
        }

        /* Modal Footer Styling */
        .netflix-modal .modal-footer {
            background: linear-gradient(135deg, var(--bg-tertiary), var(--bg-card));
            border-top: 1px solid var(--border-primary);
            padding: 1.5rem 2rem;
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        /* Elevation Classes */
        .elevation-1 {
            box-shadow: var(--shadow-sm);
        }

        .elevation-2 {
            box-shadow: var(--shadow-md);
        }

        .elevation-3 {
            box-shadow: var(--shadow-lg);
        }

        .elevation-4 {
            box-shadow: var(--shadow-xl);
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

        .user-email {
            color: var(--text-secondary);
            font-size: 0.9rem;
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

        .role-none {
            background: linear-gradient(135deg, rgba(107, 107, 107, 0.15), rgba(107, 107, 107, 0.05));
            color: var(--text-disabled);
            border: 1px solid rgba(107, 107, 107, 0.2);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.375rem 0.75rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-active {
            background: linear-gradient(135deg, rgba(0, 208, 132, 0.15), rgba(0, 208, 132, 0.05));
            color: var(--success);
            border: 1px solid rgba(0, 208, 132, 0.2);
        }

        .status-inactive {
            background: linear-gradient(135deg, rgba(229, 9, 20, 0.15), rgba(229, 9, 20, 0.05));
            color: var(--error);
            border: 1px solid rgba(229, 9, 20, 0.2);
        }

        .status-pending {
            background: linear-gradient(135deg, rgba(255, 176, 32, 0.15), rgba(255, 176, 32, 0.05));
            color: var(--warning);
            border: 1px solid rgba(255, 176, 32, 0.2);
        }

        /* Date Info */
        .date-info {
            text-align: left;
        }

        .date-primary {
            font-weight: 500;
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        .date-secondary {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            transition: var(--transition-fast);
            cursor: pointer;
        }

        .action-btn-primary {
            background: linear-gradient(135deg, rgba(0, 168, 255, 0.15), rgba(0, 168, 255, 0.05));
            color: var(--info);
            border: 1px solid rgba(0, 168, 255, 0.2);
        }

        .action-btn-primary:hover {
            background: linear-gradient(135deg, rgba(0, 168, 255, 0.25), rgba(0, 168, 255, 0.1));
            transform: translateY(-2px);
        }

        .action-btn-warning {
            background: linear-gradient(135deg, rgba(255, 176, 32, 0.15), rgba(255, 176, 32, 0.05));
            color: var(--warning);
            border: 1px solid rgba(255, 176, 32, 0.2);
        }

        .action-btn-warning:hover {
            background: linear-gradient(135deg, rgba(255, 176, 32, 0.25), rgba(255, 176, 32, 0.1));
            transform: translateY(-2px);
        }

        .action-btn-danger {
            background: linear-gradient(135deg, rgba(229, 9, 20, 0.15), rgba(229, 9, 20, 0.05));
            color: var(--error);
            border: 1px solid rgba(229, 9, 20, 0.2);
        }

        .action-btn-danger:hover {
            background: linear-gradient(135deg, rgba(229, 9, 20, 0.25), rgba(229, 9, 20, 0.1));
            transform: translateY(-2px);
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

        /* Role and Permission specific styles */
        .role-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .role-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--bg-primary);
            font-size: 1.1rem;
        }

        .role-details {
            flex: 1;
        }

        .role-name {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.95rem;
        }

        .role-description {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .permissions-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.25rem;
        }

        .permission-badge {
            background: linear-gradient(135deg, rgba(0, 168, 255, 0.15), rgba(0, 168, 255, 0.05));
            color: var(--info);
            border: 1px solid rgba(0, 168, 255, 0.2);
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 500;
        }

        .permission-badge.more {
            background: linear-gradient(135deg, rgba(107, 107, 107, 0.15), rgba(107, 107, 107, 0.05));
            color: var(--text-muted);
            border: 1px solid rgba(107, 107, 107, 0.2);
        }

        .user-count {
            display: flex;
            align-items: center;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .date {
            font-weight: 500;
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        .time {
            font-size: 0.8rem;
            color: var(--text-muted);
        }
        
        /* New css for badges cards */
        /* Dashboard Card Styles */
        .dashboard-card {
            background: var(--bg-card);
            border: 1px solid var(--border-primary);
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            margin-bottom: 1.5rem;
        }

        .dashboard-card .card-header {
            background: var(--bg-card);
            border-bottom: 1px solid var(--border-primary);
            padding: 1.5rem;
        }

        .dashboard-card .card-body {
            background: var(--bg-card);
            padding: 1.5rem;
        }

        .dashboard-card .card-footer {
            background: var(--bg-card);
            border-top: 1px solid var(--border-primary);
            padding: 1rem 1.5rem;
        }

        .dashboard-card .card-title {
            color: var(--text-primary);
            font-weight: 600;
            margin: 0;
        }

        .dashboard-card .card-subtitle {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin: 0.5rem 0 0 0;
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-brand">
                    <div class="brand-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="brand-text">fitlley</div>
                </a>
            </div>
            
            <div class="sidebar-nav">
                <div class="nav-item">
                    <a class="nav-link active" href="<?php echo e(route('admin.dashboard')); ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.users')); ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.roles')); ?>">
                        <i class="nav-icon fas fa-user-tag"></i>
                        <span>Roles</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.permissions')); ?>">
                        <i class="nav-icon fas fa-key"></i>
                        <span>Permissions</span>
                    </a>
                </div>
                
                <!-- Content Studio Section -->
                <div class="nav-section">
                    <div class="nav-section-title">Content Studio</div>
                </div>
                
                <!-- FitLive Section -->
                <div class="nav-section">
                    <div class="nav-section-title">FitLive</div>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.fitlive.categories.index')); ?>">
                        <i class="nav-icon fas fa-folder"></i>
                        <span>Categories</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.fitlive.subcategories.index')); ?>">
                        <i class="nav-icon fas fa-folder-open"></i>
                        <span>Subcategories</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.fitlive.sessions.index')); ?>">
                        <i class="nav-icon fas fa-broadcast-tower"></i>
                        <span>Live Sessions</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.fitlive.archive.index')); ?>">
                        <i class="nav-icon fas fa-archive"></i>
                        <span>Archive</span>
                    </a>
                </div>
                
                <!-- FitNews Section -->
                <div class="nav-section">
                    <div class="nav-section-title">FitNews</div>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.fitnews.index')); ?>">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <span>News Streams</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.fitnews.archive.index')); ?>">
                        <i class="nav-icon fas fa-archive"></i>
                        <span>Archive</span>
                    </a>
                </div>
                
                <!-- FitGuide Section -->
                <div class="nav-section">
                    <div class="nav-section-title">FitGuide</div>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.fitguide.index')); ?>">
                        <i class="nav-icon fas fa-book"></i>
                        <span>Overview</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.fitguide.categories.index')); ?>">
                        <i class="nav-icon fas fa-folder"></i>
                        <span>Categories</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.fitguide.subcategories.index')); ?>">
                        <i class="nav-icon fas fa-folder-open"></i>
                        <span>Subcategories</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.fitguide.single.index')); ?>">
                        <i class="nav-icon fas fa-play-circle"></i>
                        <span>Single Videos</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.fitguide.series.index')); ?>">
                        <i class="nav-icon fas fa-video"></i>
                        <span>Series</span>
                    </a>
                </div>
                
                <!-- FitDoc Section -->
                <div class="nav-section">
                    <div class="nav-section-title">FitDoc</div>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.fitdoc.index')); ?>">
                        <i class="nav-icon fas fa-file-medical"></i>
                        <span>Overview</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.fitdoc.single.index')); ?>">
                        <i class="nav-icon fas fa-play-circle"></i>
                        <span>Single Videos</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.fitdoc.series.index')); ?>">
                        <i class="nav-icon fas fa-video"></i>
                        <span>Series</span>
                    </a>
                </div>
                
                <!-- FitInsight Section -->
                <div class="nav-section">
                    <div class="nav-section-title">FitInsight</div>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.fitinsight.categories.index')); ?>">
                        <i class="nav-icon fas fa-tags"></i>
                        <span>Categories</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.fitinsight.blogs.index')); ?>">
                        <i class="nav-icon fas fa-blog"></i>
                        <span>Blogs</span>
                    </a>
                </div>
                
                <!-- FitArena Live Section -->
                <div class="nav-section">
                    <div class="nav-section-title">FitArena Live</div>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.fitarena.index')); ?>">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <span>All Events</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.fitarena.create')); ?>">
                        <i class="nav-icon fas fa-plus-circle"></i>
                        <span>Create Event</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.fitarena.index')); ?>?status=live">
                        <i class="nav-icon fas fa-broadcast-tower text-danger"></i>
                        <span>Live Events</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.fitarena.index')); ?>?status=upcoming">
                        <i class="nav-icon fas fa-clock text-warning"></i>
                        <span>Upcoming Events</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.fitarena.index')); ?>?featured=1">
                        <i class="nav-icon fas fa-star text-warning"></i>
                        <span>Featured Events</span>
                    </a>
                </div>
                
                <!-- Community Section -->
                <div class="nav-section">
                    <div class="nav-section-title">Community</div>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.community.dashboard')); ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.community.posts.index')); ?>">
                        <i class="nav-icon fas fa-comments"></i>
                        <span>Posts</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.community.categories.index')); ?>">
                        <i class="nav-icon fas fa-folder"></i>
                        <span>Post Categories</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.community.groups.index')); ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <span>Groups</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.community.badges.index')); ?>">
                        <i class="nav-icon fas fa-medal"></i>
                        <span>Badges</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.community.moderation.index')); ?>">
                        <i class="nav-icon fas fa-shield-alt"></i>
                        <span>Moderation</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.community.fittalk.index')); ?>">
                        <i class="nav-icon fas fa-phone-alt"></i>
                        <span>FitTalk Sessions</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.community.fitflix-shorts.index')); ?>">
                        <i class="nav-icon fas fa-mobile-alt"></i>
                        <span>FitFlix Shorts</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.community.fitflix-shorts.categories.index')); ?>">
                        <i class="nav-icon fas fa-folder"></i>
                        <span>Shorts Categories</span>
                    </a>
                </div>
                
                <!-- Website Management Section -->
                <div class="nav-section">
                    <div class="nav-section-title">Website</div>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.homepage.hero.index')); ?>">
                        <i class="nav-icon fas fa-home"></i>
                        <span>Homepage Heroes</span>
                    </a>
                </div>

                <!-- Subscription Management Section -->
                <div class="nav-section">
                    <div class="nav-section-title">Subscription Management</div>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.subscriptions.plans.index')); ?>">
                        <i class="nav-icon fas fa-credit-card"></i>
                        <span>Subscription Plans</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.subscriptions.index')); ?>">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <span>User Subscriptions</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.subscriptions.analytics')); ?>">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <span>Subscription Analytics</span>
                    </a>
                </div>

                <!-- Influencer Program Section -->
                <div class="nav-section">
                    <div class="nav-section-title">Influencer Program</div>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.influencers.index')); ?>">
                        <i class="nav-icon fas fa-user-check"></i>
                        <span>Applications</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.influencers.index')); ?>">
                        <i class="nav-icon fas fa-star"></i>
                        <span>Approved Influencers</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.influencers.payouts.index')); ?>">
                        <i class="nav-icon fas fa-money-bill-wave"></i>
                        <span>Commission Payouts</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.influencers.analytics')); ?>">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <span>Performance Analytics</span>
                    </a>
                </div>

                <!-- Referral System Section -->
                <div class="nav-section">
                    <div class="nav-section-title">Referral System</div>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.subscriptions.referrals.index')); ?>">
                        <i class="nav-icon fas fa-ticket-alt"></i>
                        <span>Referral Codes</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.subscriptions.referrals.index')); ?>">
                        <i class="nav-icon fas fa-exchange-alt"></i>
                        <span>Usage Tracking</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.subscriptions.referrals.analytics')); ?>">
                        <i class="nav-icon fas fa-analytics"></i>
                        <span>Referral Analytics</span>
                    </a>
                </div>

                <!-- Community Section -->
                <div class="nav-section">
                    <div class="nav-section-title">Community</div>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.community.fitflix-shorts.index')); ?>">
                        <i class="nav-icon fas fa-mobile-alt"></i>
                        <span>FitFlix Shorts</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.community.fitflix-shorts.categories.index')); ?>">
                        <i class="nav-icon fas fa-folder"></i>
                        <span>Shorts Categories</span>
                    </a>
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
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="brand-text">fitlley</div>
                </div>
            </div>
            
            <div class="content-wrapper">
                <?php echo $__env->yieldContent('content'); ?>
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
                link.classList.remove('active');
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html> 
<?php /**PATH C:\xampp\htdocs\Digi_Laravel_Prrojects\Fittelly_github\fittley\resources\views/layouts/admin.blade.php ENDPATH**/ ?>