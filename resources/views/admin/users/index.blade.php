@extends('layouts.admin')

@section('content')
<style>
    .pagination-wrapper {
        display: flex;
        justify-content: space-between; /* info left, controls right */
        align-items: center;            /* vertical align center */
        flex-wrap: wrap;                /* wrap if screen small */
        width: 100%;
        padding: 10px 15px;
    }
    .pagination-info {
        font-size: 14px;
        color: #aaa;
    }
    .pagination-controls {
        display: flex;
        justify-content: flex-end;
    }
</style>
<div class="users-management">
    <!-- Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-users me-3"></i>
                    User Management
                </h1>
                <p class="page-subtitle">Manage user accounts, roles, and permissions</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Add New User
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid mb-5">
        <div class="row g-4">
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card stat-card-primary">
                    <div class="stat-card-body">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $users->total() }}</div>
                            <div class="stat-label">Total Users</div>
                            <div class="stat-trend">
                                <i class="fas fa-arrow-up"></i>
                                <span>Active accounts</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card stat-card-success">
                    <div class="stat-card-body">
                        <div class="stat-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $users->where('roles.name', 'admin')->count() }}</div>
                            <div class="stat-label">Administrators</div>
                            <div class="stat-trend">
                                <i class="fas fa-shield-alt"></i>
                                <span>System admins</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card stat-card-info">
                    <div class="stat-card-body">
                        <div class="stat-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $users->where('roles.name', 'instructor')->count() }}</div>
                            <div class="stat-label">Instructors</div>
                            <div class="stat-trend">
                                <i class="fas fa-graduation-cap"></i>
                                <span>Course creators</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card stat-card-warning">
                    <div class="stat-card-body">
                        <div class="stat-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $users->where('roles.name', 'user')->count() }}</div>
                            <div class="stat-label">Students</div>
                            <div class="stat-trend">
                                <i class="fas fa-book-open"></i>
                                <span>Learners</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="content-card">
        <div class="content-card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="content-card-title">
                        <i class="fas fa-list me-2"></i>
                        All Users
                    </h3>
                    <p class="content-card-subtitle">Complete list of registered users</p>
                </div>
                <div class="table-controls">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search users..." class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="content-card-body p-0">
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Joined</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="user-details">
                                        <div class="user-name">{{ $user->name }}</div>
                                        <div class="user-id">#{{ $user->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="user-email">{{ $user->email }}</div>
                            </td>
                            <td>
                                <div class="role-badges">
                                    @forelse($user->roles as $role)
                                        <span class="role-badge role-{{ $role->name }}">
                                            @if($role->name === 'admin')
                                                <i class="fas fa-crown"></i>
                                            @elseif($role->name === 'instructor')
                                                <i class="fas fa-chalkboard-teacher"></i>
                                            @else
                                                <i class="fas fa-user"></i>
                                            @endif
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @empty
                                        <span class="role-badge role-none">No Role</span>
                                    @endforelse
                                </div>
                            </td>
                            <td>
                                <div class="date-info">
                                    <div class="date-primary">{{ $user->created_at->format('M d, Y') }}</div>
                                    <div class="date-secondary">{{ $user->created_at->diffForHumans() }}</div>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-active">
                                    <i class="fas fa-circle"></i>
                                    Active
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn action-btn-primary" title="View User">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="action-btn action-btn-warning" title="Edit User">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-btn action-btn-danger" title="Delete User">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="empty-content">
                                        <h4>No Users Found</h4>
                                        <p>There are no users to display at the moment.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($users->hasPages())
            <div class="content-card-footer">
                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        Showing {{ $users->firstItem() }}-{{ $users->lastItem() }} of {{ $users->total() }} users
                    </div>
                    <div class="pagination-controls">
                        {{ $users->links('pagination.custom') }}
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

<style>
/* Users Management Specific Styles */
.users-management {
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

/* Table Styles */
.table-controls {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.search-box {
    position: relative;
    display: flex;
    align-items: center;
}

.search-box i {
    position: absolute;
    left: 1rem;
    color: var(--text-muted);
    z-index: 2;
}

.search-box .form-control {
    background: var(--bg-tertiary);
    border: 1px solid var(--border-primary);
    border-radius: 12px;
    padding: 0.75rem 1rem 0.75rem 2.5rem;
    color: var(--text-primary);
    font-size: 0.95rem;
    width: 250px;
    transition: var(--transition-fast);
}

.search-box .form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(247, 163, 26, 0.1);
    background: var(--bg-card);
}

.search-box .form-control::placeholder {
    color: var(--text-muted);
}

.modern-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.95rem;
}

