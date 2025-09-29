@extends('layouts.admin')

@section('title', 'Edit Episode - ' . $episode->title)

@section('content')
<div class="container-fluid">
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-edit me-3"></i>Edit Episode
                </h1>
                <p class="page-subtitle">{{ $series->title }} - Episode {{ $episode->episode_number }}</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('admin.fitdoc.series.episodes', $series) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Episodes
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('admin.fitdoc.series.episodes.update', [$series, $episode]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-8">
                        <!-- Basic Information -->
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label for="title">Episode Title *</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title', $episode->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="episode_number">Episode Number *</label>
                                    <input type="number" class="form-control @error('episode_number') is-invalid @enderror" 
                                           id="episode_number" name="episode_number" value="{{ old('episode_number', $episode->episode_number) }}" min="1" required>
                                    @error('episode_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Episode Description *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description', $episode->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="release_date">Release Date *</label>
                                    <input type="date" class="form-control @error('release_date') is-invalid @enderror" 
                                           id="release_date" name="release_date" value="{{ old('release_date', $episode->release_date ? $episode->release_date->format('Y-m-d') : '') }}" required>
                                    @error('release_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="duration_minutes">Duration (minutes) *</label>
                                    <input type="number" class="form-control @error('duration_minutes') is-invalid @enderror" 
                                           id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes', $episode->duration_minutes) }}" min="1" required>
                                    @error('duration_minutes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Video Section -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5>Episode Video *</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="video_type">Video Source *</label>
                                            <select class="form-control @error('video_type') is-invalid @enderror" 
                                                    id="video_type" name="video_type" required>
                                                <option value="">Select Source</option>
                                                <option value="youtube" {{ old('video_type', $episode->video_type) == 'youtube' ? 'selected' : '' }}>YouTube</option>
                                                <option value="s3" {{ old('video_type', $episode->video_type) == 's3' ? 'selected' : '' }}>S3 URL</option>
                                                <option value="upload" {{ old('video_type', $episode->video_type) == 'upload' ? 'selected' : '' }}>Upload File</option>
                                            </select>
                                            @error('video_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group mb-3">
                                            <label id="video-input-label">Video URL/File</label>
                                            <input type="url" class="form-control @error('video_url') is-invalid @enderror" 
                                                   id="video_url" name="video_url" value="{{ old('video_url', $episode->video_url) }}" 
                                                   placeholder="Enter video URL" style="display: none;">
                                            <input type="file" class="form-control @error('video_file') is-invalid @enderror" 
                                                   id="video_file" name="video_file" accept="video/*" style="display: none;">
                                            @if($episode->video_file_path)
                                                <div class="current-file">
                                                    <small class="text-muted">Current file: {{ basename($episode->video_file_path) }}</small>
                                                </div>
                                            @endif
                                            @error('video_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @error('video_file')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Current Banner -->
                        @if($episode->banner_image_path)
                            <div class="current-banner mb-3">
                                <label>Current Banner</label>
                                <div class="banner-preview">
                                    <img src="{{ asset('storage/app/public/' . $episode->banner_image_path) }}" 
                                         alt="Current banner" class="img-fluid rounded">
                                </div>
                            </div>
                        @endif

                        <!-- Episode Banner -->
                        <div class="form-group mb-3">
                            <label for="banner_image">Episode Banner</label>
                            <input type="file" class="form-control @error('banner_image') is-invalid @enderror" 
                                   id="banner_image" name="banner_image" accept="image/*">
                            <small class="form-text text-muted">Max size: 2MB. Leave empty to keep current.</small>
                            @error('banner_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Banner Preview -->
                        <div id="banner-preview" class="banner-preview mb-3" style="display: none;">
                            <img id="preview-image" src="" alt="Banner preview" class="img-fluid rounded">
                        </div>

                        <!-- Episode Trailer -->
                        <div class="form-group mb-3">
                            <label for="trailer_type">Episode Trailer (Optional)</label>
                            <select class="form-control @error('trailer_type') is-invalid @enderror" 
                                    id="trailer_type" name="trailer_type">
                                <option value="">No Trailer</option>
                                <option value="youtube" {{ old('trailer_type', $episode->trailer_type) == 'youtube' ? 'selected' : '' }}>YouTube</option>
                                <option value="s3" {{ old('trailer_type', $episode->trailer_type) == 's3' ? 'selected' : '' }}>S3 URL</option>
                                <option value="upload" {{ old('trailer_type', $episode->trailer_type) == 'upload' ? 'selected' : '' }}>Upload File</option>
                            </select>
                            @error('trailer_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3" id="trailer-input-group" style="display: none;">
                            <input type="url" class="form-control @error('trailer_url') is-invalid @enderror" 
                                   id="trailer_url" name="trailer_url" value="{{ old('trailer_url', $episode->trailer_url) }}" 
                                   placeholder="Enter trailer URL" style="display: none;">
                            <input type="file" class="form-control @error('trailer_file') is-invalid @enderror" 
                                   id="trailer_file" name="trailer_file" accept="video/*" style="display: none;">
                            @if($episode->trailer_file_path)
                                <div class="current-file">
                                    <small class="text-muted">Current trailer: {{ basename($episode->trailer_file_path) }}</small>
                                </div>
                            @endif
                            @error('trailer_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error('trailer_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Publish Status -->
                        <div class="form-group mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_published" 
                                       name="is_published" value="1" {{ old('is_published', $episode->is_published) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_published">
                                    Published
                                </label>
                            </div>
                        </div>

                        <!-- Episode Info -->
                        <div class="episode-info">
                            <h6>Episode Information</h6>
                            <div class="info-item">
                                <span class="label">Series:</span>
                                <span class="value">{{ $series->title }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Language:</span>
                                <span class="value">{{ ucfirst($series->language) }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Created:</span>
                                <span class="value">{{ $episode->created_at->format('M j, Y') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Last Updated:</span>
                                <span class="value">{{ $episode->updated_at->format('M j, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Episode
                </button>
                <a href="{{ route('admin.fitdoc.series.episodes', $series) }}" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const videoTypeSelect = document.getElementById('video_type');
    const trailerTypeSelect = document.getElementById('trailer_type');
    const bannerInput = document.getElementById('banner_image');
    const bannerPreview = document.getElementById('banner-preview');
    const previewImage = document.getElementById('preview-image');
    
    // Handle video type change
    function handleVideoTypeChange() {
        const videoUrl = document.getElementById('video_url');
        const videoFile = document.getElementById('video_file');
        const selectedType = videoTypeSelect.value;
        
        videoUrl.style.display = 'none';
        videoFile.style.display = 'none';
        videoUrl.required = false;
        videoFile.required = false;
        
        if (selectedType === 'youtube' || selectedType === 's3') {
            videoUrl.style.display = 'block';
            videoUrl.required = true;
        } else if (selectedType === 'upload') {
            videoFile.style.display = 'block';
        }
    }
    
    // Handle trailer type change
    function handleTrailerTypeChange() {
        const trailerUrl = document.getElementById('trailer_url');
        const trailerFile = document.getElementById('trailer_file');
        const trailerInputGroup = document.getElementById('trailer-input-group');
        const selectedType = trailerTypeSelect.value;
        
        trailerInputGroup.style.display = 'none';
        trailerUrl.style.display = 'none';
        trailerFile.style.display = 'none';
        trailerUrl.required = false;
        trailerFile.required = false;
        
        if (selectedType === 'youtube' || selectedType === 's3') {
            trailerInputGroup.style.display = 'block';
            trailerUrl.style.display = 'block';
        } else if (selectedType === 'upload') {
            trailerInputGroup.style.display = 'block';
            trailerFile.style.display = 'block';
        }
    }
    
    // Handle banner preview
    function handleBannerPreview() {
        const file = bannerInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                bannerPreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            bannerPreview.style.display = 'none';
        }
    }
    
    // Event listeners
    videoTypeSelect.addEventListener('change', handleVideoTypeChange);
    trailerTypeSelect.addEventListener('change', handleTrailerTypeChange);
    bannerInput.addEventListener('change', handleBannerPreview);
    
    // Initialize on page load
    handleVideoTypeChange();
    handleTrailerTypeChange();
});
</script>
@endpush

@push('styles')
<style>
.banner-preview img {
    max-height: 200px;
    object-fit: cover;
}

.current-file {
    margin-top: 0.5rem;
    padding: 0.5rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
}

.episode-info {
    background: #1d1d1d;
    border: 1px solid var(--border-primary);
    border-radius: 8px;
    padding: 1rem;
    margin-top: 1rem;
}

.episode-info h6 {
    color: var(--text-primary);
    margin-bottom: 1rem;
    font-weight: 600;
}

.info-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
}

.info-item .label {
    color: var(--text-secondary);
    font-weight: 500;
}

.info-item .value {
    color: var(--text-primary);
    font-weight: 600;
    font-size: 0.9rem;
}

.card {
    background: #1d1d1d;
    border: 1px solid var(--border-primary);
}

.card-header {
    background: rgba(255, 255, 255, 0.05);
    border-bottom: 1px solid var(--border-primary);
}

.form-control {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid var(--border-primary);
    color: white;
}

.form-control:focus {
    background: rgba(255, 255, 255, 0.15);
    border-color: var(--primary-color);
    color: white;
    box-shadow: 0 0 0 0.2rem rgba(var(--primary-color-rgb), 0.25);
}

.form-control::placeholder {
    color: rgba(255, 255, 255, 0.6);
}

label {
    color: white;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.form-text {
    color: rgba(255, 255, 255, 0.6);
}

.alert-danger {
    background: rgba(220, 53, 69, 0.1);
    border: 1px solid rgba(220, 53, 69, 0.3);
    color: #ff6b6b;
}
</style>
@endpush
@endsection 