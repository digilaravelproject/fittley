@extends('layouts.admin')

@section('title', 'Community Badges')

@section('content')
<div class="admin-dashboard">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h1 class="page-title-text">
                    <i class="fas fa-medal page-title-icon"></i>
                    Community Badges
                </h1>
                <p class="page-subtitle">Manage achievement badges and user recognition</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.community.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
                <a href="{{ route('admin.community.badges.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Create Badge
                </a>
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

    <!-- Filters and Search -->
    <div class="dashboard-card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search Badges</label>
                    <input type="text" id="search" name="search" class="form-control" 
                           placeholder="Search by name or description..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label for="type" class="form-label">Type</label>
                    <select id="type" name="type" class="form-select">
                        <option value="">All Types</option>
                        <option value="achievement" {{ request('type') === 'achievement' ? 'selected' : '' }}>Achievement</option>
                        <option value="milestone" {{ request('type') === 'milestone' ? 'selected' : '' }}>Milestone</option>
                        <option value="participation" {{ request('type') === 'participation' ? 'selected' : '' }}>Participation</option>
                        <option value="special" {{ request('type') === 'special' ? 'selected' : '' }}>Special</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Badges Table -->
    <div class="dashboard-card">
        <div class="card-header">
            <h3 class="card-title">Badges ({{ $badges->total() }})</h3>
            <div class="card-actions">
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-primary" id="bulkActionBtn" disabled>
                        <i class="fas fa-tasks me-2"></i>Bulk Actions
                    </button>
                    <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split" 
                            data-bs-toggle="dropdown" disabled id="bulkDropdown">
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" data-action="activate"><i class="fas fa-check me-2"></i>Activate</a></li>
                        <li><a class="dropdown-item" href="#" data-action="deactivate"><i class="fas fa-ban me-2"></i>Deactivate</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#" data-action="delete"><i class="fas fa-trash me-2"></i>Delete</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($badges->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 40px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                    </div>
                                </th>
                                <th>Badge</th>
                                <th style="width: 120px;">Type</th>
                                <th style="width: 100px;">Criteria</th>
                                <th style="width: 80px;">Points</th>
                                <th style="width: 100px;">Status</th>
                                <th style="width: 140px;">Created</th>
                                <th style="width: 160px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($badges as $badge)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input badge-checkbox" type="checkbox" value="{{ $badge->id }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($badge->image)
                                                <img src="{{ asset('storage/app/public/' . $badge->image) }}" 
                                                     alt="{{ $badge->name }}" class="rounded-circle me-3" width="50" height="50">
                                            @else
                                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3" 
                                                     style="width: 50px; height: 50px;">
                                                    <i class="{{ $badge->icon ?? 'fas fa-medal' }}"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-1">{{ $badge->name }}</h6>
                                                <small class="text-muted">{{ Str::limit($badge->description, 60) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-primary">{{ ucfirst($badge->type) }}</span></td>
                                    <td>
                                        @if($badge->criteria && is_array($badge->criteria))
                                            @foreach($badge->criteria as $key => $value)
                                                <small class="d-block">{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}</small>
                                            @endforeach
                                        @else
                                            <small class="text-muted">No criteria</small>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-primary">{{ $badge->points ?? 0 }}</span></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input badge-status-toggle" type="checkbox" 
                                                   data-badge-id="{{ $badge->id }}" {{ $badge->is_active ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td><small class="text-muted">{{ $badge->created_at ? $badge->created_at->format('M d, Y') : 'N/A' }}</small></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.community.badges.show', $badge->id) }}" class="btn btn-outline-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.community.badges.edit', $badge->id) }}" class="btn btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-outline-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal" 
                                                    data-id="{{ $badge->id }}"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>

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
                        <small class="text-muted">
                            Showing {{ $badges->firstItem() }} to {{ $badges->lastItem() }} of {{ $badges->total() }} badges
                        </small>
                        {{ $badges->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="empty-state text-center py-5">
                    <i class="fas fa-medal fa-3x text-muted mb-3"></i>
                    <h4>No Badges Found</h4>
                    <p class="text-muted">Create your first community badge to recognize user achievements.</p>
                    <a href="{{ route('admin.community.badges.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i>Create Badge
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- Award Badge Modal -->
<div class="modal fade" id="awardBadgeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Award Badge</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="awardBadgeForm">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Select User</label>
                        <select id="user_id" name="user_id" class="form-select" required>
                            <option value="">Choose a user...</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason (Optional)</label>
                        <textarea id="reason" name="reason" class="form-control" rows="3" 
                                  placeholder="Why is this badge being awarded?"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="submitAwardBadge()">Award Badge</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this badge? This action cannot be undone.</p>
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Users who have earned this badge will lose it permanently.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Badge</button>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        let button = event.relatedTarget;
        let badgeId = button.getAttribute('data-id');
        let form = document.getElementById('deleteForm');

        // Update form action dynamically
        form.action = `/admin/community/badges/${badgeId}`;
    });

    // Handle badge status toggle
    document.addEventListener('DOMContentLoaded', function() {
        const statusToggles = document.querySelectorAll('.badge-status-toggle');
        
        statusToggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                const badgeId = this.getAttribute('data-badge-id');
                const isActive = this.checked;
                
                // Show loading state
                this.disabled = true;
                
                // Make AJAX request
                fetch(`/admin/community/badges/${badgeId}/toggle-status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        is_active: isActive
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        showAlert('success', data.message);
                    } else {
                        // Revert toggle state
                        this.checked = !isActive;
                        showAlert('error', data.message);
                    }
                })
                .catch(error => {
                    // Revert toggle state
                    this.checked = !isActive;
                    showAlert('error', 'Error updating badge status');
                    console.error('Error:', error);
                })
                .finally(() => {
                    // Re-enable toggle
                    this.disabled = false;
                });
            });
        });
    });

    function showAlert(type, message) {
        // Create alert element
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        // Insert at top of content
        const content = document.querySelector('.admin-dashboard');
        content.insertBefore(alertDiv, content.firstChild);
        
        // Auto-dismiss after 3 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 3000);
    }
</script>
@endpush

@endsection
