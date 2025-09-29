@extends('layouts.app')

@section('title', 'FitArena Sessions')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between mb-3">
                <h4 class="mb-sm-0 font-size-18">My FitArena Sessions</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('instructor.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">FitArena Sessions</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card bg-dark text-white">
                <div class="card-header border-secondary">
                    <h4 class="card-title text-white mb-0">
                        <i class="fas fa-trophy me-2"></i>FitArena Sessions
                    </h4>
                </div>
                <div class="card-body">
                    @if($sessions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-dark table-striped">
                                <thead>
                                    <tr>
                                        <th>Session</th>
                                        <th>Event</th>
                                        <th>Stage</th>
                                        <th>Scheduled Time</th>
                                        <th>Status</th>
                                        <th>Duration</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sessions as $session)
                                    <tr>
                                        <td>
                                            <strong>{{ $session->title }}</strong>
                                            @if($session->description)
                                                <br><small class="text-muted">{{ Str::limit($session->description, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.fitarena.show', $session->event->id) }}" class="text-decoration-none">
                                                {{ $session->event->title }}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ $session->stage->name ?? 'Main Stage' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div>{{ $session->scheduled_start->format('M j, Y') }}</div>
                                            <small class="text-muted">{{ $session->scheduled_start->format('g:i A') }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $session->status_color }}">
                                                {{ ucfirst($session->status) }}
                                            </span>
                                            @if($session->status === 'live')
                                                <i class="fas fa-circle text-danger ms-1 pulse"></i>
                                            @endif
                                        </td>
                                        <td>
                                            @if($session->actual_start && $session->actual_end)
                                                {{ $session->getActualDuration() }}
                                            @else
                                                {{ $session->getFormattedScheduledDuration() }}
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                @if($session->status === 'scheduled' || $session->status === 'live')
                                                    <a href="{{ route('instructor.fitarena.sessions.stream', $session->id) }}" 
                                                       class="btn btn-primary btn-sm">
                                                        @if($session->status === 'live')
                                                            <i class="fas fa-broadcast-tower"></i> Manage Stream
                                                        @else
                                                            <i class="fas fa-video"></i> Start Stream
                                                        @endif
                                                    </a>
                                                @endif
                                                
                                                @if($session->recording_url && $session->status === 'ended')
                                                    <a href="{{ $session->recording_url }}" 
                                                       class="btn btn-outline-success btn-sm" target="_blank">
                                                        <i class="fas fa-play"></i> Recording
                                                    </a>
                                                @endif
                                                
                                                <a href="{{ route('fitarena.session', [$session->event->id, $session->id]) }}" 
                                                   class="btn btn-outline-light btn-sm" target="_blank">
                                                    <i class="fas fa-external-link-alt"></i> View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $sessions->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-trophy fa-3x text-muted mb-3"></i>
                            <h5>No FitArena Sessions Found</h5>
                            <p class="text-muted">You haven't been assigned to any FitArena sessions yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
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
</style>
@endsection
