@extends('layouts.admin')

@section('title', 'FitArena Events')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between mb-3">
                <h4 class="mb-sm-0 font-size-18">FitArena Events</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">FitArena Events</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">All Events</h4>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.fitarena.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Create New Event
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter Tabs -->
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('admin.fitarena.index') }}">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block fitarena_status">All Events</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.fitarena.index') }}?status=live">
                                <span class="d-block d-sm-none"><i class="fas fa-circle text-danger"></i></span>
                                <span class="d-none d-sm-block fitarena_status">Live Events</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.fitarena.index') }}?status=upcoming">
                                <span class="d-block d-sm-none"><i class="fas fa-clock"></i></span>
                                <span class="d-none d-sm-block fitarena_status">Upcoming Events</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.fitarena.index') }}?featured=1">
                                <span class="d-block d-sm-none"><i class="fas fa-star"></i></span>
                                <span class="d-none d-sm-block fitarena_status">Featured Events</span>
                            </a>
                        </li>
                    </ul>

                    <div class="table-responsive mt-3">
                        <table class="table table-centered table-nowrap table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Event</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">Stages</th>
                                    <th scope="col">Sessions</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($events ?? [] as $event)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($event->featured_image)
                                                <img src="{{ asset('storage/app/public/' . $event->featured_image) }}" 
                                                     alt="{{ $event->title }}" 
                                                     class="rounded me-3" width="48" height="48">
                                            @else
                                                <div class="avatar-sm me-3">
                                                    <div class="avatar-title rounded bg-primary-subtle text-primary">
                                                        {{ substr($event->title, 0, 1) }}
                                                    </div>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ $event->title }}</h6>
                                                <p class="text-muted mb-0">{{ Str::limit($event->description, 50) }}</p>
                                                @if($event->is_featured)
                                                    <span class="badge bg-warning">Featured</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($event->event_type ?? 'Competition') }}</span>
                                    </td>
                                    <td>
                                        @switch($event->status ?? 'upcoming')
                                            @case('live')
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-circle me-1"></i>Live
                                                </span>
                                                @break
                                            @case('upcoming')
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-clock me-1"></i>Upcoming
                                                </span>
                                                @break
                                            @case('completed')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>Completed
                                                </span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">Draft</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        {{ $event->start_date ? $event->start_date->format('M d, Y H:i') : 'Not set' }}
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ $event->stages_count ?? 0 }} Stages
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ $event->sessions_count ?? 0 }} Sessions
                                        </span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle btn btn-light btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="{{ route('admin.fitarena.show', $event->id) }}">
                                                    <i class="fas fa-eye me-2"></i>View Details
                                                </a>
                                                <a class="dropdown-item" href="{{ route('admin.fitarena.edit', $event) }}">
                                                    <i class="fas fa-edit me-2"></i>Edit Event
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-danger" href="#" onclick="confirmDelete('{{ $event->id }}')">
                                                    <i class="fas fa-trash me-2"></i>Delete Event
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-trophy fa-3x mb-3"></i>
                                            <h5>No events found</h5>
                                            <p>Get started by creating your first FitArena event.</p>
                                            <a href="{{ route('admin.fitarena.create') }}" class="btn btn-primary">
                                                Create Event
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(isset($events) && method_exists($events, 'hasPages') && $events->hasPages())
                        <div class="row mt-3">
                            <div class="col-12">
                                {{ $events->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fitarena_status" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body fitarena_status">
                Are you sure you want to delete this event? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(eventId) {
    const form = document.getElementById('deleteForm');
    form.action = `/admin/fitarena/${eventId}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush
@endsection 