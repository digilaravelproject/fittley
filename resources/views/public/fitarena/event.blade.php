@extends('layouts.public')

@section('title', $event->title . ' - FitArena')

@section('content')
    <div class="fitarena-event-page">
        <!-- Event Header -->
        <section class="event-hero bg-dark text-white position-relative overflow-hidden d-flex align-items-center"
            style="min-height: 70vh;">
            <div class="hero-background">
                @if($event->banner_image)
                    <img src="{{ getImagePath($event->banner_image) }}" alt="{{ $event->title }}"
                        class="w-100 h-100 object-cover opacity-50">
                @else
                    <div class="bg-gradient-primary w-100 h-100"></div>
                @endif
            </div>
            <div class="hero-content position-relative container text-center px-3 px-md-5 py-1 py-md-2 py-lg-4"
                style="z-index: 2;">
                @if($liveSessions->count() > 0)
                    <span
                        class="badge bg-danger fs-6 mb-3 d-inline-flex align-items-center justify-content-center px-3 py-2 rounded-pill">
                        <i class="fas fa-circle pulse me-2"></i> LIVE NOW
                    </span>
                @else
                    <span
                        class="badge bg-secondary fs-6 mb-3 d-inline-flex align-items-center justify-content-center px-3 py-2 rounded-pill">
                        <i class="fas fa-calendar me-2"></i> {{ ucfirst($event->status) }}
                    </span>
                @endif

                <h1 class="display-4 fw-bold mb-3 text-shadow">{{ $event->title }}</h1>
                <p class="lead mb-4 text-shadow">{{ $event->description }}</p>

                <!-- Event Info -->
                <div class="row justify-content-center text-start">
                    <div class="col-md-8">
                        <div class="row g-4">
                            <div class="col-6 col-md-3">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="fas fa-calendar-alt text-primary fs-4"></i>
                                    <div>
                                        <div class="fw-semibold">Start Date</div>
                                        <div class="text-light small">{{ $event->start_date->format('M j, Y g:i A') }}</div>
                                    </div>
                                </div>
                            </div>
                            @if($event->end_date)
                                <div class="col-6 col-md-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <i class="fas fa-calendar-check text-primary fs-4"></i>
                                        <div>
                                            <div class="fw-semibold">End Date</div>
                                            <div class="text-light small">{{ $event->end_date->format('M j, Y g:i A') }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($event->location)
                                <div class="col-6 col-md-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <i class="fas fa-map-marker-alt text-primary fs-4"></i>
                                        <div>
                                            <div class="fw-semibold">Location</div>
                                            <div class="text-light small">{{ $event->location }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($event->event_type)
                                <div class="col-6 col-md-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <i class="fas fa-trophy text-primary fs-4"></i>
                                        <div>
                                            <div class="fw-semibold">Event Type</div>
                                            <div class="text-light small">{{ ucfirst($event->event_type) }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Live Sessions -->
        @if($liveSessions->count() > 0)
            <section class="py-1 py-md-2 py-lg-4 bg-danger bg-opacity-10">
                <div class="container">
                    <div class="row mb-4">
                        <div class="col-12 text-center text-md-start">
                            <h2 class="fw-bold text-danger fs-2 d-inline-flex align-items-center gap-2">
                                <i class="fas fa-broadcast-tower"></i> Live Now
                            </h2>
                            <p class=" mb-0">Join the live sessions happening right now</p>
                        </div>
                    </div>
                    <div class="row g-4">
                        @foreach($liveSessions as $session)
                            <div class="col-lg-6 col-md-12">
                                <div class="card border-danger h-100 shadow-sm">
                                    <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 text-truncate">{{ $session->title }}</h5>
                                        <span
                                            class="badge bg-light text-danger d-flex align-items-center gap-1 px-3 py-1 rounded-pill">
                                            <i class="fas fa-circle pulse fs-6"></i> LIVE
                                        </span>
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <p class="card-text flex-grow-1">{{ $session->description }}</p>

                                        @if($session->speakers)
                                            <div class="mb-3">
                                                <strong>Speakers:</strong>
                                                <div class="mt-2 d-flex flex-wrap gap-2">
                                                    @foreach($session->speakers as $speaker)
                                                        <span class="badge bg-primary">{{ $speaker['name'] }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <div class="mb-3 text-muted small d-flex align-items-center gap-2">
                                            <i class="fas fa-clock"></i>
                                            @php
                                                $strIng = ($session->actual_start && $session->actual_start != '')
                                                    ? $session->actual_start->diffForHumans()
                                                    : '-';
                                            @endphp
                                            Started {{ $strIng }}
                                        </div>

                                        <a href="{{ route('fitarena.session', [$event->id, $session->id]) }}"
                                            class="btn btn-danger mt-auto d-block text-center">
                                            <i class="fas fa-play me-2"></i>Join Live Session
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Upcoming Sessions -->
        @if($upcomingSessions->count() > 0)
            <section class="py-1 py-md-2 py-lg-4 bg-light">
                <div class="container">
                    <div class="row mb-4 text-center text-md-start">
                        <div class="col-12">
                            <h2 class="fw-bold fs-2 d-inline-flex align-items-center gap-2">
                                <i class="fas fa-clock"></i> Upcoming Sessions
                            </h2>
                            <p class="text-muted mb-0">Don't miss these upcoming sessions</p>
                        </div>
                    </div>
                    <div class="row g-4">
                        @foreach($upcomingSessions as $session)
                            <div class="col-lg-4 col-md-6">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title text-truncate" title="{{ $session->title }}">{{ $session->title }}
                                        </h5>
                                        <p class="card-text flex-grow-1">{{ Str::limit($session->description, 100) }}</p>

                                        @if($session->speakers)
                                            <div class="mb-3">
                                                <strong>Speakers:</strong>
                                                <div class="mt-2 d-flex flex-wrap gap-2">
                                                    @foreach($session->speakers as $speaker)
                                                        <span class="badge bg-secondary">{{ $speaker['name'] }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <div class="mb-3 text-muted small d-flex align-items-center gap-2">
                                            <i class="fas fa-calendar"></i>
                                            {{ $session->scheduled_start->format('M j, Y g:i A') }}
                                        </div>

                                        <a href="{{ route('fitarena.session', [$event->id, $session->id]) }}"
                                            class="btn btn-outline-primary mt-auto d-block text-center">
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

        <!-- Event Details -->
        <section class="py-1 py-md-2 py-lg-4">
            <div class="container">
                <div class="row g-4 align-items-stretch">
                    <div class="col-lg-8 d-flex">
                        <div class="card border-0 shadow-sm flex-fill h-100">
                            <div class="card-body d-flex flex-column">
                                <h3 class="card-title mb-4">About This Event</h3>
                                <p class="card-text">{{ $event->description }}</p>

                                @if($event->rules)
                                    <div class="mb-4">
                                        <h5>Rules & Regulations</h5>
                                        <div class="text-muted">{!! nl2br(e($event->rules)) !!}</div>
                                    </div>
                                @endif

                                @if($event->prizes)
                                    <div class="mb-4">
                                        <h5>Prizes & Rewards</h5>
                                        <div class="text-muted">{!! nl2br(e($event->prizes)) !!}</div>
                                    </div>
                                @endif

                                @if($event->sponsors)
                                    <div class="mb-4">
                                        <h5>Sponsors</h5>
                                        <div class="text-muted">{!! nl2br(e($event->sponsors)) !!}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 d-flex flex-column gap-4">
                        <!-- Event Stats -->
                        <div class="card border-0 shadow-sm flex-fill h-100">
                            <div class="card-body d-flex flex-column justify-content-center">
                                <h5 class="card-title mb-4">Event Statistics</h5>
                                <div class="row g-3 text-center text-md-start">
                                    <div class="col-6 col-md-12 mb-3 mb-md-0">
                                        <div>
                                            <div class="h4 text-primary fw-bold mb-1">{{ $event->sessions()->count() }}
                                            </div>
                                            <small class="text-muted">Sessions</small>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-12 mb-3 mb-md-0">
                                        <div>
                                            <div class="h4 text-success fw-bold mb-1">{{ $event->stages()->count() }}</div>
                                            <small class="text-muted">Stages</small>
                                        </div>
                                    </div>
                                    @if($event->max_participants)
                                        <div class="col-12">
                                            <div>
                                                <div class="h4 text-warning fw-bold mb-1">{{ $event->max_participants }}</div>
                                                <small class="text-muted">Max Participants</small>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Share Event -->
                        <div class="card border-0 shadow-sm flex-fill">
                            <div class="card-body d-flex flex-column justify-content-center">
                                <h5 class="card-title mb-3">Share This Event</h5>
                                <div class="d-grid gap-2">
                                    <button
                                        class="btn btn-outline-primary btn-sm d-flex align-items-center justify-content-center gap-2"
                                        onclick="shareEvent()">
                                        <i class="fas fa-share"></i> Share Event
                                    </button>
                                    <button
                                        class="btn btn-outline-secondary btn-sm d-flex align-items-center justify-content-center gap-2"
                                        onclick="copyEventLink()">
                                        <i class="fas fa-link"></i> Copy Link
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <style>
        .text-primary {
            color: var(--primary-color) !important;
        }

        /* Pulsing animation for live indicator */
        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        /* Hero background and content layering */
        .hero-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            overflow: hidden;
        }

        .hero-background img,
        .hero-background div {
            object-fit: cover;
            height: 100%;
            width: 100%;
        }

        .hero-content {
            z-index: 2;
        }

        /* Object-fit utility for images */
        .object-cover {
            object-fit: cover;
        }

        /* Text shadow for better contrast on hero */
        .text-shadow {
            text-shadow: 0 0 5px rgba(0, 0, 0, 0.6);
        }

        /* Responsive adjustments */
        @media (max-width: 767.98px) {
            .event-hero {
                min-height: 50vh;
                padding: 3rem 1rem;
            }
        }

        @media (min-width: 768px) {
            .event-hero {
                min-height: 70vh;
            }
        }
    </style>

    <script>
        // Share event
        function shareEvent() {
            const url = window.location.href;
            if (navigator.share) {
                navigator.share({
                    title: '{{ $event->title }}',
                    text: 'Check out this FitArena event!',
                    url: url
                });
            } else {
                copyEventLink();
            }
        }

        // Copy event link
        function copyEventLink() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                // Show success notification (customize as needed)
                alert('Event link copied to clipboard!');
            });
        }
    </script>
@endsection