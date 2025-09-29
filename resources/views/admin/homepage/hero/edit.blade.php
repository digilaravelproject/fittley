@extends('layouts.admin')

@section('title', 'Edit Homepage Hero')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">Edit Homepage Hero</h1>
                <p class="page-subtitle">Update hero content: {{ $homepageHero->title }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.homepage.hero.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Heroes
                </a>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.homepage.hero.update', $homepageHero) }}" id="heroForm">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Form Section -->
            <div class="col-lg-8">
                <div class="content-card">
                    <div class="content-card-header">
                        <h5 class="mb-0">Hero Content Details</h5>
                    </div>
                    <div class="content-card-body">
                        <!-- Title -->
                        <div class="mb-4">
                            <label for="title" class="form-label required">Title</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title', $homepageHero->title) }}" placeholder="Enter hero title" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label required">Description</label>
                            <textarea name="description" id="description" rows="4" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      placeholder="Enter hero description" required>{{ old('description', $homepageHero->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- YouTube URL -->
                        <div class="mb-4">
                            <label for="youtube_video_url" class="form-label">YouTube Video URL</label>
                            <input type="url" name="youtube_video_url" id="youtube_video_url" 
                                   class="form-control @error('youtube_video_url') is-invalid @enderror" 
                                   value="{{ old('youtube_video_url', $homepageHero->youtube_video_id ? 'https://www.youtube.com/watch?v=' . $homepageHero->youtube_video_id : '') }}" 
                                   placeholder="https://www.youtube.com/watch?v=...">
                            @error('youtube_video_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Enter the full YouTube URL. Video will be embedded without controls. Leave empty to use background image instead.</div>
                        </div>

                        <!-- Category & Meta Info -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="category" class="form-label">Category</label>
                                    <input type="text" name="category" id="category" 
                                           class="form-control @error('category') is-invalid @enderror" 
                                           value="{{ old('category', $homepageHero->category) }}" placeholder="e.g., ABS, CARDIO">
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="duration" class="form-label">Duration</label>
                                    <input type="text" name="duration" id="duration" 
                                           class="form-control @error('duration') is-invalid @enderror" 
                                           value="{{ old('duration', $homepageHero->duration) }}" placeholder="e.g., 20 min">
                                    @error('duration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="year" class="form-label">Year</label>
                                    <input type="number" name="year" id="year" 
                                           class="form-control @error('year') is-invalid @enderror" 
                                           value="{{ old('year', $homepageHero->year) }}" min="1900" max="{{ date('Y') + 5 }}">
                                    @error('year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Button Configuration -->
                <div class="content-card mt-4">
                    <div class="content-card-header">
                        <h5 class="mb-0">Button Configuration</h5>
                    </div>
                    <div class="content-card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="play_button_text" class="form-label required">Play Button Text</label>
                                    <input type="text" name="play_button_text" id="play_button_text" 
                                           class="form-control @error('play_button_text') is-invalid @enderror" 
                                           value="{{ old('play_button_text', $homepageHero->play_button_text) }}" required>
                                    @error('play_button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="play_button_link" class="form-label">Play Button Link</label>
                                    <input type="url" name="play_button_link" id="play_button_link" 
                                           class="form-control @error('play_button_link') is-invalid @enderror" 
                                           value="{{ old('play_button_link', $homepageHero->play_button_link) }}" 
                                           placeholder="https://example.com/play">
                                    @error('play_button_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="trailer_button_text" class="form-label required">Trailer Button Text</label>
                                    <input type="text" name="trailer_button_text" id="trailer_button_text" 
                                           class="form-control @error('trailer_button_text') is-invalid @enderror" 
                                           value="{{ old('trailer_button_text', $homepageHero->trailer_button_text) }}" required>
                                    @error('trailer_button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="trailer_button_link" class="form-label">Trailer Button Link</label>
                                    <input type="url" name="trailer_button_link" id="trailer_button_link" 
                                           class="form-control @error('trailer_button_link') is-invalid @enderror" 
                                           value="{{ old('trailer_button_link', $homepageHero->trailer_button_link) }}" 
                                           placeholder="https://example.com/trailer">
                                    @error('trailer_button_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preview & Settings Section -->
            <div class="col-lg-4">
                <!-- Video Preview -->
                <div class="content-card mb-4">
                    <div class="content-card-header">
                        <h5 class="mb-0">Video Preview</h5>
                    </div>
                    <div class="content-card-body">
                        <div id="video-preview" class="video-preview-container">
                            @if($homepageHero->youtube_video_id)
                                <div class="position-relative w-100 h-100">
                                    <img src="{{ $homepageHero->youtube_thumbnail_url }}" alt="Video Thumbnail" class="w-100 h-100" style="object-fit: cover;">
                                    <div class="position-absolute top-50 start-50 translate-middle">
                                        <i class="fas fa-play-circle fa-3x text-white" style="opacity: 0.8;"></i>
                                    </div>
                                </div>
                            @else
                                <div class="preview-placeholder">
                                    <i class="fas fa-video fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No video selected</p>
                                    <small class="text-muted">Enter a YouTube URL to preview</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Settings -->
                <div class="content-card">
                    <div class="content-card-header">
                        <h5 class="mb-0">Settings</h5>
                    </div>
                    <div class="content-card-body">
                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" 
                                   class="form-control @error('sort_order') is-invalid @enderror" 
                                   value="{{ old('sort_order', $homepageHero->sort_order) }}" min="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Lower numbers appear first</div>
                        </div>

                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" 
                                   {{ old('is_active', $homepageHero->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                            <div class="form-text">Only active heroes will be displayed on homepage</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Hero
                            </button>
                            <a href="{{ route('admin.homepage.hero.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
.video-preview-container {
    position: relative;
    width: 100%;
    height: 200px;
    background: #f8f9fa;
    border-radius: 8px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.preview-placeholder {
    text-align: center;
}

.video-preview {
    width: 100%;
    height: 100%;
    border: none;
}

.required::after {
    content: ' *';
    color: #dc3545;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const youtubeUrlInput = document.getElementById('youtube_video_url');
    const videoPreview = document.getElementById('video-preview');
    
    // YouTube URL change handler
    youtubeUrlInput.addEventListener('input', function() {
        const url = this.value.trim();
        updateVideoPreview(url);
    });
    
    function updateVideoPreview(url) {
        if (!url) {
            showPreviewPlaceholder();
            return;
        }
        
        const videoId = extractYouTubeID(url);
        if (videoId) {
            showVideoPreview(videoId);
        } else {
            showPreviewPlaceholder();
        }
    }
    
    function extractYouTubeID(url) {
        const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
        const match = url.match(regExp);
        return (match && match[2].length === 11) ? match[2] : null;
    }
    
    function showVideoPreview(videoId) {
        const thumbnailUrl = `https://img.youtube.com/vi/${videoId}/maxresdefault.jpg`;
        videoPreview.innerHTML = `
            <div class="position-relative w-100 h-100">
                <img src="${thumbnailUrl}" alt="Video Thumbnail" class="w-100 h-100" style="object-fit: cover;">
                <div class="position-absolute top-50 start-50 translate-middle">
                    <i class="fas fa-play-circle fa-3x text-white" style="opacity: 0.8;"></i>
                </div>
            </div>
        `;
    }
    
    function showPreviewPlaceholder() {
        videoPreview.innerHTML = `
            <div class="preview-placeholder">
                <i class="fas fa-video fa-3x text-muted mb-3"></i>
                <p class="text-muted">Enter YouTube URL to see preview</p>
            </div>
        `;
    }
    
    // Form validation
    document.getElementById('heroForm').addEventListener('submit', function(e) {
        const youtubeUrl = youtubeUrlInput.value.trim();
        if (youtubeUrl && !extractYouTubeID(youtubeUrl)) {
            e.preventDefault();
            alert('Please enter a valid YouTube URL');
            youtubeUrlInput.focus();
            return false;
        }
    });
});
</script>
@endpush
@endsection 