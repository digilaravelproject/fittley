@extends('layouts.admin')

@section('title', 'Create FitNews Stream')

@section('content')
<div class="admin-dashboard">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h1 class="page-title-text">
                    <i class="fas fa-newspaper page-title-icon"></i>
                    Create FitNews Stream
                </h1>
                <p class="page-subtitle">Create a new live news stream for your fitness platform</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.fitnews.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Streams
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content-grid">
        <div class="content-main">
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus-circle me-2"></i>Stream Details
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.fitnews.store') }}" method="POST" enctype="multipart/form-data" class="form-modern">
                        @csrf
                        
                        <div class="form-section">
                            <div class="form-section-title">Basic Information</div>
                            
                            <div class="form-group">
                                <label for="title" class="form-label">Stream Title <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title') }}" 
                                       placeholder="Enter stream title..."
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="4"
                                          placeholder="Describe your news stream...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="thumbnail" class="form-label">Thumbnail Image</label>
                                <input type="file" 
                                       class="form-control @error('thumbnail') is-invalid @enderror" 
                                       id="thumbnail" 
                                       name="thumbnail" 
                                       accept="image/*">
                                @error('thumbnail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Upload a thumbnail image (JPEG, PNG, JPG, GIF - Max: 2MB)</div>
                            </div>
                        </div>

                        <div class="form-section">
                            <div class="form-section-title">Stream Settings</div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror" 
                                                id="status" 
                                                name="status" 
                                                required>
                                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                                            <option value="scheduled" {{ old('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                            <option value="live" {{ old('status') === 'live' ? 'selected' : '' }}>Go Live Now</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group" id="scheduled-time-group" style="display: none;">
                                        <label for="scheduled_at" class="form-label">Scheduled Time</label>
                                        <input type="datetime-local" 
                                               class="form-control @error('scheduled_at') is-invalid @enderror" 
                                               id="scheduled_at" 
                                               name="scheduled_at" 
                                               value="{{ old('scheduled_at') }}">
                                        @error('scheduled_at')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check-custom">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="recording_enabled" 
                                           name="recording_enabled" 
                                           value="1" 
                                           {{ old('recording_enabled') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="recording_enabled">
                                        <strong>Enable Recording</strong>
                                        <span class="form-check-description">Record this stream for later viewing</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Stream
                            </button>
                            <a href="{{ route('admin.fitnews.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="content-sidebar">
            <div class="content-card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-info-circle me-2"></i>Stream Information
                    </h4>
                </div>
                <div class="card-body">
                    <div class="info-list">
                        <div class="info-item">
                            <i class="fas fa-broadcast-tower info-icon"></i>
                            <div class="info-content">
                                <div class="info-title">Channel</div>
                                <div class="info-description">Auto-generated unique channel name</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-video info-icon"></i>
                            <div class="info-content">
                                <div class="info-title">Streaming</div>
                                <div class="info-description">Agora RTC enabled for live streaming</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-users info-icon"></i>
                            <div class="info-content">
                                <div class="info-title">Viewers</div>
                                <div class="info-description">Real-time viewer count tracking</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-record-vinyl info-icon"></i>
                            <div class="info-content">
                                <div class="info-title">Recording</div>
                                <div class="info-description">Optional stream recording for replay</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-lightbulb me-2"></i>Tips for Success
                    </h4>
                </div>
                <div class="card-body">
                    <div class="tips-list">
                        <div class="tip-item">
                            <i class="fas fa-check-circle tip-icon"></i>
                            <span>Use engaging titles that describe your news content</span>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check-circle tip-icon"></i>
                            <span>Upload high-quality thumbnails to attract viewers</span>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check-circle tip-icon"></i>
                            <span>Schedule streams in advance for better attendance</span>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check-circle tip-icon"></i>
                            <span>Enable recording to create content library</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const scheduledGroup = document.getElementById('scheduled-time-group');
    
    function toggleScheduledTime() {
        if (statusSelect.value === 'scheduled') {
            scheduledGroup.style.display = 'block';
            document.getElementById('scheduled_at').required = true;
        } else {
            scheduledGroup.style.display = 'none';
            document.getElementById('scheduled_at').required = false;
        }
    }
    
    statusSelect.addEventListener('change', toggleScheduledTime);
    toggleScheduledTime(); // Initial check
});
</script>
@endsection