.modern-table thead th {
    background: var(--bg-tertiary);
    color: var(--text-secondary);
    font-weight: 600;
    padding: 1.5rem 1.5rem;
    text-align: left;
    border-bottom: 1px solid var(--border-primary);
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.modern-table tbody tr {
    border-bottom: 1px solid var(--border-primary);
    transition: var(--transition-fast);
}

.modern-table tbody tr:hover {
    background: var(--bg-tertiary);
}

.modern-table tbody td {
    padding: 1.5rem;
    vertical-align: middle;
}

/* User Info Styles */
.user-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.user-avatar {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--bg-primary);
    font-size: 1.25rem;
    box-shadow: var(--shadow-sm);
}

.user-details {
    display: flex;
    flex-direction: column;
}

.user-name {
    font-weight: 600;
    color: var(--text-primary);
    font-size: 1rem;
    line-height: 1.4;
}

.user-id {
    font-size: 0.8rem;
    color: var(--text-muted);
    font-weight: 500;
}

.user-email {
    color: var(--text-secondary);
    font-weight: 500;
}

/* Role Badges */
.role-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.role-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

.role-admin {
    background: linear-gradient(135deg, rgba(229, 9, 20, 0.2), rgba(229, 9, 20, 0.1));
    color: #ff6b6b;
    border: 1px solid rgba(229, 9, 20, 0.3);
}

.role-instructor {
    background: linear-gradient(135deg, rgba(0, 168, 255, 0.2), rgba(0, 168, 255, 0.1));
    color: #4dabf7;
    border: 1px solid rgba(0, 168, 255, 0.3);
}

.role-user {
    background: linear-gradient(135deg, rgba(0, 208, 132, 0.2), rgba(0, 208, 132, 0.1));
    color: #51cf66;
    border: 1px solid rgba(0, 208, 132, 0.3);
}

.role-none {
    background: linear-gradient(135deg, rgba(107, 107, 107, 0.2), rgba(107, 107, 107, 0.1));
    color: var(--text-muted);
    border: 1px solid rgba(107, 107, 107, 0.3);
}

/* Date Info */
.date-info {
    display: flex;
    flex-direction: column;
}

.date-primary {
    color: var(--text-primary);
    font-weight: 500;
    font-size: 0.95rem;
}

.date-secondary {
    color: var(--text-muted);
    font-size: 0.8rem;
    margin-top: 0.125rem;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

.status-active {
    background: linear-gradient(135deg, rgba(0, 208, 132, 0.2), rgba(0, 208, 132, 0.1));
    color: var(--success);
    border: 1px solid rgba(0, 208, 132, 0.3);
}

.status-active i {
    font-size: 0.5rem;
    animation: pulse 2s infinite;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition-fast);
    font-size: 0.875rem;
}

.action-btn-primary {
    background: linear-gradient(135deg, rgba(0, 168, 255, 0.2), rgba(0, 168, 255, 0.1));
    color: var(--info);
    border: 1px solid rgba(0, 168, 255, 0.3);
}

.action-btn-primary:hover {
    background: linear-gradient(135deg, rgba(0, 168, 255, 0.3), rgba(0, 168, 255, 0.2));
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

.action-btn-warning {
    background: linear-gradient(135deg, rgba(255, 176, 32, 0.2), rgba(255, 176, 32, 0.1));
    color: var(--warning);
    border: 1px solid rgba(255, 176, 32, 0.3);
}

.action-btn-warning:hover {
    background: linear-gradient(135deg, rgba(255, 176, 32, 0.3), rgba(255, 176, 32, 0.2));
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

.action-btn-danger {
    background: linear-gradient(135deg, rgba(229, 9, 20, 0.2), rgba(229, 9, 20, 0.1));
    color: var(--error);
    border: 1px solid rgba(229, 9, 20, 0.3);
}

.action-btn-danger:hover {
    background: linear-gradient(135deg, rgba(229, 9, 20, 0.3), rgba(229, 9, 20, 0.2));
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
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
    background: linear-gradient(135deg, rgba(247, 163, 26, 0.1), rgba(247, 163, 26, 0.05));
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: var(--primary-color);
    margin: 0 auto 2rem;
    border: 1px solid rgba(247, 163, 26, 0.2);
}

.empty-content h4 {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.empty-content p {
    font-size: 1rem;
    color: var(--text-muted);
    margin-bottom: 0;
}

/* Pagination */
.content-card-footer {
    padding: 1.5rem 2rem;
    border-top: 1px solid var(--border-primary);
    background: var(--bg-tertiary);
}

.pagination-wrapper {
    display: flex;
    justify-content: between;
    align-items: center;
}

.pagination-info {
    color: var(--text-muted);
    font-size: 0.9rem;
    font-weight: 500;
}

/* Responsive */
@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .table-controls {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }
    
    .search-box .form-control {
        width: 100%;
    }
    
    .modern-table {
        font-size: 0.875rem;
    }
    
    .modern-table thead th,
    .modern-table tbody td {
        padding: 1rem;
    }
    
    .user-info {
        gap: 0.75rem;
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .pagination-wrapper {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
}
</style>
@endsection 