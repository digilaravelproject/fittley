@extends('layouts.admin')

@section('title', 'FitTalk Sessions')

@section('content')
<div class="admin-dashboard">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h1 class="page-title-text">
                    <i class="fas fa-phone-alt page-title-icon"></i>
                    FitTalk Sessions
                </h1>
                <p class="page-subtitle">Manage 1-on-1 fitness consultation sessions</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.community.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
                <button type="button" class="btn btn-success" onclick="refreshStats()">
                    <i class="fas fa-sync-alt me-2"></i>Refresh
                </button>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filters -->
    <div class="dashboard-card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="">All Sessions</option>
                        <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="no_show" {{ request('status') === 'no_show' ? 'selected' : '' }}>No Show</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="instructor_id" class="form-label">Instructor</label>
                    <select id="instructor_id" name="instructor_id" class="form-select">
                        <option value="">All Instructors</option>
                        @foreach($instructors as $instructor)
                            <option value="{{ $instructor->id }}" {{ request('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                {{ $instructor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="date_from" class="form-label">Date From</label>
                    <input type="date" id="date_from" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-3">
                    <label for="date_to" class="form-label">Date To</label>
                    <input type="date" id="date_to" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
            </form>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-search me-2"></i>Filter
                </button>
                <a href="{{ route('admin.community.fittalk.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-sync me-2"></i>Reset
                </a>
            </div>
        </div>
    </div>

    <!-- Sessions Table -->
    <div class="dashboard-card">
        <div class="card-header">
            <h3 class="card-title">Sessions ({{ $sessions->total() }})</h3>
        </div>
        <div class="card-body p-0">
            @if($sessions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Session Details</th>
                                <th>Participants</th>
                                <th>Scheduled Time</th>
                                <th>Duration</th>
                                <th>Cost</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sessions as $session)
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-1">Session #{{ $session->id }}</h6>
                                            @if($session->topic)
                                                <small class="text-muted">{{ Str::limit($session->topic, 50) }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="participants">
                                            <div class="participant">
                                                <strong>Client:</strong> {{ $session->user->name ?? 'Unknown' }}
                                            </div>
                                            <div class="participant">
                                                <strong>Instructor:</strong> {{ $session->instructor->name ?? 'Unknown' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="session-date">{{ $session->scheduled_at->format('M d, Y') }}</div>
                                            <small class="text-muted">{{ $session->scheduled_at->format('g:i A') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $session->duration ?? 30 }} min</span>
                                    </td>
                                    <td>
                                        <strong>${{ number_format($session->cost ?? 0, 2) }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge {{ getStatusBadgeClass($session->status ?? 'scheduled') }}">
                                            {{ ucfirst(str_replace('_', ' ', $session->status ?? 'scheduled')) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.community.fittalk.show', $session->id) }}" 
                                               class="btn btn-outline-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(in_array($session->status, ['scheduled', 'in_progress']))
                                                <button type="button" class="btn btn-outline-warning" 
                                                        onclick="updateStatus({{ $session->id }}, 'cancelled')" title="Cancel">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                            @if($session->status === 'scheduled')
                                                <button type="button" class="btn btn-outline-success" 
                                                        onclick="updateStatus({{ $session->id }}, 'in_progress')" title="Start">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            @endif
                                            @if($session->status === 'in_progress')
                                                <button type="button" class="btn btn-outline-success" 
                                                        onclick="updateStatus({{ $session->id }}, 'completed')" title="Complete">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">
                                Showing {{ $sessions->firstItem() }} to {{ $sessions->lastItem() }} of {{ $sessions->total() }} sessions
                            </small>
                        </div>
                        <div>
                            {{ $sessions->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="empty-state text-center py-5">
                    <i class="fas fa-phone-alt fa-3x text-muted mb-3"></i>
                    <h4>No Sessions Found</h4>
                    <p class="text-muted">No FitTalk sessions match your current filters.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Session Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="statusForm">
                    <div class="mb-3">
                        <label for="session_status" class="form-label">New Status</label>
                        <select id="session_status" name="status" class="form-select" required>
                            <option value="scheduled">Scheduled</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="no_show">No Show</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Admin Notes (Optional)</label>
                        <textarea id="admin_notes" name="admin_notes" class="form-control" rows="3" 
                                  placeholder="Add any notes about this status change..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="submitStatusUpdate()">Update Status</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.participants {
    font-size: 0.875rem;
}

.participant {
    margin-bottom: 0.25rem;
}

.session-date {
    font-weight: 500;
    color: var(--text-primary);
}

.empty-state {
    padding: 3rem 1rem;
    color: var(--text-muted);
}

.table th {
    border-bottom: 2px solid var(--border-primary);
    color: var(--text-primary);
    font-weight: 600;
}

.table-dark th {
    background-color: var(--bg-tertiary);
    border-color: var(--border-secondary);
}

.table-hover tbody tr:hover {
    background-color: var(--bg-hover);
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
</style>
@endpush

@push('scripts')
<script>
let currentSessionId = null;

function refreshStats() {
    location.reload();
}

function updateStatus(sessionId, status) {
    currentSessionId = sessionId;
    
    // Quick update for simple status changes
    if (['cancelled', 'in_progress', 'completed'].includes(status)) {
        if (confirm(`Are you sure you want to mark this session as ${status.replace('_', ' ')}?`)) {
            submitQuickStatusUpdate(sessionId, status);
        }
    } else {
        // Show modal for complex status changes
        document.getElementById('session_status').value = status;
        const modal = new bootstrap.Modal(document.getElementById('statusModal'));
        modal.show();
    }
}

function submitQuickStatusUpdate(sessionId, status) {
    fetch(`/admin/community/fittalk/${sessionId}/status`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            status: status,
            admin_notes: `Status updated to ${status} by admin`
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error updating session status: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating session status');
    });
}

function submitStatusUpdate() {
    const form = document.getElementById('statusForm');
    const formData = new FormData(form);
    
    fetch(`/admin/community/fittalk/${currentSessionId}/status`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('statusModal')).hide();
            location.reload();
        } else {
            alert('Error updating session status: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating session status');
    });
}

@php
function getStatusBadgeClass($status) {
    switch($status) {
        case 'scheduled': return 'bg-info';
        case 'in_progress': return 'bg-warning';
        case 'completed': return 'bg-success';
        case 'cancelled': return 'bg-danger';
        case 'no_show': return 'bg-secondary';
        default: return 'bg-primary';
    }
}
@endphp
</script>
@endpush 