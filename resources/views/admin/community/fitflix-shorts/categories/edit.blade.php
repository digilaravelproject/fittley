@extends('layouts.admin')

@section('title', 'Edit FitFlix Shorts Category - ' . $fitflix_shorts_category->name)

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">Edit Category</h1>
                <p class="page-subtitle">Update "{{ $fitflix_shorts_category->name }}" category details</p>
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
                    <form method="POST" action="{{ route('admin.community.fitflix-shorts.categories.update', $fitflix_shorts_category) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $fitflix_shorts_category->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                           id="slug" name="slug" value="{{ old('slug', $fitflix_shorts_category->slug) }}">
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
                                      id="description" name="description" rows="3">{{ old('description', $fitflix_shorts_category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="icon" class="form-label">Icon Class</label>
                                    <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                                           id="icon" name="icon" value="{{ old('icon', $fitflix_shorts_category->icon) }}" 
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
                                           id="color" name="color" value="{{ old('color', $fitflix_shorts_category->color) }}">
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
                                           id="sort_order" name="sort_order" value="{{ old('sort_order', $fitflix_shorts_category->sort_order) }}" min="0">
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
                                    <div class="form-text">Upload new image to replace current banner</div>
                                    @error('banner_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    @if($fitflix_shorts_category->banner_image_path)
                                        <div class="mt-2">
                                            <img src="{{ $fitflix_shorts_category->banner_image_url }}" 
                                                 alt="Current banner" class="img-thumbnail" style="max-height: 100px;">
                                            <small class="text-muted d-block">Current banner image</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       {{ old('is_active', $fitflix_shorts_category->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active Category
                                </label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Category
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
                                 style="width: 50px; height: 50px; color: {{ $fitflix_shorts_category->color }};">
                                <i class="{{ $fitflix_shorts_category->icon ?: 'fas fa-mobile-alt' }}"></i>
                            </div>
                            <div>
                                <div class="fw-bold">{{ $fitflix_shorts_category->name }}</div>
                                <small class="text-muted">{{ Str::limit($fitflix_shorts_category->description ?: 'No description', 50) }}</small>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="fw-bold text-primary">{{ $fitflix_shorts_category->shorts_count ?? 0 }}</div>
                            <small class="text-muted">Total Shorts</small>
                        </div>
                        <div class="col-6">
                            <div class="fw-bold text-success">{{ $fitflix_shorts_category->published_shorts_count ?? 0 }}</div>
                            <small class="text-muted">Published</small>
                        </div>
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
        const name = $('#name').val() || '{{ $fitflix_shorts_category->name }}';
        const icon = $('#icon').val() || '{{ $fitflix_shorts_category->icon }}' || 'fas fa-mobile-alt';
        const color = $('#color').val() || '{{ $fitflix_shorts_category->color }}';
        const description = $('#description').val() || '{{ $fitflix_shorts_category->description }}' || 'No description';
        
        $('.category-preview .fw-bold').text(name);
        $('.category-preview .text-muted').text(description.substring(0, 50) + (description.length > 50 ? '...' : ''));
        $('.preview-icon i').removeClass().addClass(icon);
        $('.preview-icon').css('color', color);
    }
</script>
@endpush
@endsection 