@extends('layouts.admin')

@section('content')
<div class="subcategory-create">
    <!-- Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-folder-plus me-3"></i>Create Subcategory
                </h1>
                <p class="page-subtitle">Add a new subcategory for your FitGuide content</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('admin.fitguide.subcategories.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Subcategories
                </a>
            </div>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Form -->
    <div class="content-card">
        <div class="content-card-header">
            <h3 class="content-card-title">
                <i class="fas fa-info-circle me-2"></i>Subcategory Information
            </h3>
        </div>
        <div class="content-card-body">
            <form method="POST" action="{{ route('admin.fitguide.subcategories.store') }}" id="subcategoryForm">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label for="fg_category_id" class="form-label required">Parent Category</label>
                            <select class="form-select @error('fg_category_id') is-invalid @enderror" 
                                    id="fg_category_id" 
                                    name="fg_category_id" 
                                    required>
                                <option value="">Select Parent Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('fg_category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('fg_category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Choose the parent category for this subcategory</div>
                        </div>

                        <div class="mb-4">
                            <label for="name" class="form-label required">Subcategory Name</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Enter subcategory name"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">A descriptive name for your subcategory</div>
                        </div>

                        <div class="mb-4">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" 
                                   class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" 
                                   name="slug" 
                                   value="{{ old('slug') }}" 
                                   placeholder="subcategory-slug">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">URL-friendly version (auto-generated if left empty)</div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4" 
                                      placeholder="Enter subcategory description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Optional description for this subcategory</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="settings-card">
                            <h5 class="settings-title">
                                <i class="fas fa-cog me-2"></i>Settings
                            </h5>
                            
                            <div class="mb-3">
                                <label for="sort_order" class="form-label">Sort Order</label>
                                <input type="number" 
                                       class="form-control @error('sort_order') is-invalid @enderror" 
                                       id="sort_order" 
                                       name="sort_order" 
                                       value="{{ old('sort_order', 0) }}" 
                                       min="0">
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Lower numbers appear first</div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" 
                                        type="checkbox" 
                                        id="is_active" 
                                        name="is_active" 
                                        value="1"
                                        {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active Status
                                    </label>
                                </div>
                                <div class="form-text">Enable this subcategory for use</div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Create Subcategory
                    </button>
                    <a href="{{ route('admin.fitguide.subcategories.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.subcategory-create {
    animation: fadeInUp 0.6s ease-out;
}

.settings-card {
    background: var(--bg-light);
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid var(--border-color);
}

.settings-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.form-label.required::after {
    content: ' *';
    color: var(--danger-color);
}

.form-actions {
    display: flex;
    gap: 0.75rem;
    justify-content: flex-start;
}

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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    
    // Auto-generate slug from name
    nameInput.addEventListener('input', function() {
        if (!slugInput.value || slugInput.dataset.autoGenerated !== 'false') {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
            
            slugInput.value = slug;
            slugInput.dataset.autoGenerated = 'true';
        }
    });
    
    // Mark slug as manually edited
    slugInput.addEventListener('input', function() {
        this.dataset.autoGenerated = 'false';
    });
});
</script>
@endsection 