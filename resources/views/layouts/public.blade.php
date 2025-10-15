<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Fittelly - Live Fitness Sessions')</title>
    <link rel="icon" href="{{ asset('public/favicon.ico') }}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Netflix-inspired Color Palette */
            /* --primary-color: #f7a31a; */
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

            /* Fittlly */
            --primary-color: #F7A31A;
            --primary-color-dark: #c77800;
            /* thoda dark version */
            --black-color: #221f1f;
            --dark-color: #161616;
            --secondary-color: #cecfd1;
            --grey-color: #f5f5f1;
            --white-color: #ffffff;
            --body-fonts: 'Roboto', sans-serif;
            --title-fonts: 'Jost', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            scroll-behavior: auto !important;
        }


        body {
            /* font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; */
            font-family: 'Roboto', sans-serif !important;
            background-color: var(--dark-color);
            color: var(--text-primary);
            line-height: 1.6;
            font-weight: 400;
            overflow-x: hidden;
        }

        /* Highlight style */
        .highlight {
            background-color: yellow;
            color: black;
            border-radius: 16px;
        }

        /* Active match style (current word being focused) */
        .highlight.active {
            background-color: var(--primary-color-dark);
            /* You can choose any color */
            color: white;
            /* Change text color if needed */
        }



        .container {
            max-width: 1400px;
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

        .navbar img {
            width: 13rem;
            object-fit: cover;
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
            margin-left: -2%;
        }

        .navbar-brand:hover {
            color: var(--primary-color);
            text-shadow: 0 0 20px rgba(247, 163, 26, 0.5);
        }

        .navbar-nav {
            gap: 1rem;
            align-items: center;
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
            padding: 0rem 0 2rem !important;
            margin-top: 0rem !important;
        }

        .footer h5 {
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .footer p,
        .footer a {
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

        /* Only apply safe area padding on iOS devices */
        body.is-ios .bottom-navbar {
            padding-bottom: calc(0.5rem + env(safe-area-inset-bottom));
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
            .navbar img {
                width: 10rem;
            }

            .bottom-navbar {
                display: block;
            }

            /* Add bottom padding to prevent content from being hidden behind bottom nav */
            body {
                padding-bottom: 70px;
            }
        }

        /* Responsive For Mobile */
        @media (max-width: 780px) {
            .navbar-toggler {
                display: none !important;
            }

            .navbar {
                padding: 0.5rem 0.8rem;
                backdrop-filter: blur(15px);
                max-height: 3rem;
                display: flex;
                align-items: center;
                justify-content: flex-start;
                flex-wrap: nowrap;
                flex-direction: row;
            }

            .navbar img {
                width: 8rem;
            }

            .navbar.scrolled {
                padding: 0.5rem 0.8rem !important;
                background-color: var(--netflix-black);
            }

            .nav-link {
                padding: 0.4rem 0.6rem !important;
                font-size: 0.9rem;
            }

            .navbar-brand {
                font-size: 1.5rem;
                margin-left: -3rem;
            }

            .navbar-nav {
                gap: 0.8rem;
            }

            .navbar .container .show {
                padding: 0.5rem 0.1rem;
                overflow: hidden;
                margin-top: 0 !important;

            }

            .dropdown-toggle::after {
                content: none;
            }

            .footer {
                display: none;
                margin-top: 0;
                padding: 0 0 1rem !important;
            }

            footer .con-logo {
                margin-bottom: 0.25rem;
            }

            footer .con-logo img {
                margin-bottom: 0.25rem
            }

            /*.bottom-navbar {*/
            /*    display: block;*/
            /*    border: none;*/
            /*    padding: 0 0 0.5rem 0;*/
            /*    bottom: -0.2rem;*/
            /*    backdrop-filter: blur(35px);*/
            /*}*/
            .bottom-navbar {
                display: block;
                border: none;
                padding: 0 0 0.9rem 0;
                bottom: -0.2rem;
                backdrop-filter: blur(35px);
                position: fixed;
                width: 100%;
                left: 0;
            }

            /* Only apply extra safe area padding on iOS devices */
            body.is-ios .bottom-navbar {
                padding-bottom: calc(0.9rem + env(safe-area-inset-bottom));
            }

            /* Optional older iOS fallback */
            @@supports (padding-bottom: constant(safe-area-inset-bottom)) {
                body.is-ios .bottom-navbar {
                    padding-bottom: calc(0.9rem + constant(safe-area-inset-bottom));
                }
            }

            .bottom-nav-icon {
                font-size: 1.2rem;
                margin-bottom: 0rem;
            }

            .bottom-nav-items {
                justify-content: space-evenly;
            }

            .main-content {
                padding-top: 4rem;
            }

            .page-header {
                margin-bottom: 1rem !important;
                padding: 0.7rem;
                font-family: Roboto;
                border-radius: 0.3rem;
            }

            .page-title {
                font-size: 1.2rem;
                font-weight: 500;
                letter-spacing: -0.01em;
            }

            .page-subtitle {
                font-size: 0.7rem;
                color: #bbb7b7 !important;
                font-weight: 200;
            }

            .nav-icon-img {
                width: 24px;
                height: 24px;
                object-fit: contain;
            }


        }

        .container {
            max-width: 1600px !important;
        }

        .fancy-search-input {
            width: 100%;
            padding: 10px 40px 10px 15px;
            border-radius: 25px;
            border: 1px solid var(--fittelly-orange);
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(10px);
            color: #fff;
            font-size: 0.9rem;
            transition: all 0.3s ease-in-out;
        }

        .fancy-search-input::placeholder {
            color: #ddd;
        }

        .fancy-search-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.15);
            border-color: #ff6b00;
            box-shadow: 0 0 5px rgba(255, 107, 0, 0.4);
        }

        .search-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--fittelly-orange);
            pointer-events: none;
        }

        #search-results,
        #mobile-search-results {
            max-height: 300px;
            overflow-y: auto;
            background-color: #fff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 10px 0;
            animation: fadeIn 0.3s ease-in-out;
        }

        .search-item {
            padding: 10px 15px;
            transition: background 0.2s ease;
        }

        .search-item:hover {
            background-color: #f8f9fa;
        }

        .search-item a h5 {
            margin: 0;
            font-size: 0.95rem;
            color: #333;
            font-weight: 500;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 490px) {
            .navbar .container .show {
                padding: 0.5rem 0.1rem;
                overflow: hidden;
                margin-top: 0 !important;
            }

            .dropdown-toggle::after {
                content: none;
            }

            .dropdown-item {
                padding: 0;
            }

        }

        /* Remove dark overlay */
        /* .modal-backdrop.show {
            opacity: 0 !important;
            background-color: transparent !important;
        }

        /* Optional: make modal itself transparent */
        /* .modal-content {
            background: none !important;
            box-shadow: none;
        } */


        /*  */
    </style>
    @stack('styles')
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container mx-2">

            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('storage/app/public/logos/app_logo.png') }}" height="40" class="me-2 ms-3 ms-md-0">
            </a>


            <!-- Desktop search input (hidden on mobile) -->
            <div class="flex-grow-1 position-relative d-none d-md-block" style="min-width: 200px; max-width: 500px;">
                <div class="position-relative">
                    <input type="text" id="live-search" class="form-control fancy-search-input" placeholder="Search..."
                        autocomplete="off" />
                    <i class="fas fa-search search-icon"></i>
                </div>

                <div id="search-results" class="bg-white border rounded"
                    style="position: absolute; top: 100%; left: 0; right: 0; z-index: 999; display: none;">
                    <div id="loading-spinner" style="display: none;">Loading...</div> <!-- Optional spinner -->
                </div>
            </div>

            <!-- Mobile search icon button (visible on mobile only) -->
            <!--<button class="btn btn-outline-light d-block d-md-none ms-3" type="button" data-bs-toggle="modal"-->
            <!--    data-bs-target="#searchModal" aria-label="Open search"-->
            <!--    style="left: 10%;position: relative;border-color: var(--fittelly-orange);color: var(--fittelly-orange);padding: .3rem .5rem;"">-->
            <!--    <i class="fas fa-search"></i>-->
            <!--</button>-->



            {{-- Mobile Auth Section (Visible only on Mobile) --}}
            <div class="d-flex d-lg-none align-items-center" style="margin-right: -1rem;">
                <!-- Mobile search icon -->
                <button class="btn btn-outline-light d-block d-md-none ms-3 btn-sm me-2" type="button"
                    data-bs-toggle="modal" data-bs-target="#searchModal" aria-label="Open search"
                    style="position: relative;border-color: var(--fittelly-orange);color: var(--fittelly-orange);">
                    <i class="fas fa-search"></i>
                </button>

                @auth
                    @php
                        $user = auth()->user();
                        $profilePhoto = $user->avatar ?? null;
                        $initials = strtoupper(
                            substr($user->name, 0, 1) . substr($user->name, strpos($user->name, ' ') + 1, 1),
                        );
                    @endphp

                    <!-- Clean Dropdown -->
                    <div class="dropdown">
                        <a class="d-inline-block text-decoration-none dropdown-toggle" href="#" role="button"
                            id="mobileUserDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            @if ($profilePhoto)
                                <img src="{{ getImagePath($profilePhoto) }}" alt="Profile" class="rounded-circle shadow-sm"
                                    style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <div class="rounded-circle shadow-sm text-uppercase d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px; background: var(--primary-color); color: white; font-weight: 600;">
                                    {{ $initials }}
                                </div>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow rounded-3 mt-2">
                            <li class="dropdown-item d-flex align-items-center">
                                <i class="fas fa-user-circle me-2"></i>{{ $user->name }}
                            </li>
                            <li>
                                <hr class="dropdown-divider bg-white">
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2 text-primary"></i>Dashboard
                                </a>
                            </li>
                            @if ($user->hasRole('admin'))
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-cog me-2 text-warning"></i>Admin Panel
                                    </a>
                                </li>
                            @endif
                            @if ($user->hasRole('instructor'))
                                <li>
                                    <a class="dropdown-item d-flex align-items-center"
                                        href="{{ route('instructor.dashboard') }}">
                                        <i class="fas fa-chalkboard-teacher me-2 text-success"></i>Instructor Panel
                                    </a>
                                </li>
                            @endif
                            <li>
                                <hr class="dropdown-divider bg-white">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item d-flex align-items-center text-danger" type="submit">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm me-2">Login</a>
                @endauth
            </div>




            <button class="navbar-toggler d-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#communityModal">
                            Community
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('fitlive/vdo') ? 'active' : '' }}"
                            href="{{ url('/fitlive/vdo') }}">
                            <!-- <i class="fas fa-newspaper me-1"></i> -->
                            FitFlix
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#communityModal">
                            <!-- <i class="fas fa-film me-1"></i> -->
                            FitTalk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('tools') ? 'active' : '' }}" href="{{ url('/tools') }}">
                            <!-- <i class="fas fa-trophy me-1"></i> -->
                            Tools
                        </a>
                    </li>



                </ul>

                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i>{{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" style="padding: 0 0.9rem;">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                    </a></li>
                                @if (auth()->user()->hasRole('admin'))
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-cog me-2"></i>Admin Panel
                                        </a></li>
                                @endif
                                @if (auth()->user()->hasRole('instructor'))
                                    <li><a class="dropdown-item" href="{{ route('instructor.dashboard') }}">
                                            <i class="fas fa-chalkboard-teacher me-2"></i>Instructor Panel
                                        </a></li>
                                @endif
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
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
                        {{-- <li class="nav-item">
                            <a class="btn btn-primary ms-2" href="{{ route('register') }}">Sign Up</a>
                        </li> --}}
                    @endauth
                </ul>
            </div>

        </div>
    </nav>
    <!-- Search Modal for Mobile -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down" style="height: 100%;">
            <div class="modal-content p-3" style="background: none; max-height: 300px;">

                <!-- Close Button -->
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                    data-bs-dismiss="modal" aria-label="Close"
                    style="background-color: rgba(0,0,0,0.4);padding: 0.8rem;border-radius: 50%;z-index: 9;">
                </button>

                <!-- Search Input with Icon -->
                <div class="position-relative">
                    <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-white"
                        style="z-index: 10;"></i>
                    <input type="text" id="mobile-live-search" class="form-control ps-5 fancy-search-input"
                        placeholder="Search..." autocomplete="off" autofocus />
                </div>

                <!-- Search Results -->
                <div id="mobile-search-results" class="bg-white border rounded mt-2"
                    style="max-height: 300px; overflow-y: auto; display: none;">
                </div>
            </div>
        </div>
    </div>



    <!-- Main Content -->
    <main class="main-content">
        @if (Request::is('/'))
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
                    <img src="{{ Request::is('/')
    ? asset('storage/app/public/navigation-icon/home filled.png')
    : asset('storage/app/public/navigation-icon/home_stroke_grey.png') }}" alt="Home Icon" class="nav-icon-img">
                </div>
                <span class="bottom-nav-label">Home</span>
            </a>


            <a class="bottom-nav-item" href="#" data-bs-toggle="modal" data-bs-target="#communityModal">
                <div class="bottom-nav-icon">
                    <img src="{{ Request::is('fitlive.index')
    ? asset('storage/app/public/navigation-icon/community filled.png')
    : asset('storage/app/public/navigation-icon/community_grey.png') }}" alt="Home Icon" class="nav-icon-img">
                </div>
                <span class="bottom-nav-label">Community</span>
            </a>


            <a href="{{ url('/fitlive/vdo') }}"
                class="bottom-nav-item {{ Request::is('fitlive/vdo') ? 'active' : '' }}">
                <div class="bottom-nav-icon">
                    <img src="{{ Request::is('fitlive/vdo')
    ? asset('storage/app/public/navigation-icon/fitflix filled.png')
    : asset('storage/app/public/navigation-icon/fitflix_stroke_grey.png') }}" alt="Home Icon" class="nav-icon-img">
                </div>
                <span class="bottom-nav-label">FitFlix</span>
            </a>
            <a class="bottom-nav-item" href="#" data-bs-toggle="modal" data-bs-target="#communityModal">
                <div class="bottom-nav-icon">
                    <img src="{{ Request::is('fitarena.index')
    ? asset('storage/app/public/navigation-icon/fittalk new filled.png')
    : asset('storage/app/public/navigation-icon/FitTalk new.png') }}" alt="Home Icon" class="nav-icon-img">
                </div>
                <span class="bottom-nav-label">FitTalk</span>
            </a>
            <a href="{{ url('/tools') }}" class="bottom-nav-item {{ Request::is('tools') ? 'active' : '' }}">
                <div class="bottom-nav-icon">
                    <img src="{{ Request::is('tools')
    ? asset('storage/app/public/navigation-icon/Tool filled.png')
    : asset('storage/app/public/navigation-icon/Tool_grey.png') }}" alt="Home Icon" class="nav-icon-img">
                </div>
                <span class="bottom-nav-label">Tools</span>
            </a>



        </div>
    </nav>

    <!-- Modal -->
    <div class="modal fade" id="communityModal" tabindex="-1" aria-labelledby="communityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="communityModalLabel">Feature Unavailable</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container d-flex justify-content-center align-items-center">
                        <div class="card shadow p-4 text-center"
                            style="max-width: 500px;width: 100%;color: #000000;background: #ffffff !important;">
                            <h2 class="mb-3 text-danger">Feature Unavailable on Web</h2>
                            <p class="mb-4">
                                This feature isn’t accessible in the web version. <br>
                                Download our app to unlock exclusive tools and enjoy the full experience!
                            </p>

                            <div class="d-flex justify-content-center flex-wrap gap-2 mb-4">
                                <a href="#" class="btn btn-primary" style="min-width: 150px;" disabled>
                                    Download on App Store
                                </a>
                                <a href="#" class="btn btn-primary" style="min-width: 150px;" disabled>
                                    Download on Google Play
                                </a>
                            </div>

                            <div class="text-center">
                                <p class="mb-2">Or scan the QR code to get the app instantly.</p>
                                @php
                                    $appUrl1 = url('/');
                                    $appUrl = 'https://www.fittelly.com';
                                    $qrUrl =
                                        'https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=' .
                                        urlencode($appUrl);
                                @endphp

                                <img src="{{ $qrUrl }}" alt="QR Code" class="img-fluid" style="max-width: 180px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <!-- Footer -->
    <footer class="footer text-light pt-5 pb-3">
        <div class="container text-center">
            {{-- Logo centered --}}
            <div class="con-logo mb-3">
                <img src="{{ asset('storage/app/public/app_logo.png') }}" alt="FITTELLY Logo" height="50" class="mb-2">
            </div>

            {{-- Social icons centered --}}
            <div class="mb-3">
                <a href="#" class="text-light me-3 fs-5"><i class="fab fa-facebook"></i></a>
                <a href="#" class="text-light me-3 fs-5"><i class="fab fa-instagram"></i></a>
            </div>

            {{-- Links centered --}}
            <ul class="list-inline mb-2 small">
                <li class="list-inline-item"><a href="{{ route('legal_notice') }}" class="text-light">Legal
                        Notice</a></li>
                <li class="list-inline-item"><a href="{{ route('cookie_preference') }}" class="text-light">Cookie
                        Preference</a></li>
                <li class="list-inline-item"><a href="{{ route('privacy_policy') }}" class="text-light">Privacy
                        Policy</a></li>
                <li class="list-inline-item"><a href="{{ route('refund_policy') }}" class="text-light">Refund
                        Policy</a></li>
                <li class="list-inline-item"><a href="{{ route('terms_condition') }}" class="text-light">Terms &
                        Condition</a></li>
                <li class="list-inline-item"><a href="{{ route('register') }}" class="text-light">Instructor
                        Login</a></li>
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
        // Debounce function to limit API calls while typing
        let debounceTimeout;
        let isSearching = false; // Prevent multiple concurrent AJAX requests

        // Handle typing in the desktop search input
        $('#live-search').on('keyup', async function () {
            try {
                let query = $(this).val().trim();

                if (query.length === 0) {
                    $('#search-results').hide(); // Hide search results if input is empty
                    return;
                }

                // Clear the previous timeout to prevent multiple API calls in a short period
                clearTimeout(debounceTimeout);

                // Set a new timeout for debouncing
                debounceTimeout = setTimeout(async function () {
                    if (isSearching) return; // Prevent multiple requests during ongoing search

                    isSearching = true;
                    $('#loading-spinner').show(); // Show the spinner while fetching results

                    const response = await $.ajax({
                        url: '/search',
                        method: 'GET',
                        data: {
                            query: query
                        }
                    });

                    $('#loading-spinner').hide(); // Hide the spinner after the results are fetched
                    $('#search-results').show();

                    if (response.length === 0) {
                        $('#search-results').html('<p>No results found</p>');
                    } else {
                        let resultsHtml = '';
                        response.forEach(function (item) {
                            resultsHtml += `<div class="search-item">
                            <a href="${item.url}" class="text-decoration-none">
                                <h5>${item.title}</h5>
                            </a>
                        </div>`;
                        });
                        $('#search-results').html(resultsHtml);
                    }

                    isSearching = false; // Reset the flag after the search is complete
                }, 300); // Delay of 300ms after the user stops typing

            } catch (error) {
                // Error handling in case something goes wrong
                $('#loading-spinner').hide();
                $('#search-results').html('<p>Error occurred while searching.</p>');
                console.error('Error during search:', error);
            }
        });

        // Handle typing in the mobile search input
        $('#mobile-live-search').on('keyup', async function () {
            try {
                let query = $(this).val().trim();

                if (query.length === 0) {
                    $('#mobile-search-results').hide(); // Hide search results if input is empty
                    return;
                }

                // Clear the previous timeout to prevent multiple API calls in a short period
                clearTimeout(debounceTimeout);

                // Set a new timeout for debouncing
                debounceTimeout = setTimeout(async function () {
                    if (isSearching) return; // Prevent multiple requests during ongoing search

                    isSearching = true;
                    $('#loading-spinner').show(); // Show the spinner while fetching results

                    const response = await $.ajax({
                        url: '/search',
                        method: 'GET',
                        data: {
                            query: query
                        }
                    });

                    $('#loading-spinner').hide(); // Hide the spinner after the results are fetched
                    $('#mobile-search-results').show();

                    if (response.length === 0) {
                        $('#mobile-search-results').html('<p>No results found</p>');
                    } else {
                        let resultsHtml = '';
                        response.forEach(function (item) {
                            resultsHtml += `<div class="search-item">
                            <a href="${item.url}" class="text-decoration-none">
                                <h5>${item.title}</h5>
                            </a>
                        </div>`;
                        });
                        $('#mobile-search-results').html(resultsHtml);
                    }

                    isSearching = false; // Reset the flag after the search is complete
                }, 300); // Delay of 300ms after the user stops typing

            } catch (error) {
                // Error handling in case something goes wrong
                $('#loading-spinner').hide();
                $('#mobile-search-results').html('<p>Error occurred while searching.</p>');
                console.error('Error during search:', error);
            }
        });

        // Handle focus out (when the user clicks outside the search bar)
        $('#live-search').on('blur', function () {
            setTimeout(function () {
                $('#search-results').hide();
            }, 200);
        });

        $('#mobile-live-search').on('blur', function () {
            setTimeout(function () {
                $('#mobile-search-results').hide();
            }, 200);
        });

        // Handle focus in (when the user clicks inside the search bar again)
        $('#live-search').on('focus', function () {
            let query = $(this).val().trim();
            if (query.length > 0) {
                $('#search-results').show();
            }
        });

        $('#mobile-live-search').on('focus', function () {
            let query = $(this).val().trim();
            if (query.length > 0) {
                $('#mobile-search-results').show();
            }
        });

        // Close modal when clicking outside the modal content (on mobile)
        $(document).on('click', function (e) {
            // Check if the clicked target is the modal backdrop, not the modal content
            if ($(e.target).hasClass('modal') && !$(e.target).closest('.modal-content').length) {
                $('#searchModal').modal('hide'); // Close the modal
            }
        });

        // Optional: Close modal when clicking outside of the modal for desktop search (if necessary)
        $(document).on('click', function (e) {
            if (!$(e.target).closest('#live-search').length && !$(e.target).closest('#search-results').length) {
                $('#search-results').hide();
            }
        });

        // Focus the mobile search input field automatically when modal is shown
        $('#searchModal').on('shown.bs.modal', function () {
            $('#mobile-live-search').focus();
        });
    </script>







    <script>
        // Function to get all horizontally scrollable elements
        function getXScrollableElements() {
            return Array.from(document.querySelectorAll('body *')).filter(el => {
                const style = getComputedStyle(el);
                const hasXScroll = el.scrollWidth > el.clientWidth;
                const overflowX = style.overflowX;
                return hasXScroll && (overflowX === 'auto' || overflowX === 'scroll');
            });
        }

        window.addEventListener('beforeunload', function () {
            const scrollables = getXScrollableElements();
            scrollables.forEach((el, index) => {
                sessionStorage.setItem(`xScroll-${index}`, el.scrollLeft);
            });
        });

        window.addEventListener('load', function () {
            const scrollables = getXScrollableElements();
            setTimeout(() => {
                scrollables.forEach((el, index) => {
                    const saved = sessionStorage.getItem(`xScroll-${index}`);
                    if (saved !== null) {
                        el.scrollLeft = parseInt(saved, 10);
                    }
                });
            }, 10);
        });
    </script>

    <!-- Keep this for header scroll effect -->
    <script>
        $(window).on('scroll', function () {
            if ($(window).scrollTop() > 50) {
                $('.navbar').addClass('scrolled');
            } else {
                $('.navbar').removeClass('scrolled');
            }
        });
    </script>

    <!-- Keep this for iOS safe-area inset handling -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ua = navigator.userAgent;
            const isIOS = /iPhone|iPad|iPod/i.test(ua);
            if (isIOS) {
                document.body.classList.add('is-ios');
            }
        });
    </script>

    <script>
        //     $(document).ready(function() {
        //         var currentMatchIndex = -1; // Track which match we're currently on

        //         // Show the search input and focus it when Ctrl + F is pressed
        //         $(document).keydown(function(e) {
        //             if (e.ctrlKey && e.key === 'f') {
        //                 e.preventDefault(); // Prevent the browser's default find behavior
        //                 $('#live-search').focus(); // Focus on the search input
        //                 return false;
        //             }
        //         });

        //         // Handle live search input
        //         $('#live-search').on('input', function() {
        //             var query = $(this).val().toLowerCase();

        //             // If the search box is empty, clear highlights
        //             if (query.length === 0) {
        //                 removeHighlights();
        //                 return;
        //             }

        //             // Perform the search and highlight matches
        //             highlightText(query);
        //         });

        //         // Handle Enter key to scroll to the next highlighted match
        //         $('#live-search').keydown(function(e) {
        //             var query = $(this).val().toLowerCase();
        //             if (e.key === 'Enter' && query.length > 0) {
        //                 e.preventDefault();
        //                 scrollToNextMatch(query, 1); // Scroll forward
        //             }
        //             // Handle Shift + Enter for backward navigation
        //             else if (e.key === 'Enter' && e.shiftKey && query.length > 0) {
        //                 e.preventDefault();
        //                 scrollToNextMatch(query, -1); // Scroll backward
        //             }
        //         });

        //         // Function to highlight all occurrences of the search query
        //         function highlightText(query) {
        //             // Remove previous highlights first
        //             removeHighlights();

        //             currentMatchIndex = -1; // Reset match index

        //             // Find all text nodes in the body
        //             $('body *').each(function() {
        //                 if ($(this).children().length === 0 && $(this).text().toLowerCase().indexOf(query) !== -
        //                     1) {
        //                     // For each text node, wrap the matching text with a highlight
        //                     var regex = new RegExp('(' + query + ')', 'gi');
        //                     $(this).html($(this).html().replace(regex, '<span class="highlight">$1</span>'));
        //                 }
        //             });

        //             // If there are highlights, immediately scroll to the first match
        //             if ($('.highlight').length > 0) {
        //                 scrollToNextMatch(query, 1);
        //             }
        //         }

        //         // Function to remove all highlights and active classes
        //         function removeHighlights() {
        //             $('span.highlight').each(function() {
        //                 var text = $(this).text();
        //                 $(this).replaceWith(text); // Replace the span with plain text
        //             });
        //         }

        //         // Function to scroll to the next or previous match and highlight it as the active match
        //         function scrollToNextMatch(query, direction) {
        //             var highlighted = $('span.highlight');

        //             // If there are no highlighted elements, return
        //             if (highlighted.length === 0) return;

        //             // Increment/decrement currentMatchIndex based on direction
        //             currentMatchIndex = (currentMatchIndex + direction + highlighted.length) % highlighted.length;

        //             // Remove active class from all highlighted elements
        //             highlighted.removeClass('active');

        //             // Add active class to the current match
        //             $(highlighted[currentMatchIndex]).addClass('active');

        //             // Scroll to the current match with a smooth transition
        //             $('html, body').animate({
        //                 scrollTop: $(highlighted[currentMatchIndex]).offset().top - 100
        //             }, 500);
        //         }
        //     });
    </script>


    @stack('scripts')
</body>

</html>