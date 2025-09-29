@extends('layouts.admin')

@section('title', 'FitArena Event Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between  mb-3">
                <h4 class="mb-sm-0 font-size-1">Event Details</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.fitarena.index') }}">FitArena Events</a></li>
                        <li class="breadcrumb-item active">{{ $event->title }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Event Details Card -->
        <div class="col-xl-8 col-lg-7">
            <div class="card bg-dark text-white">
                <div class="card-header border-secondary d-flex justify-content-between align-items-center">
                    <h4 class="card-title text-white mb-0">{{ $event->title }}</h4>
                    <div>
                        @switch($event->status)
                            @case('upcoming')
                                <span class="badge bg-warning">Upcoming</span>
                                @break
                            @case('live')
                                <span class="badge bg-success">Live</span>
                                @break
                            @case('ended')
                                <span class="badge bg-secondary">Ended</span>
                                @break
                        @endswitch
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-primary">Basic Information</h5>
                            <table class="table table-borderless text-white">
                                <tr>
                                    <td><strong>Title:</strong></td>
                                    <td>{{ $event->title }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>{{ ucfirst($event->status) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Start Date:</strong></td>
                                    <td>{{ $event->start_date->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>End Date:</strong></td>
                                    <td>{{ $event->end_date ? $event->end_date->format('M d, Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Location:</strong></td>
                                    <td>{{ $event->location ?: 'Online' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Visibility:</strong></td>
                                    <td>{{ ucfirst($event->visibility) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Featured:</strong></td>
                                    <td>
                                        @if($event->is_featured)
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-secondary">No</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-primary">Description</h5>
                            <p class="text-muted">{{ $event->description ?: 'No description provided.' }}</p>
                            
                            @if($event->organizers)
                                <h5 class="text-primary mt-4">Organizers</h5>
                                <ul class="list-unstyled">
                                    @foreach($event->organizers as $organizer)
                                        <li class="mb-1">
                                            <strong>{{ $organizer['name'] }}</strong>
                                            <small class="text-muted">({{ $organizer['role'] }})</small>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Card -->
        <div class="col-xl-4 col-lg-5">
            <div class="card bg-dark text-white">
                <div class="card-header border-secondary">
                    <h4 class="card-title text-white mb-0">Statistics</h4>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-center">
                                <h3 class="text-primary">{{ $event->stages_count ?? 0 }}</h3>
                                <p class="text-muted mb-0">Stages</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <h3 class="text-primary">{{ $event->sessions_count ?? 0 }}</h3>
                                <p class="text-muted mb-0">Sessions</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <h3 class="text-primary">{{ number_format($event->expected_viewers ?? 0) }}</h3>
                                <p class="text-muted mb-0">Expected Viewers</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <h3 class="text-primary">{{ number_format($event->peak_viewers ?? 0) }}</h3>
                                <p class="text-muted mb-0">Peak Viewers</p>
                            </div>
                        </div>
                    </div>

                    @if($event->dvr_enabled)
                        <div class="mt-4">
                            <h6 class="text-primary">DVR Settings</h6>
                            <p class="text-muted">Recording available for {{ $event->dvr_hours }} hours after event</p>
                        </div>
                    @endif

                    <div class="mt-4">
                        <h6 class="text-primary">Created</h6>
                        <p class="text-muted">{{ $event->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="card bg-dark text-white mt-3">
                <div class="card-header border-secondary">
                    <h4 class="card-title text-white mb-0">Actions</h4>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.fitarena.edit', $event->id) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i>Edit Event
                        </a>
                        
                        @if($event->sessions()->exists())
                            @php
                                $liveSession = $event->sessions()->first();
                            @endphp
                            <a href="{{ route('admin.fitarena.sessions.stream', [$event->id, $liveSession->id]) }}" class="btn btn-outline-success">
                                @if($liveSession->status === 'live')
                                    <i class="fas fa-broadcast-tower me-2"></i>Manage Live Stream
                                @else
                                    <i class="fas fa-video me-2"></i>Start Live Stream
                                @endif
                            </a>
                        @else
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Create an event with an instructor to enable live streaming
                            </div>
                        @endif
                        
                        <?php /*<a href="{{ route('admin.fitarena.stages', $event->id) }}" class="btn btn-outline-info">
                            <i class="fas fa-layer-group me-2"></i>Manage Stages
                        </a>
                        <a href="{{ route('admin.fitarena.sessions', $event->id) }}" class="btn btn-outline-success">
                            <i class="fas fa-calendar-alt me-2"></i>Manage Sessions
                        </a>*/ ?>
                        <button type="button" class="btn btn-outline-danger" onclick="deleteEvent({{ $event->id }})">
                            <i class="fas fa-trash me-2"></i>Delete Event
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($event->stages && $event->stages->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card bg-dark text-white">
                    <div class="card-header border-secondary">
                        <h4 class="card-title text-white mb-0">Event Stages</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-dark table-striped">
                                <thead>
                                    <tr>
                                        <th>Stage Name</th>
                                        <th>Status</th>
                                        <th>Sessions</th>
                                        <th>Primary</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($event->stages as $stage)
                                        <tr>
                                            <td>{{ $stage->name }}</td>
                                            <td>
                                                <span class="badge bg-{{ $stage->status === 'live' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($stage->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $stage->sessions->count() }}</td>
                                            <td>
                                                @if($stage->is_primary)
                                                    <span class="badge bg-primary">Primary</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.fitarena.stages.edit', [$event->id, $stage->id]) }}" 
                                                   class="btn btn-sm btn-outline-primary">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
function deleteEvent(eventId) {
    if (confirm('Are you sure you want to delete this event? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/fitarena/${eventId}`;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        form.appendChild(csrfInput);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection 