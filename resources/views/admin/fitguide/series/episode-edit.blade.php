@extends('layouts.admin')

@section('content')
<div class="episode-create">
    <!-- Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-edit me-3"></i>Edit Episode
                </h1>
                <p class="page-subtitle">Series: {{ $fgSeries->title }} - Episode #{{ $episode->episode_number }}</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="btn-group" role="group">
                    <a href="{{ route('admin.fitguide.series.episodes', $fgSeries) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Episodes
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('admin.fitguide.series.episodes.update', [$fgSeries, $episode]) }}" enctype="multipart/form-data" id="episodeForm">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Episode Information -->
                <div class="content-card mb-4">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-info-circle me-2"></i>Episode Information
                        </h3>
                    </div>
                    <div class="content-card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <label for="title" class="form-label required">Episode Title</label>
                                <input type="text" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title', $episode->title) }}" 
                                       placeholder="Enter episode title"
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="episode_number" class="form-label required">Episode Number</label>
                                <input type="number" 
                                       class="form-control @error('episode_number') is-invalid @enderror" 
                                       id="episode_number" 
                                       name="episode_number" 
                                       value="{{ old('episode_number', $episode->episode_number) }}" 
                                       min="1"
                                       required>
                                @error('episode_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4" 
                                      placeholder="Enter episode description">{{ old('description', $episode->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="duration_minutes" class="form-label">Duration (minutes)</label>
                                <input type="number" 
                                       class="form-control @error('duration_minutes') is-invalid @enderror" 
                                       id="duration_minutes" 
                                       name="duration_minutes" 
                                       value="{{ old('duration_minutes', $episode->duration_minutes) }}" 
                                       min="1"
                                       placeholder="e.g., 30">
                                @error('duration_minutes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Video Content -->
                <div class="content-card mb-4">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-video me-2"></i>Video Content
                        </h3>
                    </div>
                    <div class="content-card-body">
                        <div class="mb-3">
                            <label for="video_type" class="form-label required">Video Type</label>
                            <select class="form-select @error('video_type') is-invalid @enderror" 
                                    id="video_type" 
                                    name="video_type" 
                                    required>
                                <option value="">Select Video Type</option>
                                <option value="youtube" {{ old('video_type', $episode->video_type) == 'youtube' ? 'selected' : '' }}>YouTube</option>
                                <option value="s3" {{ old('video_type', $episode->video_type) == 's3' ? 'selected' : '' }}>S3 URL</option>
                                <option value="upload" {{ old('video_type', $episode->video_type) == 'upload' ? 'selected' : '' }}>Upload</option>
                            </select>
                            @error('video_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="video_url_section" class="mb-3" style="display: none;">
                            <label for="video_url" class="form-label required">Video URL</label>
                            <input type="url" 
                                   class="form-control @error('video_url') is-invalid @enderror" 
                                   id="video_url" 
                                   name="video_url" 
                                   value="{{ old('video_url', $episode->video_url) }}" 
                                   placeholder="Enter video URL">
                            @error('video_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text" id="video_url_help">
                                For YouTube: Use full YouTube URL (e.g., https://www.youtube.com/watch?v=VIDEO_ID)
                            </div>
                        </div>

                        <div id="video_upload_section" class="mb-3" style="display: none;">
                            <label for="video_file_path" class="form-label required">Upload Video File</label>
                            <input type="file" 
                                   class="form-control @error('video_file_path') is-invalid @enderror" 
                                   id="video_file_path" 
                                   name="video_file_path" 
                                   accept="video/*">
                            @error('video_file_path')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Accepted formats: MP4, MOV, AVI, WMV, FLV, WebM. Max size: 500MB
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Episode Settings -->
                <div class="content-card mb-4">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-cog me-2"></i>Settings
                        </h3>
                    </div>
                    <div class="content-card-body">
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_published" 
                                   name="is_published" 
                                   value="1"
                                   {{ old('is_published', $episode->is_published) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_published">
                                Published
                            </label>
                        </div>
                        <div class="form-text">Publish this episode immediately</div>
                    </div>
                </div>

                <!-- Series Info -->
                <div class="content-card mb-4">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-tv me-2"></i>Series Info
                        </h3>
                    </div>
                    <div class="content-card-body">
                        <div class="mb-3">
                            <h6>Series Title</h6>
                            <p class="text-muted">{{ $fgSeries->title }}</p>
                        </div>
                        <div class="mb-3">
                            <h6>Category</h6>
                            <p class="text-muted">{{ $fgSeries->category->name }}</p>
                        </div>
                        @if($fgSeries->subCategory)
                        <div class="mb-3">
                            <h6>Subcategory</h6>
                            <p class="text-muted">{{ $fgSeries->subCategory->name }}</p>
                        </div>
                        @endif
                        <div class="mb-3">
                            <h6>Current Episodes</h6>
                            <p class="text-muted">{{ $fgSeries->episodes->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="content-card">
                    <div class="content-card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Episode
                            </button>
                            <a href="{{ route('admin.fitguide.series.episodes', $fgSeries) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const videoTypeSelect = document.getElementById('video_type');
    const videoUrlSection = document.getElementById('video_url_section');
    const videoUploadSection = document.getElementById('video_upload_section');
    const videoUrlInput = document.getElementById('video_url');
    const videoFileInput = document.getElementById('video_file_path');
    const videoUrlHelp = document.getElementById('video_url_help');

    function toggleVideoSections() {
        const selectedType = videoTypeSelect.value;
        
        // Hide all sections first
        videoUrlSection.style.display = 'none';
        videoUploadSection.style.display = 'none';
        
        // Remove required attributes
        videoUrlInput.removeAttribute('required');
        videoFileInput.removeAttribute('required');
        
        // Show relevant section and set required
        if (selectedType === 'youtube' || selectedType === 's3') {
            videoUrlSection.style.display = 'block';
            videoUrlInput.setAttribute('required', 'required');
            
            if (selectedType === 'youtube') {
                videoUrlHelp.textContent = 'For YouTube: Use full YouTube URL (e.g., https://www.youtube.com/watch?v=VIDEO_ID)';
            } else {
                videoUrlHelp.textContent = 'Enter the direct S3 URL to your video file';
            }
        } else if (selectedType === 'upload') {
            videoUploadSection.style.display = 'block';
            videoFileInput.setAttribute('required', 'required');
        }
    }

    // Initialize on page load
    toggleVideoSections();
    
    // Handle video type changes
    videoTypeSelect.addEventListener('change', toggleVideoSections);

    // Form validation
    document.getElementById('episodeForm').addEventListener('submit', function(e) {
        const videoType = videoTypeSelect.value;
        
        if (!videoType) {
            e.preventDefault();
            alert('Please select a video type.');
            return false;
        }
        
        if ((videoType === 'youtube' || videoType === 's3') && !videoUrlInput.value.trim()) {
            e.preventDefault();
            alert('Please enter a video URL.');
            return false;
        }
        
        if (videoType === 'upload' && !videoFileInput.files.length) {
            e.preventDefault();
            alert('Please select a video file to upload.');
            return false;
        }
    });
});
</script>
@endsection
