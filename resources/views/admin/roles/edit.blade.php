@extends('layouts.admin')

@section('content')
<div class="role-edit">
    <!-- Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-edit me-3"></i>
                    Edit Role
                </h1>
                <p class="page-subtitle">Update role information and permissions</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('admin.roles') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Roles
                </a>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="content-card">
        <div class="content-card-header">
            <h3 class="content-card-title">
                <i class="fas fa-user-tag me-2"></i>
                Role Information
            </h3>
            <p class="content-card-subtitle">Update details for {{ ucfirst($role->name) }} role</p>
        </div>
        <div class="content-card-body">
            <form method="POST" action="{{ route('admin.roles.update', $role) }}" class="modern-form">
                @csrf
                @method('PUT')
                
                <div class="row g-4">
                    <!-- Basic Information -->
                    <div class="col-12">
                        <h4 class="section-title">
                            <i class="fas fa-info-circle me-2"></i>
                            Basic Information
                        </h4>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label">Role Name *</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-user-tag"></i>
                                </span>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $role->name) }}" 
                                       required 
                                       placeholder="Enter role name">
                            </div>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-help">
                                Role names should be lowercase and descriptive
                            </div>
                        </div>
                    </div>
                    
                    <!-- Role Statistics -->
                    <div class="col-12 mt-4">
                        <h4 class="section-title">
                            <i class="fas fa-chart-bar me-2"></i>
                            Role Statistics
                        </h4>
                    </div>
                    
                    <div class="col-12">
                        <div class="role-stats">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stat-info">
                                    <div class="stat-label">Users with this role</div>
                                    <div class="stat-value">{{ $role->users->count() }}</div>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div class="stat-info">
                                    <div class="stat-label">Assigned permissions</div>
                                    <div class="stat-value">{{ $role->permissions->count() }}</div>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="stat-info">
                                    <div class="stat-label">Created on</div>
                                    <div class="stat-value">{{ $role->created_at->format('M j, Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Permissions Section -->
                    <div class="col-12 mt-4">
                        <h4 class="section-title">
                            <i class="fas fa-shield-alt me-2"></i>
                            Permissions
                        </h4>
                        <p class="section-description">
                            Select the permissions that users with this role will have
                        </p>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-group">
                            @if($permissions->count() > 0)
                                <div class="permissions-grid">
                                    @foreach($permissions as $permission)
                                    <div class="permission-option">
                                        <input type="checkbox" 
                                               id="permission_{{ $permission->id }}" 
                                               name="permissions[]" 
                                               value="{{ $permission->name }}" 
                                               class="permission-checkbox"
                                               {{ $role->hasPermissionTo($permission->name) || in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
                                        <label for="permission_{{ $permission->id }}" class="permission-label">
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
                                            <div class="permission-info">
                                                <div class="permission-name">{{ ucwords(str_replace(['_', '-'], ' ', $permission->name)) }}</div>
                                                <div class="permission-description">
                                                    @if(str_contains($permission->name, 'create'))
                                                        Allows creating new records
                                                    @elseif(str_contains($permission->name, 'edit') || str_contains($permission->name, 'update'))
                                                        Allows editing existing records
                                                    @elseif(str_contains($permission->name, 'delete'))
                                                        Allows deleting records
                                                    @elseif(str_contains($permission->name, 'view') || str_contains($permission->name, 'read'))
                                                        Allows viewing records
                                                    @else
                                                        {{ $permission->name }}
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="permission-check">
                                                <i class="fas fa-check"></i>
                                            </div>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                
                                <!-- Quick Select Actions -->
                                <div class="quick-actions">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="selectAllPermissions()">
                                        <i class="fas fa-check-double me-1"></i>
                                        Select All
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="deselectAllPermissions()">
                                        <i class="fas fa-times me-1"></i>
                                        Deselect All
                                    </button>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    No permissions available. Create some permissions first.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Update Role
                    </button>
                    <a href="{{ route('admin.roles') }}" class="btn btn-outline-secondary">
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
.role-edit {
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

.section-description {
    color: var(--text-muted);
    margin-bottom: 2rem;
    font-size: 1rem;
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
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(247, 163, 26, 0.1);
    background: var(--bg-card);
    outline: none;
}

.form-control::placeholder {
    color: var(--text-muted);
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

.alert {
    padding: 1rem 1.5rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    border: 1px solid;
    display: flex;
    align-items: center;
}

.alert-warning {
    background: linear-gradient(135deg, rgba(255, 176, 32, 0.1), rgba(255, 176, 32, 0.05));
    border-color: rgba(255, 176, 32, 0.3);
    color: var(--warning);
}

/* Role Stats */
.role-stats {
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

/* Permissions Grid */
.permissions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.permission-option {
    position: relative;
}

.permission-checkbox {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.permission-label {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: var(--bg-tertiary);
    border: 1px solid var(--border-primary);
    border-radius: 12px;
    cursor: pointer;
    transition: var(--transition-fast);
    position: relative;
}

.permission-label:hover {
    border-color: var(--primary-color);
    background: var(--bg-hover);
}

.permission-checkbox:checked + .permission-label {
    border-color: var(--primary-color);
    background: linear-gradient(135deg, rgba(247, 163, 26, 0.1), rgba(247, 163, 26, 0.05));
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

.permission-info {
    flex: 1;
}

.permission-name {
    font-weight: 600;
    color: var(--text-primary);
    font-size: 1rem;
    margin-bottom: 0.25rem;
}

.permission-description {
    font-size: 0.875rem;
    color: var(--text-muted);
    line-height: 1.4;
}

.permission-check {
    width: 20px;
    height: 20px;
    border: 2px solid var(--border-primary);
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition-fast);
}

.permission-checkbox:checked + .permission-label .permission-check {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: var(--bg-primary);
}

.permission-check i {
    font-size: 0.75rem;
    opacity: 0;
    transition: var(--transition-fast);
}

.permission-checkbox:checked + .permission-label .permission-check i {
    opacity: 1;
}

/* Quick Actions */
.quick-actions {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    border-radius: 8px;
}

.btn-outline-secondary {
    background: transparent;
    border: 1px solid var(--border-secondary);
    color: var(--text-secondary);
}

.btn-outline-secondary:hover {
    background: var(--bg-hover);
    border-color: var(--border-primary);
    color: var(--text-primary);
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
    
    .role-stats {
        grid-template-columns: 1fr;
    }
    
    .permissions-grid {
        grid-template-columns: 1fr;
    }
    
    .quick-actions {
        flex-direction: column;
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

<script>
function selectAllPermissions() {
    const checkboxes = document.querySelectorAll('.permission-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = true;
    });
}

function deselectAllPermissions() {
    const checkboxes = document.querySelectorAll('.permission-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
}
</script>
@endsection 