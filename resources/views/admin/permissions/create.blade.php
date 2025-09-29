@extends('layouts.admin')

@section('content')
<div class="permission-create">
    <!-- Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-plus-circle me-3"></i>
                    Create New Permission
                </h1>
                <p class="page-subtitle">Create a new permission for system access control</p>
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
            <p class="content-card-subtitle">Fill in the details to create a new permission</p>
        </div>
        <div class="content-card-body">
            <form method="POST" action="{{ route('admin.permissions.store') }}" class="modern-form">
                @csrf
                
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
                                       value="{{ old('name') }}" 
                                       required 
                                       placeholder="Enter permission name (e.g., create_users, edit_posts)">
                            </div>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-help">
                                Use lowercase letters, numbers, and underscores only. Be descriptive and specific.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Permission Examples -->
                    <div class="col-12 mt-4">
                        <h4 class="section-title">
                            <i class="fas fa-lightbulb me-2"></i>
                            Common Permission Patterns
                        </h4>
                        <p class="section-description">
                            Here are some common permission naming patterns you can use
                        </p>
                    </div>
                    
                    <div class="col-12">
                        <div class="permission-examples">
                            <div class="example-category">
                                <h5 class="category-title">
                                    <i class="fas fa-users me-2"></i>
                                    User Management
                                </h5>
                                <div class="example-items">
                                    <button type="button" class="example-item" onclick="setPermissionName('create_users')">
                                        <i class="fas fa-plus"></i>
                                        <span>create_users</span>
                                    </button>
                                    <button type="button" class="example-item" onclick="setPermissionName('edit_users')">
                                        <i class="fas fa-edit"></i>
                                        <span>edit_users</span>
                                    </button>
                                    <button type="button" class="example-item" onclick="setPermissionName('delete_users')">
                                        <i class="fas fa-trash"></i>
                                        <span>delete_users</span>
                                    </button>
                                    <button type="button" class="example-item" onclick="setPermissionName('view_users')">
                                        <i class="fas fa-eye"></i>
                                        <span>view_users</span>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="example-category">
                                <h5 class="category-title">
                                    <i class="fas fa-graduation-cap me-2"></i>
                                    Course Management
                                </h5>
                                <div class="example-items">
                                    <button type="button" class="example-item" onclick="setPermissionName('create_courses')">
                                        <i class="fas fa-plus"></i>
                                        <span>create_courses</span>
                                    </button>
                                    <button type="button" class="example-item" onclick="setPermissionName('edit_courses')">
                                        <i class="fas fa-edit"></i>
                                        <span>edit_courses</span>
                                    </button>
                                    <button type="button" class="example-item" onclick="setPermissionName('delete_courses')">
                                        <i class="fas fa-trash"></i>
                                        <span>delete_courses</span>
                                    </button>
                                    <button type="button" class="example-item" onclick="setPermissionName('publish_courses')">
                                        <i class="fas fa-share"></i>
                                        <span>publish_courses</span>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="example-category">
                                <h5 class="category-title">
                                    <i class="fas fa-cog me-2"></i>
                                    System Administration
                                </h5>
                                <div class="example-items">
                                    <button type="button" class="example-item" onclick="setPermissionName('manage_settings')">
                                        <i class="fas fa-cogs"></i>
                                        <span>manage_settings</span>
                                    </button>
                                    <button type="button" class="example-item" onclick="setPermissionName('view_logs')">
                                        <i class="fas fa-file-alt"></i>
                                        <span>view_logs</span>
                                    </button>
                                    <button type="button" class="example-item" onclick="setPermissionName('backup_system')">
                                        <i class="fas fa-download"></i>
                                        <span>backup_system</span>
                                    </button>
                                    <button type="button" class="example-item" onclick="setPermissionName('manage_roles')">
                                        <i class="fas fa-user-tag"></i>
                                        <span>manage_roles</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Create Permission
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
.permission-create {
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

/* Permission Examples */
.permission-examples {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
}

.example-category {
    background: var(--bg-tertiary);
    border: 1px solid var(--border-primary);
    border-radius: 12px;
    padding: 1.5rem;
}

.category-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
}

.example-items {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 0.75rem;
}

.example-item {
    background: var(--bg-card);
    border: 1px solid var(--border-primary);
    border-radius: 8px;
    padding: 0.75rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: var(--transition-fast);
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.example-item:hover {
    border-color: var(--primary-color);
    background: var(--bg-hover);
    color: var(--text-primary);
    transform: translateY(-2px);
}

.example-item i {
    font-size: 1.1rem;
    color: var(--primary-color);
}

.example-item span {
    font-family: 'Courier New', monospace;
    font-weight: 500;
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
    
    .permission-examples {
        grid-template-columns: 1fr;
    }
    
    .example-items {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .form-actions {
        flex-direction: column-reverse;
    }
    
    .form-actions .btn {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .example-items {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
function setPermissionName(permissionName) {
    document.getElementById('name').value = permissionName;
    document.getElementById('name').focus();
}
</script>
@endsection 