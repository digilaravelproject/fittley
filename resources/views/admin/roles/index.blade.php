@extends('layouts.admin')

@section('content')
<div class="roles-index">
    <!-- Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-user-tag me-3"></i>
                    Roles Management
                </h1>
                <p class="page-subtitle">Manage system roles and their permissions</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Create Role
                </a>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
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

    <!-- Roles Table -->
    <div class="content-card">
        <div class="content-card-header">
            <h3 class="content-card-title">
                <i class="fas fa-list me-2"></i>
                All Roles
            </h3>
            <p class="content-card-subtitle">{{ $roles->total() }} roles found</p>
        </div>
        <div class="content-card-body">
            @if($roles->count() > 0)
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Role Name</th>
                                <th>Permissions</th>
                                <th>Users Count</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td>
                                    <div class="role-info">
                                        <div class="role-icon">
                                            @if($role->name === 'admin')
                                                <i class="fas fa-crown"></i>
                                            @elseif($role->name === 'instructor')
                                                <i class="fas fa-chalkboard-teacher"></i>
                                            @else
                                                <i class="fas fa-user"></i>
                                            @endif
                                        </div>
                                        <div class="role-details">
                                            <div class="role-name">{{ ucfirst($role->name) }}</div>
                                            <div class="role-description">
                                                @if($role->name === 'admin')
                                                    System Administrator
                                                @elseif($role->name === 'instructor')
                                                    Course Instructor
                                                @else
                                                    Regular User
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($role->permissions->count() > 0)
                                        <div class="permissions-list">
                                            @foreach($role->permissions->take(3) as $permission)
                                                <span class="permission-badge">{{ $permission->name }}</span>
                                            @endforeach
                                            @if($role->permissions->count() > 3)
                                                <span class="permission-badge more">+{{ $role->permissions->count() - 3 }} more</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted">No permissions</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="user-count">
                                        <i class="fas fa-users me-1"></i>
                                        {{ $role->users->count() }}
                                    </div>
                                </td>
                                <td>
                                    <div class="date-info">
                                        <div class="date">{{ $role->created_at->format('M j, Y') }}</div>
                                        <div class="time">{{ $role->created_at->format('g:i A') }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.roles.edit', $role) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Edit Role">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($role->name !== 'admin')
                                        <form method="POST" 
                                              action="{{ route('admin.roles.delete', $role) }}" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this role?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    title="Delete Role">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @else
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-secondary" 
                                                title="Cannot delete admin role" 
                                                disabled>
                                            <i class="fas fa-lock"></i>
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
                @if($roles->hasPages())
                    <div class="pagination-wrapper">
                        {{ $roles->links() }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-user-tag"></i>
                    </div>
                    <h3>No Roles Found</h3>
                    <p>There are no roles in the system yet.</p>
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Create First Role
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.roles-index {
    animation: fadeInUp 0.6s ease-out;
}

.page-header {
    margin-bottom: 3rem;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    letter-spacing: -0.02em;
}

.page-subtitle {
    font-size: 1.125rem;
    color: var(--text-muted);
    font-weight: 400;
}

.content-card-subtitle {
    font-size: 1rem;
    color: var(--text-muted);
    margin-bottom: 0;
}

/* Alerts */
.alert {
    border: none;
    border-radius: 12px;
    padding: 1rem 1.5rem;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
}

.alert-success {
    background: linear-gradient(135deg, rgba(0, 208, 132, 0.1), rgba(0, 208, 132, 0.05));
    color: var(--success);
    border: 1px solid rgba(0, 208, 132, 0.3);
}

.alert-danger {
    background: linear-gradient(135deg, rgba(229, 9, 20, 0.1), rgba(229, 9, 20, 0.05));
    color: var(--error);
    border: 1px solid rgba(229, 9, 20, 0.3);
}

.btn-close {
    background: none;
    border: none;
    color: inherit;
    opacity: 0.7;
    margin-left: auto;
}

.btn-close:hover {
    opacity: 1;
}

/* Table Styles */
.table-responsive {
    overflow-x: auto;
}

.modern-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 2rem;
}

.modern-table th {
    background: var(--bg-tertiary);
    color: var(--text-secondary);
    font-weight: 600;
    padding: 1rem 1.5rem;
    text-align: left;
    border-bottom: 1px solid var(--border-primary);
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.modern-table td {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-primary);
    vertical-align: middle;
}

.modern-table tr:hover {
    background: var(--bg-hover);
}

/* Role Info */
.role-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.role-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, rgba(247, 163, 26, 0.2), rgba(247, 163, 26, 0.1));
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    color: var(--primary-color);
    border: 1px solid rgba(247, 163, 26, 0.3);
}

.role-details {
    flex: 1;
}

.role-name {
    font-weight: 600;
    color: var(--text-primary);
    font-size: 1rem;
    margin-bottom: 0.25rem;
}

.role-description {
    font-size: 0.875rem;
    color: var(--text-muted);
}

/* Permissions List */
.permissions-list {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.permission-badge {
    background: var(--bg-tertiary);
    color: var(--text-secondary);
    padding: 0.25rem 0.75rem;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 500;
    border: 1px solid var(--border-primary);
}

.permission-badge.more {
    background: var(--bg-hover);
    color: var(--text-muted);
}

/* User Count */
.user-count {
    display: flex;
    align-items: center;
    color: var(--text-secondary);
    font-weight: 500;
}

/* Date Info */
.date-info {
    text-align: left;
}

.date {
    font-weight: 600;
    color: var(--text-primary);
    font-size: 0.9rem;
}

.time {
    font-size: 0.8rem;
    color: var(--text-muted);
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-sm {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 8px;
}

.btn-outline-primary {
    border: 1px solid var(--primary-color);
    color: var(--primary-color);
    background: transparent;
}

.btn-outline-primary:hover {
    background: var(--primary-color);
    color: var(--bg-primary);
}

.btn-outline-danger {
    border: 1px solid var(--error);
    color: var(--error);
    background: transparent;
}

.btn-outline-danger:hover {
    background: var(--error);
    color: white;
}

.btn-outline-secondary {
    border: 1px solid var(--border-secondary);
    color: var(--text-disabled);
    background: transparent;
    cursor: not-allowed;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-muted);
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: var(--bg-tertiary);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: var(--text-muted);
    margin: 0 auto 2rem;
    border: 1px solid var(--border-primary);
}

.empty-state h3 {
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.empty-state p {
    margin-bottom: 2rem;
}

/* Pagination */
.pagination-wrapper {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
}

/* Responsive */
@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .modern-table th,
    .modern-table td {
        padding: 1rem;
    }
    
    .role-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .permissions-list {
        flex-direction: column;
    }
    
    .action-buttons {
        flex-direction: column;
    }
}
</style>
@endsection 