@extends('layouts.public')

@section('title', 'FitArena - Live Fitness Competitions')

@section('content')
    <div class="fitarena-page">

        {{-- Hero Section --}}
        @if($heroEvent)
            <section class="hero-section position-relative overflow-hidden">
                <div class="hero-overlay"></div>
                @if($heroEvent->banner_image)
                    <img src="{{ getImagePath($heroEvent->banner_image) }}" alt="{{ $heroEvent->title ?? 'Live Event' }}"
                        class="hero-bg-image">
                @else
                    <div class="hero-bg-gradient"></div>
                @endif
                <div class="hero-content-wrapper">
                    <div class="container text-center text-white">
                        <span class="badge live-badge shadow-lg">
                            <i class="fas fa-circle pulse me-2"></i>LIVE NOW
                        </span>
                        <h1 class="hero-title mb-3">{{ $heroEvent->title }}</h1>
                        <p class="hero-subtitle mb-4">{{ $heroEvent->description }}</p>
                        <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
                            <a href="{{ route('fitarena.event', $heroEvent->slug) }}" class="btn btn-primary btn-lg hero-btn">
                                <i class="fas fa-play me-2"></i>Watch Live
                            </a>
                            <div class="text-light viewers-count">
                                <i class="fas fa-users me-2"></i>{{ $heroEvent->peak_viewers ?? 0 }} viewers
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Live Section --}}
        @if($liveEvents->count() > 0)
            <section class="live-section py-5">
                <div class="container">
                    <div class="section-header text-center mb-4">
                        <h2 class="section-title">🔴 Live Now</h2>
                        <p class="section-subtitle ">Join the action happening right now</p>
                    </div>
                    <div class="row g-4">
                        @foreach($liveEvents as $event)
                            <div class="col-lg-4 col-md-6">
                                <div class="card event-card-glass h-100 border-0 overflow-hidden">
                                    <div class="card-img-wrapper position-relative">
                                        @if($event->banner_image)
                                            <img src="{{ getImagePath($event->banner_image) }}" alt="{{ $event->title }}"
                                                class="card-img-top">
                                        @else
                                            <div class="placeholder-img d-flex align-items-center justify-content-center">
                                                <i class="fas fa-image fa-2x text-muted"></i>
                                            </div>
                                        @endif
                                        <span class="badge badge-live top-left"><i class="fas fa-circle pulse me-1"></i>LIVE</span>
                                        <span class="badge badge-viewers bottom-right">
                                            <i class="fas fa-users me-1"></i>{{ $event->peak_viewers ?? 0 }}
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $event->title }}</h5>
                                        <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <small><i
                                                    class="fas fa-calendar me-1"></i>{{ $event->start_date->format('M j') }}</small>
                                            <span class="badge badge-type">{{ $event->event_type ?? 'Competition' }}</span>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent border-0">
                                        <a href="{{ route('fitarena.event', $event->slug) }}" class="btn btn-outline-light w-100">
                                            <i class="fas fa-play me-2"></i>Watch Live
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- Upcoming Section --}}
        @if($upcomingEvents->count() > 0)
            <section class="upcoming-section py-5 bg-light">
                <div class="container">
                    <div class="section-header text-center mb-4">
                        <h2 class="section-title">📅 Upcoming Events</h2>
                        <p class="section-subtitle">Don't miss these exciting competitions</p>
                    </div>
                    <div class="row g-4">
                        @foreach($upcomingEvents as $event)
                            <div class="col-lg-4 col-md-6">
                                <div class="card event-card h-100 border-0 shadow-sm">
                                    <div class="card-img-wrapper position-relative">
                                        @if($event->banner_image)
                                            <img src="{{ getImagePath($event->banner_image) }}" alt="{{ $event->title }}"
                                                class="card-img-top">
                                        @else
                                            <div class="placeholder-img d-flex align-items-center justify-content-center">
                                                <i class="fas fa-image fa-2x text-muted"></i>
                                            </div>
                                        @endif
                                        <span class="badge badge-uptime top-left"><i
                                                class="fas fa-clock me-1"></i>{{ $event->getDaysUntilStart() }}d</span>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $event->title }}</h5>
                                        <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <small><i
                                                    class="fas fa-calendar me-1"></i>{{ $event->start_date->format('M j, Y') }}</small>
                                            <span class="badge badge-info">{{ $event->event_type ?? 'Competition' }}</span>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent border-0">
                                        <a href="{{ route('fitarena.event', $event->slug) }}" class="btn btn-primary w-100">
                                            <i class="fas fa-info-circle me-2"></i>View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- Featured Section --}}
        @if($featuredEvents->count() > 0)
            <section class="featured-section py-5 bg-dark text-white">
                <div class="container">
                    <div class="section-header text-center mb-4">
                        <h2 class="section-title">⭐ Featured Events</h2>
                        <p class="section-subtitle text-muted">Highlighted Competitions</p>
                    </div>
                    <div class="row g-4">
                        @foreach($featuredEvents as $event)
                            <div class="col-lg-3 col-md-6">
                                <div class="card event-card-glass-sm h-100 border-0 overflow-hidden">
                                    <div class="card-img-wrapper position-relative">
                                        @if($event->banner_image)
                                            <img src="{{ getImagePath($event->banner_image) }}" alt="{{ $event->title }}"
                                                class="card-img-top">
                                        @else
                                            <div class="placeholder-img d-flex align-items-center justify-content-center">
                                                <i class="fas fa-star fa-2x text-muted"></i>
                                            </div>
                                        @endif
                                        <span class="badge badge-featured top-right"><i class="fas fa-star me-1"></i>Featured</span>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $event->title }}</h6>
                                        <small class="d-block mb-2"><i
                                                class="fas fa-calendar me-1"></i>{{ $event->start_date->format('M j') }}</small>
                                        <span class="badge badge-status">{{ ucfirst($event->status) }}</span>
                                    </div>
                                    <div class="card-footer bg-transparent border-0 p-2">
                                        <a href="{{ route('fitarena.event', $event->slug) }}"
                                            class="btn btn-outline-light w-100 btn-sm">
                                            View Event
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- CTA --}}
        <section class="cta-section py-5 text-center text-white bg-primary">
            <div class="container">
                <h2 class="fw-bold mb-3">Ready to Compete?</h2>
                <p class="lead mb-4">Join FitArena and showcase your fitness skills live</p>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg me-3">
                        <i class="fas fa-user-plus me-2"></i>Sign Up Now
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </a>
                @else
                    <a href="{{ route('subscription.plans') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-crown me-2"></i>Get Premium Access
                    </a>
                @endguest
            </div>
        </section>

    </div>

    <style>
        /* = Hero = */
        .hero-section {
            position: relative;
            height: 70vh;
            min-height: 540px;
            overflow: hidden;
        }

        .hero-bg-image,
        .hero-bg-gradient {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1;
        }

        .hero-bg-gradient {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2;
        }

        .hero-content-wrapper {
            position: relative;
            z-index: 3;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            padding: 0 1rem;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: #f0f0f0;
        }

        .live-badge {
            background: #e53e3e;
            color: #fff;
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
        }

        .hero-btn {
            border-radius: 50px;
            padding: 0.75rem 2rem;
            font-weight: 600;
        }

        .viewers-count {
            font-size: 1rem;
            color: #ddd;
        }

        /* = Sections = */
        .section-header .section-title {
            font-size: 2.5rem;
            font-weight: 700;
        }

        .section-subtitle {
            font-size: 1rem;
            color: #777;
        }

        /* = Card Glass / Shadow = */
        .event-card-glass,
        .event-card-glass-sm {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            border-radius: 1rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            color: #fff;
        }

        .event-card {
            border-radius: 0.75rem;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .event-card:hover,
        .event-card-glass:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.4);
        }

        /* = Image Wrapper = */
        .card-img-wrapper {
            position: relative;
            overflow: hidden;
            height: 200px;
        }

        .card-img-wrapper .card-img-top {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .card-img-wrapper:hover .card-img-top {
            transform: scale(1.05);
        }

        .placeholder-img {
            background: #2d2d2d;
            width: 100%;
            height: 100%;
        }

        /* = Badges = */
        .badge-live {
            position: absolute;
            top: 15px;
            left: 15px;
            background: #e53e3e;
            color: #fff;
            padding: 0.4rem 0.8rem;
            border-radius: 0.75rem;
            font-size: 0.8rem;
            z-index: 5;
        }

        .badge-viewers {
            position: absolute;
            bottom: 15px;
            right: 15px;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 0.35rem 0.7rem;
            border-radius: 0.75rem;
            font-size: 0.85rem;
        }

        .badge-type {
            background: #38a169;
            color: #fff;
            border-radius: 0.5rem;
            padding: 0.35rem 0.7rem;
            font-size: 0.85rem;
        }

        .badge-uptime {
            position: absolute;
            top: 15px;
            left: 15px;
            background: #d69e2e;
            color: #fff;
            padding: 0.4rem 0.8rem;
            border-radius: 0.75rem;
            font-size: 0.8rem;
        }

        .badge-featured {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #f6ad55;
            color: #1a202c;
            padding: 0.4rem 0.8rem;
            border-radius: 0.75rem;
            font-size: 0.85rem;
        }

        .badge-status {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            padding: 0.3rem 0.6rem;
            border-radius: 0.5rem;
            font-size: 0.8rem;
        }

        /* = Upcoming Section = */
        .upcoming-section {
            background-color: #f8f9fa;
        }

        /* = CTA = */
        .cta-section {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .cta-section .btn {
            border-radius: 50px;
            padding: 0.75rem 2rem;
            font-weight: 600;
        }

        /* = Animations = */
        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.4;
            }
        }

        .pulse {
            animation: pulse 1.8s infinite;
        }
    </style>
@endsection