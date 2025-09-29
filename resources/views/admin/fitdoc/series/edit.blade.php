@extends('layouts.admin')

@section('title', 'Edit Series')

@section('content')
<div class="container-fluid">
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-edit me-3"></i>Edit Series
                </h1>
                <p class="page-subtitle">Update your series content</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('admin.fitdoc.series.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Series
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('admin.fitdoc.series.update', $fitDoc) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="type" value="series">
            
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
                            <label for="title">Series Title *</label>
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
                            <label for="description">Series Description *</label>
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
                                    <label for="total_episodes">Total Episodes</label>
                                    <input type="number" class="form-control @error('total_episodes') is-invalid @enderror" 
                                           id="total_episodes" name="total_episodes" value="{{ old('total_episodes', $fitDoc->total_episodes) }}" min="1">
                                    @error('total_episodes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                            <label for="trailer_type">Series Trailer (Optional)</label>
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
                    <i class="fas fa-save me-2"></i>Update Series
                </button>
                <a href="{{ route('admin.fitdoc.series.episodes', $fitDoc) }}" class="btn btn-info">
                    <i class="fas fa-list me-2"></i>Manage Episodes
                </a>
                <a href="{{ route('admin.fitdoc.series.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Episodes Summary -->
    @if($fitDoc->episodes->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h5><i class="fas fa-list me-2"></i>Episodes ({{ $fitDoc->episodes->count() }})</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($fitDoc->episodes->take(6) as $episode)
                        <div class="col-md-4 mb-3">
                            <div class="episode-card">
                                <div class="episode-number">Ep {{ $episode->episode_number }}</div>
                                <div class="episode-title">{{ $episode->title }}</div>
                                <div class="episode-duration">{{ $episode->formatted_duration }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($fitDoc->episodes->count() > 6)
                    <div class="text-center">
                        <a href="{{ route('admin.fitdoc.series.episodes', $fitDoc) }}" class="btn btn-outline-primary">
                            View All Episodes ({{ $fitDoc->episodes->count() }})
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const trailerTypeSelect = document.getElementById('trailer_type');
    
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
    trailerTypeSelect.addEventListener('change', handleTrailerTypeChange);
    
    // Initialize on page load
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

.episode-card {
    background: var(--card-bg);
    border: 1px solid var(--border-primary);
    border-radius: 8px;
    padding: 1rem;
    text-align: center;
}

.episode-number {
    font-size: 0.875rem;
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.episode-title {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
    line-height: 1.3;
}

.episode-duration {
    font-size: 0.8rem;
    color: var(--text-secondary);
}
</style>
@endpush
@endsection 