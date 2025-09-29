@extends('layouts.admin')

@section('title', 'Create FitFlix Shorts Category')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">Create FitFlix Shorts Category</h1>
                <p class="page-subtitle">Add a new category for FitFlix short videos</p>
            </div>
            <div>
                <a href="{{ route('admin.community.fitflix-shorts.categories.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Categories
                </a>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="content-card">
                <div class="content-card-header">
                    <h5 class="mb-0">Category Information</h5>
                </div>
                <div class="content-card-body">
                    <form method="POST" action="{{ route('admin.community.fitflix-shorts.categories.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                           id="slug" name="slug" value="{{ old('slug') }}">
                                    <div class="form-text">Leave empty to auto-generate from name</div>
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="icon" class="form-label">Icon Class</label>
                                    <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                                           id="icon" name="icon" value="{{ old('icon', 'fas fa-mobile-alt') }}" 
                                           placeholder="fas fa-mobile-alt">
                                    <div class="form-text">Font Awesome icon class</div>
                                    @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="color" class="form-label">Color</label>
                                    <input type="color" class="form-control form-control-color @error('color') is-invalid @enderror" 
                                           id="color" name="color" value="{{ old('color', '#f7a31a') }}">
                                    @error('color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Sort Order</label>
                                    <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                           id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="banner_image" class="form-label">Banner Image</label>
                                    <input type="file" class="form-control @error('banner_image') is-invalid @enderror" 
                                           id="banner_image" name="banner_image" accept="image/*">
                                    <div class="form-text">Optional banner image for the category</div>
                                    @error('banner_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active Category
                                </label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Category
                            </button>
                            <a href="{{ route('admin.community.fitflix-shorts.categories.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="content-card">
                <div class="content-card-header">
                    <h5 class="mb-0">Preview</h5>
                </div>
                <div class="content-card-body">
                    <div class="category-preview">
                        <div class="d-flex align-items-center">
                            <div class="preview-icon bg-secondary rounded me-3 d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px; color: #f7a31a;">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div>
                                <div class="fw-bold">Category Name</div>
                                <small class="text-muted">Preview description</small>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle me-2"></i>Tips</h6>
                        <ul class="mb-0">
                            <li>Use descriptive category names</li>
                            <li>Choose appropriate icons from Font Awesome</li>
                            <li>Select colors that fit your brand</li>
                            <li>Use sort order to control display sequence</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-generate slug from name
    $('#name').on('input', function() {
        const name = $(this).val();
        const slug = name.toLowerCase()
                        .replace(/[^a-z0-9]+/g, '-')
                        .replace(/^-+|-+$/g, '');
        $('#slug').val(slug);
        updatePreview();
    });

    // Update preview when fields change
    $('#name, #icon, #color, #description').on('input', function() {
        updatePreview();
    });

    function updatePreview() {
        const name = $('#name').val() || 'Category Name';
        const icon = $('#icon').val() || 'fas fa-mobile-alt';
        const color = $('#color').val() || '#f7a31a';
        const description = $('#description').val() || 'Preview description';
        
        $('.category-preview .fw-bold').text(name);
        $('.category-preview .text-muted').text(description.substring(0, 50) + (description.length > 50 ? '...' : ''));
        $('.preview-icon i').removeClass().addClass(icon);
        $('.preview-icon').css('color', color);
    }
</script>
@endpush
@endsection 