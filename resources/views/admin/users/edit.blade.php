@extends('layouts.admin')

@section('content')
<div class="user-edit">
    <!-- Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-user-edit me-3"></i>
                    Edit User
                </h1>
                <p class="page-subtitle">Update user information, roles and permissions</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('admin.users') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Users
                </a>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="content-card">
        <div class="content-card-header">
            <h3 class="content-card-title">
                <i class="fas fa-user-edit me-2"></i>
                User Information
            </h3>
            <p class="content-card-subtitle">Update the details for {{ $user->name }}</p>
        </div>
        <div class="content-card-body">
            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="modern-form">
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
                            <label for="name" class="form-label">Full Name *</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $user->name) }}" 
                                       required 
                                       placeholder="Enter full name">
                            </div>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="form-label">Email Address *</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $user->email) }}" 
                                       required 
                                       placeholder="Enter email address">
                            </div>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Password Section -->
                    <div class="col-12 mt-4">
                        <h4 class="section-title">
                            <i class="fas fa-lock me-2"></i>
                            Security
                        </h4>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Leave password fields empty to keep the current password
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="form-label">New Password</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       placeholder="Enter new password">
                                <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       class="form-control" 
                                       placeholder="Confirm new password">
                                <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Roles Section -->
                    <div class="col-12 mt-4">
                        <h4 class="section-title">
                            <i class="fas fa-user-tag me-2"></i>
                            Roles & Permissions
                        </h4>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">Assign Roles</label>
                            <div class="roles-grid">
                                @foreach($roles as $role)
                                <div class="role-option">
                                    <input type="checkbox" 
                                           id="role_{{ $role->id }}" 
                                           name="roles[]" 
                                           value="{{ $role->name }}" 
                                           class="role-checkbox"
                                           {{ $user->hasRole($role->name) || in_array($role->name, old('roles', [])) ? 'checked' : '' }}>
                                    <label for="role_{{ $role->id }}" class="role-label">
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
                                            <div class="role-description">
                                                @if($role->name === 'admin')
                                                    Full system access and management
                                                @elseif($role->name === 'instructor')
                                                    Course creation and management
                                                @else
                                                    Basic user access and learning
                                                @endif
                                            </div>
                                        </div>
                                        <div class="role-check">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <!-- User Stats -->
                    <div class="col-12 mt-4">
                        <h4 class="section-title">
                            <i class="fas fa-chart-bar me-2"></i>
                            User Statistics
                        </h4>
                    </div>
                    
                    <div class="col-12">
                        <div class="user-stats">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="stat-info">
                                    <div class="stat-label">Member Since</div>
                                    <div class="stat-value">{{ $user->created_at->format('F j, Y') }}</div>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="stat-info">
                                    <div class="stat-label">Last Updated</div>
                                    <div class="stat-value">{{ $user->updated_at->format('F j, Y g:i A') }}</div>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-user-tag"></i>
                                </div>
                                <div class="stat-info">
                                    <div class="stat-label">Current Roles</div>
                                    <div class="stat-value">{{ $user->roles->count() }} roles</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Update User
                    </button>
                    <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
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
.user-edit {
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

.password-toggle {
    position: absolute;
    right: 1rem;
    background: none;
    border: none;
    color: var(--text-muted);
    cursor: pointer;
    z-index: 3;
    padding: 0.5rem;
    transition: var(--transition-fast);
}

.password-toggle:hover {
    color: var(--primary-color);
}

.alert {
    padding: 1rem 1.5rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    border: 1px solid;
    display: flex;
    align-items: center;
}

.alert-info {
    background: linear-gradient(135deg, rgba(0, 168, 255, 0.1), rgba(0, 168, 255, 0.05));
    border-color: rgba(0, 168, 255, 0.3);
    color: #4dabf7;
}

/* Roles Grid */
.roles-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1rem;
}

.role-option {
    position: relative;
}

.role-checkbox {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.role-label {
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

.role-label:hover {
    border-color: var(--primary-color);
    background: var(--bg-hover);
}

.role-checkbox:checked + .role-label {
    border-color: var(--primary-color);
    background: linear-gradient(135deg, rgba(247, 163, 26, 0.1), rgba(247, 163, 26, 0.05));
}

.role-icon {
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

.role-info {
    flex: 1;
}

.role-name {
    font-weight: 600;
    color: var(--text-primary);
    font-size: 1.1rem;
    margin-bottom: 0.25rem;
}

.role-description {
    font-size: 0.9rem;
    color: var(--text-muted);
    line-height: 1.4;
}

.role-check {
    width: 24px;
    height: 24px;
    border: 2px solid var(--border-primary);
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition-fast);
}

.role-checkbox:checked + .role-label .role-check {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: var(--bg-primary);
}

.role-check i {
    font-size: 0.875rem;
    opacity: 0;
    transition: var(--transition-fast);
}

.role-checkbox:checked + .role-label .role-check i {
    opacity: 1;
}

/* User Stats */
.user-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
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
    
    .roles-grid {
        grid-template-columns: 1fr;
    }
    
    .user-stats {
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

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const toggle = field.nextElementSibling;
    const icon = toggle.querySelector('i');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endsection 