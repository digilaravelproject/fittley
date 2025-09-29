@extends('layouts.admin')

@section('title', 'Create Single Video')

@section('content')
<div class="single-create">
    <!-- Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-video me-3"></i>Create Single Video
                </h1>
                <p class="page-subtitle">Create a new educational video</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="btn-group" role="group">
                    <a href="{{ route('admin.fitguide.single.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Singles
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('admin.fitguide.single.store') }}" enctype="multipart/form-data" id="singleForm">
        @csrf
        
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="content-card mb-4">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-info-circle me-2"></i>Basic Information
                        </h3>
                    </div>
                    <div class="content-card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="fg_category_id" class="form-label required">Category</label>
                                <select class="form-select @error('fg_category_id') is-invalid @enderror" 
                                        id="fg_category_id" 
                                        name="fg_category_id" 
                                        required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('fg_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('fg_category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="fg_sub_category_id" class="form-label">Subcategory</label>
                                <select class="form-select @error('fg_sub_category_id') is-invalid @enderror" 
                                        id="fg_sub_category_id" 
                                        name="fg_sub_category_id">
                                    <option value="">Select Subcategory</option>
                                </select>
                                @error('fg_sub_category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <label for="title" class="form-label required">Title</label>
                                <input type="text" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title') }}" 
                                       placeholder="Enter video title"
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="slug" class="form-label">Slug</label>
                                <input type="text" 
                                       class="form-control @error('slug') is-invalid @enderror" 
                                       id="slug" 
                                       name="slug" 
                                       value="{{ old('slug') }}" 
                                       placeholder="video-slug">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Leave empty to auto-generate from title</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label required">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="5" 
                                      placeholder="Enter video description"
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                                <option value="youtube" {{ old('video_type') == 'youtube' ? 'selected' : '' }}>YouTube</option>
                                <option value="s3" {{ old('video_type') == 's3' ? 'selected' : '' }}>S3 URL</option>
                                <option value="upload" {{ old('video_type') == 'upload' ? 'selected' : '' }}>Upload</option>
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
                                   value="{{ old('video_url') }}" 
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

                <!-- Media Assets -->
                <div class="content-card mb-4">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-image me-2"></i>Media Assets
                        </h3>
                    </div>
                    <div class="content-card-body">
                        <!-- Banner Image -->
                        <div class="mb-4">
                            <label for="banner_image_path" class="form-label">Video Banner</label>
                            <input type="file" 
                                   class="form-control @error('banner_image_path') is-invalid @enderror" 
                                   id="banner_image_path" 
                                   name="banner_image_path" 
                                   accept="image/*">
                            @error('banner_image_path')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Recommended size: 1920x1080px. Max size: 2MB</div>
                        </div>

                        <!-- Trailer Section -->
                        <div class="trailer-section">
                            <h5>Video Trailer (Optional)</h5>
                            <div class="mb-3">
                                <label for="trailer_type" class="form-label">Trailer Type</label>
                                <select class="form-select @error('trailer_type') is-invalid @enderror" 
                                        id="trailer_type" 
                                        name="trailer_type">
                                    <option value="">No Trailer</option>
                                    <option value="youtube" {{ old('trailer_type') == 'youtube' ? 'selected' : '' }}>YouTube</option>
                                    <option value="s3" {{ old('trailer_type') == 's3' ? 'selected' : '' }}>S3 URL</option>
                                    <option value="upload" {{ old('trailer_type') == 'upload' ? 'selected' : '' }}>Upload</option>
                                </select>
                                @error('trailer_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="trailer_url_section" class="mb-3" style="display: none;">
                                <label for="trailer_url" class="form-label">Trailer URL</label>
                                <input type="url" 
                                       class="form-control @error('trailer_url') is-invalid @enderror" 
                                       id="trailer_url" 
                                       name="trailer_url" 
                                       value="{{ old('trailer_url') }}" 
                                       placeholder="Enter trailer URL">
                                @error('trailer_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="trailer_upload_section" class="mb-3" style="display: none;">
                                <label for="trailer_file_path" class="form-label">Upload Trailer File</label>
                                <input type="file" 
                                       class="form-control @error('trailer_file_path') is-invalid @enderror" 
                                       id="trailer_file_path" 
                                       name="trailer_file_path" 
                                       accept="video/*">
                                @error('trailer_file_path')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Max size: 100MB</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Settings -->
                <div class="content-card mb-4">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-cog me-2"></i>Settings
                        </h3>
                    </div>
                    <div class="content-card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="language" class="form-label required">Language</label>
                                <select class="form-select @error('language') is-invalid @enderror" 
                                        id="language" 
                                        name="language"
                                        required>
                                    <option value="english" {{ old('language', 'english') == 'english' ? 'selected' : '' }}>English</option>
                                    <option value="spanish" {{ old('language') == 'spanish' ? 'selected' : '' }}>Spanish</option>
                                    <option value="french" {{ old('language') == 'french' ? 'selected' : '' }}>French</option>
                                    <option value="german" {{ old('language') == 'german' ? 'selected' : '' }}>German</option>
                                    <option value="other" {{ old('language') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('language')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="cost" class="form-label">Cost ($)</label>
                                <input type="number" 
                                       class="form-control @error('cost') is-invalid @enderror" 
                                       id="cost" 
                                       name="cost" 
                                       value="{{ old('cost', 0) }}" 
                                       min="0" 
                                       step="0.01">
                                @error('cost')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="release_date" class="form-label required">Release Date</label>
                            <input type="date" 
                                   class="form-control @error('release_date') is-invalid @enderror" 
                                   id="release_date" 
                                   name="release_date" 
                                   value="{{ old('release_date') }}"
                                   required>
                            @error('release_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="duration_minutes" class="form-label">Duration (minutes)</label>
                            <input type="number" 
                                   class="form-control @error('duration_minutes') is-invalid @enderror" 
                                   id="duration_minutes" 
                                   name="duration_minutes" 
                                   value="{{ old('duration_minutes') }}" 
                                   min="1"
                                   placeholder="e.g., 30">
                            @error('duration_minutes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="feedback" class="form-label">Rating</label>
                            <input type="number" 
                                   class="form-control @error('feedback') is-invalid @enderror" 
                                   id="feedback" 
                                   name="feedback" 
                                   value="{{ old('feedback') }}" 
                                   min="0" 
                                   max="5" 
                                   step="0.1"
                                   placeholder="0.0">
                            @error('feedback')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Rate this video from 0 to 5 (optional)</div>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_published" 
                                   name="is_published" 
                                   value="1"
                                   {{ old('is_published') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_published">
                                Published
                            </label>
                        </div>
                        <div class="form-text">Publish this video immediately</div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="content-card">
                    <div class="content-card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Single Video
                            </button>
                            <a href="{{ route('admin.fitguide.single.index') }}" class="btn btn-outline-secondary">
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
    const categorySelect = document.getElementById('fg_category_id');
    const subcategorySelect = document.getElementById('fg_sub_category_id');
    const videoTypeSelect = document.getElementById('video_type');
    const trailerTypeSelect = document.getElementById('trailer_type');
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');

    // Auto-generate slug from title
    titleInput.addEventListener('input', function() {
        if (!slugInput.value || slugInput.dataset.autoGenerated) {
            const slug = this.value.toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
            slugInput.value = slug;
            slugInput.dataset.autoGenerated = 'true';
        }
    });

    slugInput.addEventListener('input', function() {
        delete this.dataset.autoGenerated;
    });

    // Load subcategories when category changes
    categorySelect.addEventListener('change', function() {
        const categoryId = this.value;
        subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
        
        if (categoryId) {
            fetch(`/admin/fitguide/categories/${categoryId}/subcategories`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(subcategory => {
                        const option = document.createElement('option');
                        option.value = subcategory.id;
                        option.textContent = subcategory.name;
                        subcategorySelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error loading subcategories:', error);
                });
        }
    });

    // Show/hide video sections based on type
    function toggleVideoSections() {
        const videoUrlSection = document.getElementById('video_url_section');
        const videoUploadSection = document.getElementById('video_upload_section');
        const videoUrlInput = document.getElementById('video_url');
        const videoFileInput = document.getElementById('video_file_path');
        const videoUrlHelp = document.getElementById('video_url_help');
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

    // Show/hide trailer sections based on type
    function toggleTrailerSections() {
        const trailerUrlSection = document.getElementById('trailer_url_section');
        const trailerUploadSection = document.getElementById('trailer_upload_section');
        const selectedType = trailerTypeSelect.value;
        
        // Hide all sections first
        trailerUrlSection.style.display = 'none';
        trailerUploadSection.style.display = 'none';
        
        // Show relevant section
        if (selectedType === 'youtube' || selectedType === 's3') {
            trailerUrlSection.style.display = 'block';
        } else if (selectedType === 'upload') {
            trailerUploadSection.style.display = 'block';
        }
    }

    // Initialize sections
    toggleVideoSections();
    toggleTrailerSections();
    
    // Handle video type changes
    videoTypeSelect.addEventListener('change', toggleVideoSections);
    trailerTypeSelect.addEventListener('change', toggleTrailerSections);

    // Form validation
    document.getElementById('singleForm').addEventListener('submit', function(e) {
        const videoType = videoTypeSelect.value;
        
        if (!videoType) {
            e.preventDefault();
            alert('Please select a video type.');
            return false;
        }
        
        if ((videoType === 'youtube' || videoType === 's3') && !document.getElementById('video_url').value.trim()) {
            e.preventDefault();
            alert('Please enter a video URL.');
            return false;
        }
        
        if (videoType === 'upload' && !document.getElementById('video_file_path').files.length) {
            e.preventDefault();
            alert('Please select a video file to upload.');
            return false;
        }
    });
});
</script>
@endsection 