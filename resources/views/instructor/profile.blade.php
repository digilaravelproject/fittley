@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-edit text-primary"></i>
            My Profile
        </h1>
        <a href="{{ route('instructor.dashboard') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Profile Information -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profile Information</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('instructor.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $instructor->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $instructor->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Bio -->
                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" 
                                      id="bio" name="bio" rows="4" 
                                      placeholder="Tell students about yourself, your experience, and teaching style...">{{ old('bio', $instructor->bio) }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle"></i>
                                This will be displayed to students viewing your sessions
                            </div>
                        </div>

                        <!-- Avatar URL -->
                        <div class="mb-3">
                            <label for="avatar" class="form-label">Avatar Image URL</label>
                            <input type="url" class="form-control @error('avatar') is-invalid @enderror" 
                                   id="avatar" name="avatar" value="{{ old('avatar', $instructor->avatar) }}" 
                                   placeholder="https://example.com/avatar.jpg">
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle"></i>
                                Add a professional photo URL
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Profile Summary -->
        <div class="col-lg-4">
            <!-- Current Profile Display -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profile Preview</h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        @if($instructor->avatar)
                            <img src="{{ $instructor->avatar }}" alt="{{ $instructor->name }}" 
                                 class="rounded-circle" width="80" height="80" style="object-fit: cover;">
                        @else
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" 
                                 style="width: 80px; height: 80px; font-size: 2rem;">
                                {{ substr($instructor->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <h5 class="mb-1">{{ $instructor->name }}</h5>
                    <p class="text-muted mb-2">{{ $instructor->email }}</p>
                    <span class="badge badge-primary">
                        <i class="fas fa-chalkboard-teacher"></i> Instructor
                    </span>
                    
                    @if($instructor->bio)
                        <div class="mt-3">
                            <small class="text-muted">{{ Str::limit($instructor->bio, 100) }}</small>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Account Statistics -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Account Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="h4 mb-0 font-weight-bold text-primary">
                                {{ $instructor->instructorSessions()->count() }}
                            </div>
                            <div class="small text-muted">Total Sessions</div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="h4 mb-0 font-weight-bold text-success">
                                {{ $instructor->instructorSessions()->where('status', 'ended')->count() }}
                            </div>
                            <div class="small text-muted">Completed</div>
                        </div>
                        <div class="col-6">
                            <div class="h4 mb-0 font-weight-bold text-info">
                                {{ number_format($instructor->instructorSessions()->sum('viewer_peak')) }}
                            </div>
                            <div class="small text-muted">Total Viewers</div>
                        </div>
                        <div class="col-6">
                            <div class="h4 mb-0 font-weight-bold text-warning">
                                {{ $instructor->created_at->format('M Y') }}
                            </div>
                            <div class="small text-muted">Joined</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('instructor.sessions.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create New Session
                        </a>
                        <a href="{{ route('instructor.sessions') }}" class="btn btn-outline-primary">
                            <i class="fas fa-video"></i> Manage Sessions
                        </a>
                        <a href="{{ route('instructor.analytics') }}" class="btn btn-outline-info">
                            <i class="fas fa-chart-bar"></i> View Analytics
                        </a>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="fas fa-key"></i> Change Password
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">
                    <i class="fas fa-key"></i> Change Password
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('instructor.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Live preview for avatar
    const avatarInput = document.getElementById('avatar');
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const bioInput = document.getElementById('bio');
    
    function updatePreview() {
        // This would update the preview in real-time
        // For now, we'll keep it simple and update on form submission
    }
    
    // Add event listeners for live preview
    avatarInput.addEventListener('input', updatePreview);
    nameInput.addEventListener('input', updatePreview);
    emailInput.addEventListener('input', updatePreview);
    bioInput.addEventListener('input', updatePreview);
});
</script>
@endsection 