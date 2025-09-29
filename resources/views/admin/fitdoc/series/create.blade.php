@extends('layouts.admin')
@section('title', 'Create Series')

@section('content')
<div class="fitdoc-series-create">
    <!-- Header Section -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-plus-circle me-3"></i>
                    Create New Series
                </h1>
                <p class="page-subtitle">Add a new series to your FitDoc library</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('admin.fitdoc.series.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Series
                </a>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.fitdoc.series.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="type" value="series">

        <!-- Validation Errors & Success Messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h4 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Validation Error</h4>
                <p>Please fix the following errors before proceeding:</p>
                <hr>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-times-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <!-- Basic Information -->
        <div class="content-card mb-4">
            <div class="content-card-header">
                <h3 class="content-card-title">
                    <i class="fas fa-info-circle me-2"></i>
                    Basic Information
                </h3>
                <p class="content-card-subtitle">Enter the basic details for your series</p>
            </div>
            <div class="content-card-body">
                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="title" class="form-label">Title *</label>
                            <input type="text" 
                                   class="form-control dark-input @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}" 
                                   placeholder="Enter series title" 
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="language" class="form-label">Language *</label>
                            <select class="form-select dark-input @error('language') is-invalid @enderror" 
                                    id="language" 
                                    name="language" 
                                    required>
                                <option value="">Select Language</option>
                                <option value="english" {{ old('language') == 'english' ? 'selected' : '' }}>English</option>
                                <option value="spanish" {{ old('language') == 'spanish' ? 'selected' : '' }}>Spanish</option>
                                <option value="french" {{ old('language') == 'french' ? 'selected' : '' }}>French</option>
                                <option value="german" {{ old('language') == 'german' ? 'selected' : '' }}>German</option>
                                <option value="italian" {{ old('language') == 'italian' ? 'selected' : '' }}>Italian</option>
                            </select>
                            @error('language')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control dark-input @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4" 
                                      placeholder="Enter series description" 
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cost" class="form-label">Cost ($)</label>
                            <input type="number" 
                                   class="form-control dark-input @error('cost') is-invalid @enderror" 
                                   id="cost" 
                                   name="cost" 
                                   value="{{ old('cost', 0) }}" 
                                   step="0.01" 
                                   min="0" 
                                   placeholder="0">
                            @error('cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="release_date" class="form-label">Release Date *</label>
                            <input type="date" 
                                   class="form-control dark-input @error('release_date') is-invalid @enderror" 
                                   id="release_date" 
                                   name="release_date" 
                                   value="{{ old('release_date', now()->format('Y-m-d')) }}" 
                                   required>
                            @error('release_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="total_episodes" class="form-label">Expected Total Episodes</label>
                            <input type="number" 
                                   class="form-control dark-input @error('total_episodes') is-invalid @enderror" 
                                   id="total_episodes" 
                                   name="total_episodes" 
                                   value="{{ old('total_episodes') }}" 
                                   min="1" 
                                   placeholder="Enter expected number of episodes">
                            <div class="form-text">Leave empty if unknown</div>
                            @error('total_episodes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Media Files -->
        <div class="content-card mb-4">
            <div class="content-card-header">
                <h3 class="content-card-title">
                    <i class="fas fa-image me-2"></i>
                    Media Files
                </h3>
                <p class="content-card-subtitle">Upload banner image and trailer (optional)</p>
            </div>
            <div class="content-card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="banner_image" class="form-label">Banner Image</label>
                            <input type="file" 
                                   class="form-control dark-input @error('banner_image') is-invalid @enderror" 
                                   id="banner_image" 
                                   name="banner_image" 
                                   accept="image/*">
                            <div class="form-text">Max size: 2MB. Supported formats: JPEG, PNG, GIF</div>
                            @error('banner_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="trailer_type" class="form-label">Trailer (Optional)</label>
                            <select class="form-select dark-input @error('trailer_type') is-invalid @enderror" 
                                    id="trailer_type" 
                                    name="trailer_type">
                                <option value="">No Trailer</option>
                                <option value="youtube" {{ old('trailer_type') == 'youtube' ? 'selected' : '' }}>YouTube URL</option>
                                <option value="s3" {{ old('trailer_type') == 's3' ? 'selected' : '' }}>S3 URL</option>
                                <option value="upload" {{ old('trailer_type') == 'upload' ? 'selected' : '' }}>Upload File</option>
                            </select>
                            @error('trailer_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Trailer URL Input -->
                        <div class="form-group mt-3" id="trailer_url_group" style="display: none;">
                            <input type="url" 
                                   class="form-control dark-input @error('trailer_url') is-invalid @enderror" 
                                   id="trailer_url" 
                                   name="trailer_url" 
                                   value="{{ old('trailer_url') }}" 
                                   placeholder="Enter trailer URL">
                            @error('trailer_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Trailer File Upload -->
                        <div class="form-group mt-3" id="trailer_file_group" style="display: none;">
                            <input type="file" 
                                   class="form-control dark-input @error('trailer_file') is-invalid @enderror" 
                                   id="trailer_file" 
                                   name="trailer_file" 
                                   accept="video/*">
                            <div class="form-text">Max size: 100MB. Supported formats: MP4, AVI, MOV, WMV, FLV, WEBM</div>
                            @error('trailer_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Publishing Options -->
        <div class="content-card mb-4">
            <div class="content-card-header">
                <h3 class="content-card-title">
                    <i class="fas fa-cog me-2"></i>
                    Publishing Options
                </h3>
                <p class="content-card-subtitle">Set publishing preferences</p>
            </div>
            <div class="content-card-body">
                <div class="form-check form-switch">
                    <input class="form-check-input" 
                           type="checkbox" 
                           id="is_published" 
                           name="is_published" 
                           value="1" 
                           {{ old('is_published') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">
                        Publish immediately
                    </label>
                    <div class="form-text">If unchecked, the series will be saved as a draft</div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="content-card">
            <div class="content-card-body">
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Create Series
                    </button>
                    <a href="{{ route('admin.fitdoc.series.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
.fitdoc-series-create {
    animation: fadeInUp 0.6s ease-out;
}

.page-header {
    margin-bottom: 2rem;
}

.page-title {
    font-size: 2.25rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    letter-spacing: -0.02em;
}

.page-subtitle {
    font-size: 1rem;
    color: var(--text-muted);
    font-weight: 400;
}

/* Dark Input Styles */
.dark-input {
    background-color: var(--bg-tertiary);
    border: 1px solid var(--border-primary);
    color: var(--text-primary);
    border-radius: 8px;
    padding: 0.75rem 1rem;
    transition: var(--transition-fast);
}

.dark-input:focus {
    background-color: var(--bg-secondary);
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(247, 163, 26, 0.25);
    color: var(--text-primary);
}

.dark-input::placeholder {
    color: var(--text-muted);
}

.dark-input.is-invalid {
    border-color: var(--error);
}

.dark-input.is-invalid:focus {
    border-color: var(--error);
    box-shadow: 0 0 0 0.2rem rgba(229, 9, 20, 0.25);
}

.form-label {
    color: var(--text-secondary);
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.form-text {
    color: var(--text-muted);
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.invalid-feedback {
    color: var(--error);
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

/* Form Check Styles */
.form-check-input {
    background-color: var(--bg-tertiary);
    border: 1px solid var(--border-primary);
}

.form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.form-check-input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(247, 163, 26, 0.25);
}

.form-check-label {
    color: var(--text-primary);
    font-weight: 500;
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-title {
        font-size: 1.75rem;
    }
    
    .d-flex.gap-3 {
        flex-direction: column;
    }
    
    .d-flex.gap-3 .btn {
        width: 100%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle trailer type change
    const trailerTypeSelect = document.getElementById('trailer_type');
    const trailerUrlGroup = document.getElementById('trailer_url_group');
    const trailerFileGroup = document.getElementById('trailer_file_group');
    
    trailerTypeSelect.addEventListener('change', function() {
        const trailerType = this.value;
        
        // Hide all groups
        trailerUrlGroup.style.display = 'none';
        trailerFileGroup.style.display = 'none';
        
        // Show relevant group
        if (trailerType === 'youtube' || trailerType === 's3') {
            trailerUrlGroup.style.display = 'block';
        } else if (trailerType === 'upload') {
            trailerFileGroup.style.display = 'block';
        }
    });
    
    // Trigger change event on page load to show correct fields
    trailerTypeSelect.dispatchEvent(new Event('change'));
});
</script>
@endsection 