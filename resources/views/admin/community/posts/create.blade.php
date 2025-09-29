@extends('layouts.admin')

@section('title', 'Create Community Post')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="page-header mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="page-title">
                            <i class="fas fa-plus text-primary me-2"></i>
                            Create Community Post
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.community.dashboard') }}">Community</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.community.posts.index') }}">Posts</a></li>
                                <li class="breadcrumb-item active">Create</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-actions">
                        <a href="{{ route('admin.community.posts.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Posts
                        </a>
                    </div>
                </div>
            </div>

            <!-- Create Form -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Post Details</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.community.posts.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- Title -->
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title') }}" 
                                           placeholder="Enter post title"
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div class="mb-3">
                                    <label for="community_category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                    <select class="form-select @error('community_category_id') is-invalid @enderror" 
                                            id="community_category_id" 
                                            name="community_category_id" 
                                            required>
                                        <option value="">Select a category</option>
                                        @if(isset($categories))
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" 
                                                        {{ old('community_category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('community_category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Content -->
                                <div class="mb-3">
                                    <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('content') is-invalid @enderror" 
                                              id="content" 
                                              name="content" 
                                              rows="8" 
                                              placeholder="Write your post content here..."
                                              required>{{ old('content') }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Featured Image -->
                                <div class="mb-3">
                                    <label for="featured_image" class="form-label">Featured Image</label>
                                    <input type="file" 
                                           class="form-control @error('featured_image') is-invalid @enderror" 
                                           id="featured_image" 
                                           name="featured_image" 
                                           accept="image/*">
                                    <div class="form-text">Upload an image to be displayed with the post. Max size: 2MB</div>
                                    @error('featured_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tags -->
                                <div class="mb-3">
                                    <label for="tags" class="form-label">Tags</label>
                                    <input type="text" 
                                           class="form-control @error('tags') is-invalid @enderror" 
                                           id="tags" 
                                           name="tags" 
                                           value="{{ old('tags') }}" 
                                           placeholder="Enter tags separated by commas (e.g., fitness, workout, nutrition)">
                                    <div class="form-text">Separate multiple tags with commas</div>
                                    @error('tags')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Submit Buttons -->
                                <div class="d-flex gap-2">
                                    <button type="submit" name="action" value="save" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Save Post
                                    </button>
                                    <button type="submit" name="action" value="save_and_publish" class="btn btn-success">
                                        <i class="fas fa-rocket me-1"></i> Save & Publish
                                    </button>
                                    <a href="{{ route('admin.community.posts.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Post Settings -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Post Settings</h5>
                        </div>
                        <div class="card-body">
                            <!-- Status -->
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status_draft" value="draft" checked>
                                    <label class="form-check-label" for="status_draft">
                                        <i class="fas fa-edit text-warning me-1"></i> Draft
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status_published" value="published">
                                    <label class="form-check-label" for="status_published">
                                        <i class="fas fa-eye text-success me-1"></i> Published
                                    </label>
                                </div>
                            </div>

                            <!-- Featured -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1">
                                    <label class="form-check-label" for="is_featured">
                                        <i class="fas fa-star text-warning me-1"></i> Featured Post
                                    </label>
                                </div>
                                <div class="form-text">Featured posts appear prominently in the community</div>
                            </div>

                            <!-- Allow Comments -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="allow_comments" name="allow_comments" value="1" checked>
                                    <label class="form-check-label" for="allow_comments">
                                        <i class="fas fa-comments text-info me-1"></i> Allow Comments
                                    </label>
                                </div>
                            </div>

                            <!-- Pinned -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_pinned" name="is_pinned" value="1">
                                    <label class="form-check-label" for="is_pinned">
                                        <i class="fas fa-thumbtack text-danger me-1"></i> Pin Post
                                    </label>
                                </div>
                                <div class="form-text">Pinned posts stay at the top of the category</div>
                            </div>
                        </div>
                    </div>

                    <!-- Post Guidelines -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle text-info me-1"></i> Guidelines
                            </h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    <small>Keep content relevant to fitness and health</small>
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    <small>Use clear, descriptive titles</small>
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    <small>Add relevant tags for better discovery</small>
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    <small>Include engaging images when possible</small>
                                </li>
                                <li>
                                    <i class="fas fa-check text-success me-2"></i>
                                    <small>Encourage community interaction</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle save and publish buttons
    const saveButtons = document.querySelectorAll('button[name="action"]');
    saveButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (this.value === 'save_and_publish') {
                document.getElementById('status_published').checked = true;
            }
        });
    });

    // Auto-generate slug from title (if needed)
    const titleInput = document.getElementById('title');
    if (titleInput) {
        titleInput.addEventListener('input', function() {
            // Could add slug generation logic here if needed
        });
    }
});
</script>
@endpush

