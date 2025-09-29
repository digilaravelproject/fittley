@extends('layouts.admin')

@section('title', 'Community Groups')

@section('content')
<div class="admin-dashboard">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h1 class="page-title-text">
                    <i class="fas fa-users page-title-icon"></i>
                    Community Groups
                </h1>
                <p class="page-subtitle">Manage community groups and member communities</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.community.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
                <a href="{{ route('admin.community.groups.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Create Group
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
                    <label for="search" class="form-label">Search Groups</label>
                    <input type="text" id="search" name="search" class="form-control" 
                           placeholder="Search by name or description..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select id="category_id" name="category_id" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="">All Statuses</option>
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

    <!-- Groups Table -->
    <div class="dashboard-card">
        <div class="card-header">
            <h3 class="card-title">Groups ({{ $groups->total() }})</h3>
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
                        <li><a class="dropdown-item" href="#" data-action="activate">
                            <i class="fas fa-check me-2"></i>Activate</a></li>
                        <li><a class="dropdown-item" href="#" data-action="deactivate">
                            <i class="fas fa-ban me-2"></i>Deactivate</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#" data-action="delete">
                            <i class="fas fa-trash me-2"></i>Delete</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($groups->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 40px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                    </div>
                                </th>
                                <th>Group</th>
                                <th style="width: 120px;">Category</th>
                                <th style="width: 100px;">Members</th>
                                <th style="width: 80px;">Posts</th>
                                <th style="width: 100px;">Status</th>
                                <th style="width: 140px;">Created</th>
                                <th style="width: 140px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($groups as $group)
                                <tr data-group-id="{{ $group->id }}">
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input group-checkbox" type="checkbox" value="{{ $group->id }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($group->cover_image)
                                                <img src="{{ asset('storage/app/public/' . $group->cover_image) }}" 
                                                     alt="{{ $group->name }}" 
                                                     class="group-avatar me-3">
                                            @else
                                                <div class="group-avatar me-3">
                                                    <i class="fas fa-users"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-1">{{ $group->name }}</h6>
                                                @if($group->description)
                                                    <small class="text-muted">{{ Str::limit($group->description, 60) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($group->category)
                                            <span class="badge" style="background-color: {{ $group->category->color }};">
                                                {{ $group->category->name }}
                                            </span>
                                        @else
                                            <span class="text-muted">No Category</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $group->members_count }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $group->posts_count }}</span>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input status-toggle" type="checkbox" 
                                                   data-group-id="{{ $group->id }}" 
                                                   {{ $group->is_active ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $group->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.community.groups.show', $group->id) }}" 
                                               class="btn btn-outline-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.community.groups.members', $group->id) }}" 
                                               class="btn btn-outline-info" title="Members">
                                                <i class="fas fa-users"></i>
                                            </a>
                                            <a href="{{ route('admin.community.groups.edit', $group->id) }}" 
                                               class="btn btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" 
                                                    onclick="deleteGroup({{ $group->id }})" title="Delete">
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
                        <div>
                            <small class="text-muted">
                                Showing {{ $groups->firstItem() }} to {{ $groups->lastItem() }} of {{ $groups->total() }} groups
                            </small>
                        </div>
                        <div>
                            {{ $groups->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="empty-state text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h4>No Groups Found</h4>
                    <p class="text-muted">Get started by creating your first community group.</p>
                    <a href="{{ route('admin.community.groups.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i>Create Group
                    </a>
                </div>
            @endif
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
                <p>Are you sure you want to delete this group? This action cannot be undone.</p>
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    All members will be removed and group posts will be deleted.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Group</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.group-avatar {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bg-tertiary);
    color: var(--text-muted);
    font-size: 1.2rem;
    object-fit: cover;
    flex-shrink: 0;
}

.group-avatar img {
    width: 100%;
    height: 100%;
    border-radius: 8px;
    object-fit: cover;
}

.status-toggle {
    cursor: pointer;
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

.empty-state {
    padding: 3rem 1rem;
}

.form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.badge {
    font-size: 0.75rem;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select All functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const groupCheckboxes = document.querySelectorAll('.group-checkbox');
    const bulkActionBtn = document.getElementById('bulkActionBtn');
    const bulkDropdown = document.getElementById('bulkDropdown');

    selectAllCheckbox?.addEventListener('change', function() {
        groupCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        toggleBulkActions();
    });

    groupCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', toggleBulkActions);
    });

    function toggleBulkActions() {
        const selectedCount = document.querySelectorAll('.group-checkbox:checked').length;
        const hasSelection = selectedCount > 0;
        
        bulkActionBtn.disabled = !hasSelection;
        bulkDropdown.disabled = !hasSelection;
        
        if (hasSelection) {
            bulkActionBtn.textContent = `Bulk Actions (${selectedCount})`;
        } else {
            bulkActionBtn.textContent = 'Bulk Actions';
        }
    }

    // Status toggle
    document.querySelectorAll('.status-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const groupId = this.dataset.groupId;
            const isActive = this.checked;
            
            fetch(`/admin/community/groups/${groupId}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ is_active: isActive })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    this.checked = !isActive; // Revert on error
                    alert('Error updating group status: ' + data.message);
                }
            })
            .catch(error => {
                this.checked = !isActive; // Revert on error
                console.error('Error:', error);
                alert('Error updating group status');
            });
        });
    });

    // Bulk actions
    document.querySelectorAll('[data-action]').forEach(actionBtn => {
        actionBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const action = this.dataset.action;
            const selectedIds = Array.from(document.querySelectorAll('.group-checkbox:checked'))
                .map(checkbox => checkbox.value);

            if (selectedIds.length === 0) {
                alert('Please select groups first');
                return;
            }

            if (action === 'delete' && !confirm('Are you sure you want to delete the selected groups?')) {
                return;
            }

            performBulkAction(action, selectedIds);
        });
    });

    function performBulkAction(action, groupIds) {
        fetch('{{ route("admin.community.groups.bulk-action") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: action,
                groups: groupIds
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error performing bulk action');
        });
    }
});

function deleteGroup(groupId) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const form = document.getElementById('deleteForm');
    form.action = `/admin/community/groups/${groupId}`;
    modal.show();
}
</script>
@endpush 