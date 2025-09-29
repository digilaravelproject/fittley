@extends('layouts.admin')

@section('content')
<div class="permission-edit">
    <!-- Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-edit me-3"></i>
                    Edit Permission
                </h1>
                <p class="page-subtitle">Update permission information</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('admin.permissions') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Permissions
                </a>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="content-card">
        <div class="content-card-header">
            <h3 class="content-card-title">
                <i class="fas fa-shield-alt me-2"></i>
                Permission Information
            </h3>
            <p class="content-card-subtitle">Update details for {{ $permission->name }}</p>
        </div>
        <div class="content-card-body">
            <form method="POST" action="{{ route('admin.permissions.update', $permission) }}" class="modern-form">
                @csrf
                @method('PUT')
                
                <div class="row g-4">
                    <!-- Basic Information -->
                    <div class="col-12">
                        <h4 class="section-title">
                            <i class="fas fa-info-circle me-2"></i>
                            Permission Details
                        </h4>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name" class="form-label">Permission Name *</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-key"></i>
                                </span>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $permission->name) }}" 
                                       required 
                                       placeholder="Enter permission name">
                            </div>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-help">
                                Use lowercase letters, numbers, and underscores only. Be descriptive and specific.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Permission Statistics -->
                    <div class="col-12 mt-4">
                        <h4 class="section-title">
                            <i class="fas fa-chart-bar me-2"></i>
                            Permission Statistics
                        </h4>
                    </div>
                    
                    <div class="col-12">
                        <div class="permission-stats">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-user-tag"></i>
                                </div>
                                <div class="stat-info">
                                    <div class="stat-label">Roles with this permission</div>
                                    <div class="stat-value">{{ $permission->roles->count() }}</div>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stat-info">
                                    <div class="stat-label">Users affected</div>
                                    <div class="stat-value">
                                        @php
                                            $userCount = 0;
                                            foreach($permission->roles as $role) {
                                                $userCount += $role->users->count();
                                            }
                                        @endphp
                                        {{ $userCount }}
                                    </div>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="stat-info">
                                    <div class="stat-label">Created on</div>
                                    <div class="stat-value">{{ $permission->created_at->format('M j, Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Assigned Roles -->
                    @if($permission->roles->count() > 0)
                    <div class="col-12 mt-4">
                        <h4 class="section-title">
                            <i class="fas fa-user-tag me-2"></i>
                            Assigned to Roles
                        </h4>
                    </div>
                    
                    <div class="col-12">
                        <div class="assigned-roles">
                            @foreach($permission->roles as $role)
                            <div class="role-card">
                                <div class="role-icon">
                                    @if($role->name === 'admin')
                                        <i class="fas fa-crown"></i>
                                    @elseif($role->name === 'instructor')
                                        <i class="fas fa-chalkboard-teacher"></i>
                                    @else
                                        <i class="fas fa-user"></i>
                                    @endif
                                </div>
                                <div class="role-info">
                                    <div class="role-name">{{ ucfirst($role->name) }}</div>
                                    <div class="role-description">{{ $role->users->count() }} users</div>
                                </div>
                                <div class="role-actions">
                                    <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Update Permission
                    </button>
                    <a href="{{ route('admin.permissions') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Form Styles */
.permission-edit {
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

.modern-form {
    max-width: none;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid var(--border-primary);
    display: flex;
    align-items: center;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--text-secondary);
    font-size: 0.95rem;
}

.input-group {
    position: relative;
    display: flex;
    align-items: center;
}

.input-icon {
    position: absolute;
    left: 1rem;
    z-index: 3;
    color: var(--text-muted);
    font-size: 1rem;
}

.form-control {
    background: var(--bg-tertiary);
    border: 1px solid var(--border-primary);
    border-radius: 12px;
    padding: 0.75rem 1rem 0.75rem 3rem;
    color: var(--text-primary);
    font-size: 0.95rem;
    transition: var(--transition-fast);
    width: 100%;
    font-family: 'Courier New', monospace;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(247, 163, 26, 0.1);
    background: var(--bg-card);
    outline: none;
}

.form-control::placeholder {
    color: var(--text-muted);
    font-family: inherit;
}

.form-control.is-invalid {
    border-color: var(--error);
}

.invalid-feedback {
    display: block;
    color: var(--error);
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

.form-help {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin-top: 0.5rem;
}

/* Permission Stats */
.permission-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: var(--bg-tertiary);
    border: 1px solid var(--border-primary);
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: var(--transition-fast);
}

.stat-card:hover {
    border-color: var(--primary-color);
    background: var(--bg-hover);
}

.stat-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, rgba(247, 163, 26, 0.2), rgba(247, 163, 26, 0.1));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: var(--primary-color);
    border: 1px solid rgba(247, 163, 26, 0.3);
}

.stat-info {
    flex: 1;
}

.stat-label {
    font-size: 0.9rem;
    color: var(--text-muted);
    margin-bottom: 0.25rem;
}

.stat-value {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-primary);
}

/* Assigned Roles */
.assigned-roles {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1rem;
}

.role-card {
    background: var(--bg-tertiary);
    border: 1px solid var(--border-primary);
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: var(--transition-fast);
}

.role-card:hover {
    border-color: var(--primary-color);
    background: var(--bg-hover);
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

.role-info {
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

.role-actions {
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

/* Form Actions */
.form-actions {
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 1px solid var(--border-primary);
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

/* Responsive */
@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .permission-stats {
        grid-template-columns: 1fr;
    }
    
    .assigned-roles {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column-reverse;
    }
    
    .form-actions .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection 