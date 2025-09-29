@extends('layouts.admin')

@section('title', 'Edit FitFlix Short')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">Edit FitFlix Short</h1>
                <p class="page-subtitle">Update your vertical short video</p>
            </div>
            <div>
                <a href="{{ route('admin.community.fitflix-shorts.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Shorts
                </a>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="content-card">
                <div class="content-card-header">
                    <h5 class="mb-0">Short Details</h5>
                </div>
                <div class="content-card-body">
                    <form method="POST" 
                      action="{{ route('admin.community.fitflix-shorts.update', $fitflix_short->slug) }}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" 
                                           value="{{ old('title', $fitflix_short->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                    <select class="form-select @error('category_id') is-invalid @enderror" 
                                            id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ old('category_id', $fitflix_short->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $fitflix_short->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="video_file" class="form-label">Video File</label>
                                    <input type="file" class="form-control @error('video_file') is-invalid @enderror" 
                                           id="video_file" name="video_file" accept="video/*">
                                    <div class="form-text">Upload new file only if you want to replace (Max: 500MB)</div>
                                    @if($fitflix_short->video_path)
                                        <p class="mt-2">Current: <a href="{{ Storage::url($fitflix_short->video_path) }}" target="_blank">View Video</a></p>
                                    @endif
                                    @error('video_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="thumbnail" class="form-label">Thumbnail</label>
                                    <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" 
                                           id="thumbnail" name="thumbnail" accept="image/*">
                                    <div class="form-text">Optional custom thumbnail</div>
                                    @if($fitflix_short->thumbnail_path)
                                        <p class="mt-2">
                                            <img src="{{ Storage::url($fitflix_short->thumbnail_path) }}" alt="Thumbnail" width="120">
                                        </p>
                                    @endif
                                    @error('thumbnail')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_published" name="is_published" 
                                           {{ old('is_published', $fitflix_short->is_published) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_published">
                                        Publish immediately
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" 
                                           {{ old('is_featured', $fitflix_short->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        Feature this short
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Short
                            </button>
                            <a href="{{ route('admin.community.fitflix-shorts.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Guidelines sidebar remains same as create -->
        <div class="col-lg-4">
            <div class="content-card">
                <div class="content-card-header">
                    <h5 class="mb-0">Upload Guidelines</h5>
                </div>
                <div class="content-card-body">
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle me-2"></i>Video Requirements</h6>
                        <ul class="mb-0">
                            <li><strong>Format:</strong> MP4, MOV, AVI, MKV, WebM</li>
                            <li><strong>Size:</strong> Maximum 500MB</li>
                            <li><strong>Orientation:</strong> Vertical (9:16 aspect ratio preferred)</li>
                            <li><strong>Duration:</strong> 15 seconds to 3 minutes recommended</li>
                        </ul>
                    </div>
                    
                    @if($categories->count() === 0)
                        <div class="alert alert-warning">
                            <h6><i class="fas fa-exclamation-triangle me-2"></i>No Categories</h6>
                            <p class="mb-2">You need to create at least one category before uploading shorts.</p>
                            <a href="{{ route('admin.community.fitflix-shorts.categories.create') }}" class="btn btn-sm btn-warning">
                                Create Category
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
