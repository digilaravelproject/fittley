@extends('layouts.public')

@section('title', 'Strength & Conditioning')

@push('styles')
    <style>
        /* ============================
                                                       CSS Variables & Reset
                                                     ============================ */
        :root {
            --primary-color: #F7A31A;
            --primary-color-dark: #c77800;
            --black-color: #221f1f;
            --dark-color: #161616;
            --secondary-color: #cecfd1;
            --grey-color: #f5f5f1;
            --white-color: #ffffff;
            --body-fonts: 'Roboto', sans-serif;
            --title-fonts: 'Jost', sans-serif;

            --bg-primary: #0a0a0a;
            --bg-secondary: #141414;
            --bg-card: #1f1f1f;
            --bg-hover: #2a2a2a;

            --text-primary: #ffffff;
            --text-muted: #b3b3b3;

            --border-primary: #333333;
            --border-accent: var(--primary-color);

            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.3);
            --shadow-lg: 0 8px 16px rgba(0, 0, 0, 0.5);

            --transition-fast: 0.15s ease-in-out;
            --transition-normal: 0.3s ease-in-out;
        }

        body {
            background: var(--dark-color);
            font-family: var(--body-fonts);
            font-size: 1rem;
            line-height: 1.6;
            color: var(--secondary-color);
            overflow-x: hidden;
        }

        /* ============================
                                                       Buttons & Activity Tabs
                                                     ============================ */
        .activity-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            background-color: transparent;
            color: var(--white-color);
            border: 2px solid #171717;
            cursor: pointer;
            white-space: nowrap;
            transition: background var(--transition-fast), color var(--transition-fast), transform 0.2s ease;
        }

        .activity-btn:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: var(--text-primary);
        }

        .activity-btn.active,
        .activity-btn.active:hover {
            background-color: var(--primary-color-dark);
            border-color: var(--primary-color-dark);
            color: var(--text-primary);
            box-shadow: var(--shadow-sm);
            transform: scale(1.03);
        }

        .activity-btn-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            padding-left: 0.375rem;
        }

        .activity-btn-container::-webkit-scrollbar {
            display: none;
        }

        /* ============================
                                                       Video Section
                                                     ============================ */
        .gen-video-holder {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%;
            /* 16:9 aspect ratio */
            height: 0;
            overflow: hidden;
        }

        .gen-video-holder iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100% !important;
            height: 100% !important;
            border: none;
        }

        /* ============================
                                                       Meta Info & Description
                                                     ============================ */
        .gen-single-movie-info {
            margin-top: 1rem;
            width: 100%;
        }

        .gen-single-movie-info .gen-single-meta-holder ul {
            margin: 5px 0 10px;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
        }

        .gen-single-movie-info .gen-single-meta-holder ul li.gen-sen-rating {
            padding: 2px 6px;
            background: var(--primary-color);
            border-radius: 4px;
            color: var(--text-primary);
            font-size: 14px;
            margin-right: 12px;
        }

        .gen-single-movie-info .gen-single-meta-holder ul li {
            list-style: none;
            display: flex;
            align-items: center;
            margin: 6px 12px 0 0;
            padding-right: 12px;
            font-size: 15px;
            color: var(--white-color);
            font-family: var(--title-fonts);
            border-right: 2px solid var(--white-color);
        }

        .gen-single-movie-info .gen-single-meta-holder ul li:last-child {
            border-right: 0;
            margin-right: 0;
            padding-right: 0;
        }

        .gen-single-movie-info .gen-single-meta-holder ul li i {
            margin-right: 5px;
        }

        .gen-single-movie-info p {
            font-size: 1rem;
            color: var(--text-muted);
        }

        /* ============================
                                                       After Excerpt / Details & Sessions
                                                     ============================ */
        .gen-after-excerpt {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 3px solid var(--primary-color);
            padding-bottom: 40px;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .gen-extra-data ul {
            list-style: none;
            padding: 0;
            margin: 0 0 30px 0;
        }

        .gen-extra-data ul li {
            margin-bottom: 10px;
            display: flex;
        }

        .gen-extra-data ul li span:first-child {
            display: inline-block;
            width: 160px;
            font-weight: 500;
            color: var(--secondary-color);
        }

        .gen-extra-data ul li span:last-child {
            color: var(--white-color);
        }

        .gen-social-share {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            width: 70%;
        }

        .live-card {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            padding: 15px;
            background-color: var(--bg-card);
            flex: 1 1 100%;
            transition: transform .2s ease;
        }

        .live-card:hover {
            transform: scale(1.02);
        }

        .live-indicator,
        .live-indicator-green {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            position: relative;
            margin-bottom: 10px;
        }

        .live-indicator:before {
            content: "UPCOMING";
            position: absolute;
            left: 18px;
            font-size: 12px;
            font-weight: 600;
            color: #ff3e3e;
        }

        .live-indicator {
            background-color: #ff3e3e;
        }

        .live-indicator-green {
            background-color: #32cd32;
        }

        .live-indicator-green:before {
            content: "LIVE";
            position: absolute;
            left: 18px;
            font-size: 12px;
            font-weight: 600;
            color: #32cd32;
        }

        .session-info {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .session-time {
            font-size: 16px;
            font-weight: 600;
            color: var(--white-color);
        }

        .instructor-name {
            font-size: 14px;
            color: var(--secondary-color);
        }

        .btn-outline-warning {
            background: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 4px;
            transition: var(--transition-fast);
        }

        .btn-outline-warning:hover {
            background: var(--primary-color);
            color: var(--text-primary);
        }

        /* ============================
                                                       Archived Section Cards
                                                     ============================ */
        .archived-section .card {
            background-color: var(--bg-card);
            border: none;
            color: var(--white-color);
            transition: transform .2s ease;
        }

        .archived-section .card:hover {
            transform: translateY(-5px);
            background-color: var(--bg-hover);
        }

        .archived-section .card .card-img-top {
            object-fit: cover;
        }

        /* ============================
                                                       MEDIA QUERIES / BREAKPOINTS
                                                     ============================ */

        @media (max-width: 767.98px) {
            .activity-btn {
                padding: 6px 12px;
                font-size: 14px;
            }

            .gen-after-excerpt {
                flex-direction: column;
                align-items: flex-start;
            }

            .gen-extra-data ul li span:first-child {
                width: 130px;
            }

            .gen-single-meta-holder ul {
                flex-wrap: wrap;
            }
        }

        @media (min-width: 576px) {
            .gen-social-share {
                display: flex;
                flex-wrap: wrap;
                gap: 12px;
                width: 100%;
            }

            .live-card {
                flex: 0 0 calc(50% - 10px);
            }
        }

        @media (min-width: 992px) {
            .live-card {
                flex: 0 0 calc(33.333% - 12px);
            }
        }

        @media (max-width: 575.98px) {

            .archived-section .col-md-4,
            .archived-section .col-lg-3 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
    </style>
@endpush

@section('content')
    <div class="py-3">
        @php
            $activityTypes = [
                ['label' => 'Strength', 'icon' => 'fas fa-dumbbell', 'route' => 'strength'],
                ['label' => 'HIIT', 'icon' => 'fas fa-bolt', 'route' => 'hiit'],
                ['label' => 'Yoga', 'icon' => 'fas fa-person-praying', 'route' => 'yoga'],
                ['label' => 'Zumba', 'icon' => 'fas fa-music', 'route' => 'zumba'],
                ['label' => 'Meditation', 'icon' => 'fas fa-spa', 'route' => 'meditation'],
            ];
        @endphp

        <!-- Activity Buttons -->
        <div class="container mb-4">
            <div class="d-flex justify-content-start gap-2 activity-btn-container">
                @foreach ($activityTypes as $activity)
                    <a href="/{{ $activity['route'] }}"
                        class="activity-btn {{ request()->is($activity['route']) ? 'active' : '' }}">
                        <i class="{{ $activity['icon'] }}"></i>
                        <span>{{ $activity['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Video Hero Section -->
        <div class="container mb-4">
            <div class="gen-video-holder rounded shadow">
                <iframe src="https://www.youtube.com/embed/3-_cOnVk0N4"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            </div>
        </div>

        <!-- Title, Meta & Description -->
        <div class="container mb-4">
            <div class="gen-single-movie-info">
                <h1 class="text-white mb-2">Strength &amp; Conditioning</h1>
                <div class="gen-single-meta-holder">
                    <ul>
                        <li class="gen-sen-rating">TV-PG</li>
                        <li><i class="fas fa-eye"></i><span>237 Views</span></li>
                    </ul>
                </div>
                <p>
                    Strength building is more than just lifting weights or performing exercises; it’s a holistic approach to
                    enhancing physical power, endurance, and mental resilience. It focuses on improving the body’s muscular
                    capacity and overall functionality, enabling individuals to perform daily tasks efficiently while
                    reducing
                    the risk of injury.
                </p>
            </div>
        </div>

        <!-- Session Details & Live Slots -->
        <div class="container mb-5">
            <div class="gen-after-excerpt">
                <div class="gen-extra-data">
                    <ul>
                        <li><span>Language :</span><span>English</span></li>
                        <li><span>Instructor Name :</span><span>Nishant Gaikwad</span></li>
                        <li><span>Session Type :</span><span>Daily Live</span></li>
                        <li><span>Run Time :</span><span>1hr 24 mins</span></li>
                        <li><span>Release Date :</span><span>14 Aug, 2018</span></li>
                    </ul>
                </div>

                <div class="gen-social-share">
                    @php
                        // Example live slots data, you can replace with your dynamic data
                        $slots = [
                            ['time' => '05:00 AM', 'is_live' => false],
                            ['time' => '06:00 AM', 'is_live' => false],
                            ['time' => '07:00 AM', 'is_live' => true],
                            ['time' => '08:00 AM', 'is_live' => false],
                            ['time' => '5:00 PM', 'is_live' => true],
                        ];
                    @endphp

                    @foreach ($slots as $slot)
                        <div class="live-card">
                            <div class="{{ $slot['is_live'] ? 'live-indicator-green' : 'live-indicator' }}"></div>
                            <div class="session-info">
                                <p class="session-time">{{ $slot['time'] }}</p>
                                <button class="btn-outline-warning">Join Now</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Archived Section -->
        <div class="container mb-5 archived-section">
            <h3 class="fw-bold text-white mb-3">Archived Section Live</h3>
            <div class="row g-3">
                @php
                    // Dummy archived sessions
                    $archived = [
                        [
                            'img' => 'https://picsum.photos/400/250?random=1',
                            'title' => 'Weight Lifting',
                            'duration' => '52 Mins',
                            'time' => '07:45 AM',
                        ],
                        [
                            'img' => 'https://picsum.photos/400/250?random=2',
                            'title' => 'Bodyweight Training',
                            'duration' => '30 Mins',
                            'time' => '09:30 AM',
                        ],
                        [
                            'img' => 'https://picsum.photos/400/250?random=3',
                            'title' => 'Endurance & Conditioning',
                            'duration' => '1h 12 Mins',
                            'time' => '11:00 AM',
                        ],
                        [
                            'img' => 'https://picsum.photos/400/250?random=4',
                            'title' => 'Functional Training',
                            'duration' => '25 Mins',
                            'time' => '1:30 PM',
                        ],
                        [
                            'img' => 'https://picsum.photos/400/250?random=5',
                            'title' => 'Mobility & Flexibility',
                            'duration' => '45 Mins',
                            'time' => '3:00 PM',
                        ],
                    ];
                @endphp

                @foreach ($archived as $arch)
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card h-100">
                            <img src="{{ $arch['img'] }}" class="card-img-top" alt="{{ $arch['title'] }}">
                            <div class="p-2">
                                <h6 class="fw-bold text-white mb-1">{{ $arch['title'] }}</h6>
                                <p class="small text-muted mb-0">{{ $arch['duration'] }}</p>
                                <p class="small text-warning mb-0">{{ $arch['time'] }} • Live</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection
