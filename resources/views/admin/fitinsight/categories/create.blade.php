@extends('layouts.admin')

@section('title', 'Create Category - FitInsight')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">Create New Category</h1>
                <p class="page-subtitle">Add a new category for organizing your fitness insights</p>
            </div>
            <div>
                <a href="{{ route('admin.fitinsight.categories.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Categories
                </a>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.fitinsight.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="content-card mb-4">
                    <div class="content-card-header">
                        <h5 class="mb-0">Basic Information</h5>
                    </div>
                    <div class="content-card-body">
                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" name="slug" value="{{ old('slug') }}">
                            <div class="form-text">Leave empty to auto-generate from name</div>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" 
                                      placeholder="Brief description of this category...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="content-card mb-4">
                    <div class="content-card-header">
                        <h5 class="mb-0">SEO Settings</h5>
                    </div>
                    <div class="content-card-body">
                        <!-- Meta Title -->
                        <div class="mb-3">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                   id="meta_title" name="meta_title" value="{{ old('meta_title') }}" 
                                   maxlength="60">
                            <div class="form-text">
                                <span id="meta-title-count">0</span>/60 characters. Leave empty to use category name.
                            </div>
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Meta Description -->
                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                      id="meta_description" name="meta_description" rows="3" 
                                      maxlength="160">{{ old('meta_description') }}</textarea>
                            <div class="form-text">
                                <span id="meta-desc-count">0</span>/160 characters. Leave empty to use description.
                            </div>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Meta Keywords -->
                        <div class="mb-3">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" 
                                   id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}" 
                                   placeholder="fitness, health, nutrition">
                            <div class="form-text">Comma-separated keywords for search engines.</div>
                            @error('meta_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Visual Settings -->
                <div class="content-card mb-4">
                    <div class="content-card-header">
                        <h5 class="mb-0">Visual Settings</h5>
                    </div>
                    <div class="content-card-body">
                        <!-- Icon -->
                        <div class="mb-3">
                            <label for="icon" class="form-label">Icon</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i id="icon-preview" class="fas fa-folder"></i>
                                </span>
                                <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                                       id="icon" name="icon" value="{{ old('icon', 'fas fa-folder') }}" 
                                       placeholder="fas fa-folder">
                            </div>
                            <div class="form-text">Font Awesome icon class (e.g., fas fa-heart)</div>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Color -->
                        <div class="mb-3">
                            <label for="color" class="form-label">Color</label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color @error('color') is-invalid @enderror" 
                                       id="color" name="color" value="{{ old('color', '#f7a31a') }}">
                                <input type="text" class="form-control" id="color-text" 
                                       value="{{ old('color', '#f7a31a') }}" readonly>
                            </div>
                            <div class="form-text">Theme color for this category</div>
                            @error('color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Banner Image -->
                        <div class="mb-3">
                            <label for="banner_image" class="form-label">Banner Image</label>
                            <input type="file" class="form-control @error('banner_image') is-invalid @enderror" 
                                   id="banner_image" name="banner_image" accept="image/*">
                            <div class="form-text">Recommended size: 1200x400px</div>
                            @error('banner_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Image Preview -->
                        <div id="banner-preview" style="display: none;">
                            <img id="banner-preview-img" src="" alt="Preview" class="img-fluid rounded">
                        </div>
                    </div>
                </div>

                <!-- Settings -->
                <div class="content-card mb-4">
                    <div class="content-card-header">
                        <h5 class="mb-0">Settings</h5>
                    </div>
                    <div class="content-card-body">
                        <!-- Sort Order -->
                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                            <div class="form-text">Lower numbers appear first</div>
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Active Status -->
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" 
                                       name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active Category
                                </label>
                            </div>
                            <div class="form-text">Only active categories are shown to users</div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="content-card">
                    <div class="content-card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Create Category
                            </button>
                            <a href="{{ route('admin.fitinsight.categories.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-generate slug from name
    $('#name').on('input', function() {
        if ($('#slug').val() === '') {
            const slug = $(this).val()
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            $('#slug').val(slug);
        }
    });

    // Character counters
    $('#meta_title').on('input', function() {
        $('#meta-title-count').text($(this).val().length);
    });

    $('#meta_description').on('input', function() {
        $('#meta-desc-count').text($(this).val().length);
    });

    // Icon preview
    $('#icon').on('input', function() {
        const iconClass = $(this).val() || 'fas fa-folder';
        $('#icon-preview').attr('class', iconClass);
    });

    // Color picker sync
    $('#color').on('input', function() {
        $('#color-text').val($(this).val());
    });

    // Banner image preview
    $('#banner_image').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#banner-preview-img').attr('src', e.target.result);
                $('#banner-preview').show();
            };
            reader.readAsDataURL(file);
        } else {
            $('#banner-preview').hide();
        }
    });

    // Initialize character counters
    $('#meta-title-count').text($('#meta_title').val().length);
    $('#meta-desc-count').text($('#meta_description').val().length);
});
</script>
@endpush 