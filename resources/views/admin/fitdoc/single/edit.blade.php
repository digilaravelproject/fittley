@extends('layouts.admin')

@section('title', 'Edit Single Video')

@section('content')
<div class="container-fluid">
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-edit me-3"></i>Edit Single Video
                </h1>
                <p class="page-subtitle">Update your single video content</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('admin.fitdoc.single.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Single Videos
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('admin.fitdoc.single.update', $fitDoc) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="type" value="single">
            
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
                        <div class="form-group mb-3">
                            <label for="title">Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $fitDoc->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="language">Language *</label>
                                    <select class="form-control @error('language') is-invalid @enderror" 
                                            id="language" name="language" required>
                                        <option value="">Select Language</option>
                                        <option value="english" {{ old('language', $fitDoc->language) == 'english' ? 'selected' : '' }}>English</option>
                                        <option value="spanish" {{ old('language', $fitDoc->language) == 'spanish' ? 'selected' : '' }}>Spanish</option>
                                        <option value="french" {{ old('language', $fitDoc->language) == 'french' ? 'selected' : '' }}>French</option>
                                        <option value="hindi" {{ old('language', $fitDoc->language) == 'hindi' ? 'selected' : '' }}>Hindi</option>
                                    </select>
                                    @error('language')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="cost">Cost ($)</label>
                                    <input type="number" class="form-control @error('cost') is-invalid @enderror" 
                                           id="cost" name="cost" value="{{ old('cost', $fitDoc->cost) }}" min="0" step="0.01">
                                    @error('cost')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Description *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description', $fitDoc->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="release_date">Release Date *</label>
                                    <input type="date" class="form-control @error('release_date') is-invalid @enderror" 
                                           id="release_date" name="release_date" value="{{ old('release_date', $fitDoc->release_date ? $fitDoc->release_date->format('Y-m-d') : '') }}" required>
                                    @error('release_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="duration_minutes">Duration (minutes) *</label>
                                    <input type="number" class="form-control @error('duration_minutes') is-invalid @enderror" 
                                           id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes', $fitDoc->duration_minutes) }}" min="1" required>
                                    @error('duration_minutes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Main Video Section -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5>Main Video *</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="video_type">Video Source *</label>
                                            <select class="form-control @error('video_type') is-invalid @enderror" 
                                                    id="video_type" name="video_type" required>
                                                <option value="">Select Source</option>
                                                <option value="youtube" {{ old('video_type', $fitDoc->video_type) == 'youtube' ? 'selected' : '' }}>YouTube</option>
                                                <option value="s3" {{ old('video_type', $fitDoc->video_type) == 's3' ? 'selected' : '' }}>S3 URL</option>
                                                <option value="upload" {{ old('video_type', $fitDoc->video_type) == 'upload' ? 'selected' : '' }}>Upload File</option>
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
                                                   id="video_url" name="video_url" value="{{ old('video_url', $fitDoc->video_url) }}" 
                                                   placeholder="Enter video URL" style="display: none;">
                                            <input type="file" class="form-control @error('video_file') is-invalid @enderror" 
                                                   id="video_file" name="video_file" accept="video/*" style="display: none;">
                                            @if($fitDoc->video_file_path)
                                                <div class="current-file">
                                                    <small class="text-muted">Current file: {{ basename($fitDoc->video_file_path) }}</small>
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
                        @if($fitDoc->banner_image_path)
                            <div class="current-banner mb-3">
                                <label>Current Banner</label>
                                <div class="banner-preview">
                                    <img src="{{ asset('storage/app/public/' . $fitDoc->banner_image_path) }}" 
                                         alt="Current banner" class="img-fluid rounded">
                                </div>
                            </div>
                        @endif

                        <!-- Banner Image -->
                        <div class="form-group mb-3">
                            <label for="banner_image">Banner Image</label>
                            <input type="file" class="form-control @error('banner_image') is-invalid @enderror" 
                                   id="banner_image" name="banner_image" accept="image/*">
                            <small class="form-text text-muted">Max size: 2MB. Leave empty to keep current.</small>
                            @error('banner_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Trailer -->
                        <div class="form-group mb-3">
                            <label for="trailer_type">Trailer (Optional)</label>
                            <select class="form-control @error('trailer_type') is-invalid @enderror" 
                                    id="trailer_type" name="trailer_type">
                                <option value="">No Trailer</option>
                                <option value="youtube" {{ old('trailer_type', $fitDoc->trailer_type) == 'youtube' ? 'selected' : '' }}>YouTube</option>
                                <option value="s3" {{ old('trailer_type', $fitDoc->trailer_type) == 's3' ? 'selected' : '' }}>S3 URL</option>
                                <option value="upload" {{ old('trailer_type', $fitDoc->trailer_type) == 'upload' ? 'selected' : '' }}>Upload File</option>
                            </select>
                            @error('trailer_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3" id="trailer-input-group" style="display: none;">
                            <input type="url" class="form-control @error('trailer_url') is-invalid @enderror" 
                                   id="trailer_url" name="trailer_url" value="{{ old('trailer_url', $fitDoc->trailer_url) }}" 
                                   placeholder="Enter trailer URL" style="display: none;">
                            <input type="file" class="form-control @error('trailer_file') is-invalid @enderror" 
                                   id="trailer_file" name="trailer_file" accept="video/*" style="display: none;">
                            @if($fitDoc->trailer_file_path)
                                <div class="current-file">
                                    <small class="text-muted">Current trailer: {{ basename($fitDoc->trailer_file_path) }}</small>
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
                                       name="is_published" value="1" {{ old('is_published', $fitDoc->is_published) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_published">
                                    Published
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Single Video
                </button>
                <a href="{{ route('admin.fitdoc.single.index') }}" class="btn btn-secondary">
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
    
    // Event listeners
    videoTypeSelect.addEventListener('change', handleVideoTypeChange);
    trailerTypeSelect.addEventListener('change', handleTrailerTypeChange);
    
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
</style>
@endpush
@endsection 