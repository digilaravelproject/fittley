@extends('layouts.admin')

@section('content')
<div class="permissions-index">
    <!-- Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-shield-alt me-3"></i>
                    Permissions Management
                </h1>
                <p class="page-subtitle">Manage system permissions and access controls</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Create Permission
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

    <!-- Permissions Table -->
    <div class="content-card">
        <div class="content-card-header">
            <h3 class="content-card-title">
                <i class="fas fa-list me-2"></i>
                All Permissions
            </h3>
            <p class="content-card-subtitle">{{ $permissions->total() }} permissions found</p>
        </div>
        <div class="content-card-body">
            @if($permissions->count() > 0)
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Permission Name</th>
                                <th>Description</th>
                                <th>Roles</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $permission)
                            <tr>
                                <td>
                                    <div class="permission-info">
                                        <div class="permission-icon">
                                            @if(str_contains($permission->name, 'create'))
                                                <i class="fas fa-plus"></i>
                                            @elseif(str_contains($permission->name, 'edit') || str_contains($permission->name, 'update'))
                                                <i class="fas fa-edit"></i>
                                            @elseif(str_contains($permission->name, 'delete'))
                                                <i class="fas fa-trash"></i>
                                            @elseif(str_contains($permission->name, 'view') || str_contains($permission->name, 'read'))
                                                <i class="fas fa-eye"></i>
                                            @else
                                                <i class="fas fa-key"></i>
                                            @endif
                                        </div>
                                        <div class="permission-details">
                                            <div class="permission-name">{{ $permission->name }}</div>
                                            <div class="permission-slug">{{ ucwords(str_replace(['_', '-'], ' ', $permission->name)) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="permission-description">
                                        @if(str_contains($permission->name, 'create'))
                                            <span class="description-text">Allows creating new records</span>
                                            <span class="description-badge create">Create</span>
                                        @elseif(str_contains($permission->name, 'edit') || str_contains($permission->name, 'update'))
                                            <span class="description-text">Allows editing existing records</span>
                                            <span class="description-badge edit">Edit</span>
                                        @elseif(str_contains($permission->name, 'delete'))
                                            <span class="description-text">Allows deleting records</span>
                                            <span class="description-badge delete">Delete</span>
                                        @elseif(str_contains($permission->name, 'view') || str_contains($permission->name, 'read'))
                                            <span class="description-text">Allows viewing records</span>
                                            <span class="description-badge view">View</span>
                                        @else
                                            <span class="description-text">Custom permission</span>
                                            <span class="description-badge custom">Custom</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($permission->roles->count() > 0)
                                        <div class="roles-list">
                                            @foreach($permission->roles->take(2) as $role)
                                                <span class="role-badge">{{ ucfirst($role->name) }}</span>
                                            @endforeach
                                            @if($permission->roles->count() > 2)
                                                <span class="role-badge more">+{{ $permission->roles->count() - 2 }} more</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted">Not assigned</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="date-info">
                                        <div class="date">{{ $permission->created_at->format('M j, Y') }}</div>
                                        <div class="time">{{ $permission->created_at->format('g:i A') }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.permissions.edit', $permission) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Edit Permission">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" 
                                              action="{{ route('admin.permissions.delete', $permission) }}" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this permission?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    title="Delete Permission">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($permissions->hasPages())
                    <div class="pagination-wrapper">
                        {{ $permissions->links() }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>No Permissions Found</h3>
                    <p>There are no permissions in the system yet.</p>
                    <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Create First Permission
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.permissions-index {
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

/* Permission Info */
.permission-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.permission-icon {
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

.permission-details {
    flex: 1;
}

.permission-name {
    font-weight: 600;
    color: var(--text-primary);
    font-size: 1rem;
    margin-bottom: 0.25rem;
    font-family: 'Courier New', monospace;
}

.permission-slug {
    font-size: 0.875rem;
    color: var(--text-muted);
}

/* Permission Description */
.permission-description {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.description-text {
    font-size: 0.9rem;
    color: var(--text-secondary);
}

.description-badge {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    align-self: flex-start;
}

.description-badge.create {
    background: linear-gradient(135deg, rgba(0, 208, 132, 0.2), rgba(0, 208, 132, 0.1));
    color: var(--success);
    border: 1px solid rgba(0, 208, 132, 0.3);
}

.description-badge.edit {
    background: linear-gradient(135deg, rgba(0, 168, 255, 0.2), rgba(0, 168, 255, 0.1));
    color: var(--info);
    border: 1px solid rgba(0, 168, 255, 0.3);
}

.description-badge.delete {
    background: linear-gradient(135deg, rgba(229, 9, 20, 0.2), rgba(229, 9, 20, 0.1));
    color: var(--error);
    border: 1px solid rgba(229, 9, 20, 0.3);
}

.description-badge.view {
    background: linear-gradient(135deg, rgba(255, 176, 32, 0.2), rgba(255, 176, 32, 0.1));
    color: var(--warning);
    border: 1px solid rgba(255, 176, 32, 0.3);
}

.description-badge.custom {
    background: linear-gradient(135deg, rgba(247, 163, 26, 0.2), rgba(247, 163, 26, 0.1));
    color: var(--primary-color);
    border: 1px solid rgba(247, 163, 26, 0.3);
}

/* Roles List */
.roles-list {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.role-badge {
    background: var(--bg-tertiary);
    color: var(--text-secondary);
    padding: 0.25rem 0.75rem;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 500;
    border: 1px solid var(--border-primary);
}

.role-badge.more {
    background: var(--bg-hover);
    color: var(--text-muted);
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
    
    .permission-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .permission-description {
        flex-direction: column;
    }
    
    .roles-list {
        flex-direction: column;
    }
    
    .action-buttons {
        flex-direction: column;
    }
}
</style>
@endsection 