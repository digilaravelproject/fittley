@extends('layouts.public')

@section('title', $event->title . ' - FitArena')

@section('content')
<div class="fitarena-event-page">
    <!-- Event Header -->
    <section class="event-hero bg-dark text-white position-relative overflow-hidden">
        <div class="hero-background">
            @if($event->banner_image)
                <img src="{{ Storage::url($event->banner_image) }}" alt="{{ $event->title }}" class="w-100 h-100 object-cover opacity-50">
            @else
                <div class="bg-gradient-primary w-100 h-100"></div>
            @endif
        </div>
        <div class="hero-content position-absolute top-50 start-50 translate-middle text-center w-100">
            <div class="container">
                @if($liveSessions->count() > 0)
                    <span class="badge bg-danger fs-6 mb-3">
                        <i class="fas fa-circle pulse me-2"></i>LIVE NOW
                    </span>
                @else
                    <span class="badge bg-secondary fs-6 mb-3">
                        <i class="fas fa-calendar me-2"></i>{{ ucfirst($event->status) }}
                    </span>
                @endif
                <h1 class="display-4 fw-bold mb-3">{{ $event->title }}</h1>
                <p class="lead mb-4">{{ $event->description }}</p>
                
                <!-- Event Info -->
                <div class="row justify-content-center text-start">
                    <div class="col-md-8">
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar-alt me-3 text-primary"></i>
                                    <div>
                                        <div class="fw-semibold">Start Date</div>
                                        <div class="text-light">{{ $event->start_date->format('M j, Y g:i A') }}</div>
                                    </div>
                                </div>
                            </div>
                            @if($event->end_date)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar-check me-3 text-primary"></i>
                                    <div>
                                        <div class="fw-semibold">End Date</div>
                                        <div class="text-light">{{ $event->end_date->format('M j, Y g:i A') }}</div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if($event->location)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-map-marker-alt me-3 text-primary"></i>
                                    <div>
                                        <div class="fw-semibold">Location</div>
                                        <div class="text-light">{{ $event->location }}</div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if($event->event_type)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-trophy me-3 text-primary"></i>
                                    <div>
                                        <div class="fw-semibold">Event Type</div>
                                        <div class="text-light">{{ ucfirst($event->event_type) }}</div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Live Sessions -->
    @if($liveSessions->count() > 0)
    <section class="py-5 bg-danger bg-opacity-10">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="fw-bold text-danger">
                        <i class="fas fa-broadcast-tower me-2"></i>Live Now
                    </h2>
                    <p class="text-muted">Join the live sessions happening right now</p>
                </div>
            </div>
            <div class="row g-4">
                @foreach($liveSessions as $session)
                <div class="col-lg-6 col-md-12">
                    <div class="card border-danger h-100">
                        <div class="card-header bg-danger text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">{{ $session->title }}</h5>
                                <span class="badge bg-light text-danger">
                                    <i class="fas fa-circle pulse me-1"></i>LIVE
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $session->description }}</p>
                            
                            @if($session->speakers)
                            <div class="mb-3">
                                <strong>Speakers:</strong>
                                <div class="mt-1">
                                    @foreach($session->speakers as $speaker)
                                        <span class="badge bg-primary me-1">{{ $speaker['name'] }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            
                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    Started {{ $session->actual_start->diffForHumans() }}
                                </small>
                            </div>
                            
                            <a href="{{ route('fitarena.session', [$event->id, $session->id]) }}" class="btn btn-danger">
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
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="fw-bold">
                        <i class="fas fa-clock me-2"></i>Upcoming Sessions
                    </h2>
                    <p class="text-muted">Don't miss these upcoming sessions</p>
                </div>
            </div>
            <div class="row g-4">
                @foreach($upcomingSessions as $session)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $session->title }}</h5>
                            <p class="card-text">{{ Str::limit($session->description, 100) }}</p>
                            
                            @if($session->speakers)
                            <div class="mb-3">
                                <strong>Speakers:</strong>
                                <div class="mt-1">
                                    @foreach($session->speakers as $speaker)
                                        <span class="badge bg-secondary me-1">{{ $speaker['name'] }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            
                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $session->scheduled_start->format('M j, Y g:i A') }}
                                </small>
                            </div>
                            
                            <a href="{{ route('fitarena.session', [$event->id, $session->id]) }}" class="btn btn-outline-primary">
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
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h3 class="card-title">About This Event</h3>
                            <p class="card-text">{{ $event->description }}</p>
                            
                            @if($event->rules)
                            <div class="mb-4">
                                <h5>Rules & Regulations</h5>
                                <div class="text-muted">{{ $event->rules }}</div>
                            </div>
                            @endif
                            
                            @if($event->prizes)
                            <div class="mb-4">
                                <h5>Prizes & Rewards</h5>
                                <div class="text-muted">{{ $event->prizes }}</div>
                            </div>
                            @endif
                            
                            @if($event->sponsors)
                            <div class="mb-4">
                                <h5>Sponsors</h5>
                                <div class="text-muted">{{ $event->sponsors }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <!-- Event Stats -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Event Statistics</h5>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-primary mb-0">{{ $event->sessions()->count() }}</div>
                                        <small class="text-muted">Sessions</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-success mb-0">{{ $event->stages()->count() }}</div>
                                        <small class="text-muted">Stages</small>
                                    </div>
                                </div>
                                @if($event->max_participants)
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 text-warning mb-0">{{ $event->max_participants }}</div>
                                        <small class="text-muted">Max Participants</small>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Share Event -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Share This Event</h5>
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-primary btn-sm" onclick="shareEvent()">
                                    <i class="fas fa-share me-2"></i>Share Event
                                </button>
                                <button class="btn btn-outline-secondary btn-sm" onclick="copyEventLink()">
                                    <i class="fas fa-link me-2"></i>Copy Link
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
.pulse {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.hero-content {
    z-index: 2;
}

.event-hero {
    min-height: 60vh;
}

.object-cover {
    object-fit: cover;
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
        // Show success notification (you can customize this)
        alert('Event link copied to clipboard!');
    });
}
</script>
@endsection
