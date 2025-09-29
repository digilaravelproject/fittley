@extends('layouts.admin')

@section('title', 'Edit Category: ' . $category->name)

@section('content')
<div class="admin-dashboard">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h1 class="page-title-text">
                    <i class="fas fa-edit page-title-icon"></i>
                    Edit Category
                </h1>
                <p class="page-subtitle">Update category information and settings</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.community.categories.show', $category->id) }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Category
                </a>
                <a href="{{ route('admin.community.categories.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-list me-2"></i>All Categories
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

    <form method="POST" action="{{ route('admin.community.categories.update', $category->id) }}" id="categoryForm">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Main Form -->
            <div class="col-xl-8">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3 class="card-title">Category Information</h3>
                    </div>
                    <div class="card-body">
                        <!-- Category Name -->
                        <div class="mb-4">
                            <label for="name" class="form-label required">Category Name</label>
                            <input type="text" id="name" name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $category->name) }}" 
                                   placeholder="Enter category name"
                                   maxlength="100" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Choose a clear, descriptive name for your category</small>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      rows="3" 
                                      placeholder="Describe what this category is for..."
                                      maxlength="500">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Optional description to help users understand when to use this category</small>
                        </div>

                        <!-- Color and Icon Row -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="color" class="form-label required">Category Color</label>
                                    <div class="input-group">
                                        <input type="color" id="color" name="color" 
                                               class="form-control form-control-color @error('color') is-invalid @enderror" 
                                               value="{{ old('color', $category->color) }}" required>
                                        <input type="text" id="colorText" 
                                               class="form-control" 
                                               value="{{ old('color', $category->color) }}" 
                                               pattern="^#[a-fA-F0-9]{6}$"
                                               placeholder="#f7a31a">
                                    </div>
                                    @error('color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Choose a distinctive color for this category</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="icon" class="form-label required">Category Icon</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i id="iconPreview" class="{{ old('icon', $category->icon) }}"></i>
                                        </span>
                                        <input type="text" id="icon" name="icon" 
                                               class="form-control @error('icon') is-invalid @enderror" 
                                               value="{{ old('icon', $category->icon) }}" 
                                               placeholder="fas fa-folder" required>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#iconModal">
                                            Browse
                                        </button>
                                    </div>
                                    @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">FontAwesome icon class (e.g., fas fa-heart)</small>
                                </div>
                            </div>
                        </div>

                        <!-- Order -->
                        <div class="mb-4">
                            <label for="order" class="form-label">Display Order</label>
                            <input type="number" id="order" name="order" 
                                   class="form-control @error('order') is-invalid @enderror" 
                                   value="{{ old('order', $category->order) }}" 
                                   min="0" max="999">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Lower numbers appear first</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-xl-4">
                <!-- Preview -->
                <div class="dashboard-card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Preview</h3>
                    </div>
                    <div class="card-body">
                        <div class="category-preview">
                            <div class="category-preview-item">
                                <div class="category-icon" id="previewIcon" style="background-color: {{ old('color', $category->color) }};">
                                    <i class="{{ old('icon', $category->icon) }}"></i>
                                </div>
                                <div class="category-info">
                                    <h6 id="previewName">{{ old('name', $category->name) }}</h6>
                                    <small id="previewDescription" class="text-muted">{{ old('description', $category->description) ?: 'No description provided' }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category Stats -->
                <div class="dashboard-card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Category Statistics</h3>
                    </div>
                    <div class="card-body">
                        <div class="stats-list">
                            <div class="stat-item">
                                <div class="stat-label">Total Posts</div>
                                <div class="stat-value">{{ $category->posts_count ?? 0 }}</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-label">Total Groups</div>
                                <div class="stat-value">{{ $category->groups_count ?? 0 }}</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-label">Created</div>
                                <div class="stat-value">{{ $category->created_at->format('M d, Y') }}</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-label">Last Updated</div>
                                <div class="stat-value">{{ $category->updated_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Settings and Actions -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3 class="card-title">Category Settings</h3>
                    </div>
                    <div class="card-body">
                        <!-- Active Status -->
                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active Category
                                </label>
                            </div>
                            <small class="form-text text-muted">Only active categories are visible to users</small>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Category
                            </button>
                            <a href="{{ route('admin.community.categories.show', $category->id) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel Changes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Icon Selection Modal -->
<div class="modal fade" id="iconModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Icon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3" id="iconGrid">
                    <!-- Popular Community Icons -->
                    <div class="col-12">
                        <h6>Popular Community Icons</h6>
                    </div>
                    @php
                    $popularIcons = [
                        'fas fa-comments', 'fas fa-users', 'fas fa-heart', 'fas fa-star',
                        'fas fa-thumbs-up', 'fas fa-fire', 'fas fa-trophy', 'fas fa-medal',
                        'fas fa-dumbbell', 'fas fa-running', 'fas fa-bicycle', 'fas fa-swimmer',
                        'fas fa-apple-alt', 'fas fa-leaf', 'fas fa-brain', 'fas fa-graduation-cap',
                        'fas fa-book', 'fas fa-camera', 'fas fa-music', 'fas fa-gamepad',
                        'fas fa-coffee', 'fas fa-pizza-slice', 'fas fa-car', 'fas fa-plane',
                        'fas fa-home', 'fas fa-briefcase', 'fas fa-shopping-bag', 'fas fa-gift'
                    ];
                    @endphp
                    @foreach($popularIcons as $icon)
                        <div class="col-2">
                            <button type="button" class="btn btn-outline-secondary icon-btn w-100" data-icon="{{ $icon }}">
                                <i class="{{ $icon }}"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.required::after {
    content: " *";
    color: #e50914;
}

.category-preview-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--bg-tertiary);
    border-radius: 8px;
    border: 1px solid var(--border-primary);
}

.category-icon {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    transition: all 0.3s ease;
}

.category-info h6 {
    margin: 0 0 0.25rem;
    color: var(--text-primary);
}

.form-control-color {
    width: 60px;
    height: 38px;
    border-radius: 6px 0 0 6px;
}

.icon-btn {
    aspect-ratio: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.icon-btn:hover {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}

.stats-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.stat-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border-primary);
}

.stat-item:last-child {
    border-bottom: none;
}

.stat-label {
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.stat-value {
    color: var(--text-primary);
    font-weight: 600;
}

.form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const colorInput = document.getElementById('color');
    const colorTextInput = document.getElementById('colorText');
    const iconInput = document.getElementById('icon');
    
    const previewName = document.getElementById('previewName');
    const previewDescription = document.getElementById('previewDescription');
    const previewIcon = document.getElementById('previewIcon');
    const iconPreview = document.getElementById('iconPreview');

    // Real-time preview updates
    nameInput.addEventListener('input', function() {
        previewName.textContent = this.value || 'Category Name';
    });

    descriptionInput.addEventListener('input', function() {
        previewDescription.textContent = this.value || 'No description provided';
    });

    colorInput.addEventListener('input', function() {
        const color = this.value;
        previewIcon.style.backgroundColor = color;
        colorTextInput.value = color;
    });

    colorTextInput.addEventListener('input', function() {
        const color = this.value;
        if (/^#[a-fA-F0-9]{6}$/.test(color)) {
            previewIcon.style.backgroundColor = color;
            colorInput.value = color;
        }
    });

    iconInput.addEventListener('input', function() {
        const iconClass = this.value;
        previewIcon.innerHTML = `<i class="${iconClass}"></i>`;
        iconPreview.className = iconClass;
    });

    // Icon selection from modal
    document.querySelectorAll('.icon-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const iconClass = this.dataset.icon;
            iconInput.value = iconClass;
            previewIcon.innerHTML = `<i class="${iconClass}"></i>`;
            iconPreview.className = iconClass;
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('iconModal'));
            modal.hide();
        });
    });

    // Form validation
    document.getElementById('categoryForm').addEventListener('submit', function(e) {
        const name = nameInput.value.trim();
        const color = colorInput.value;
        const icon = iconInput.value.trim();

        if (!name) {
            e.preventDefault();
            alert('Category name is required');
            nameInput.focus();
            return;
        }

        if (!/^#[a-fA-F0-9]{6}$/.test(color)) {
            e.preventDefault();
            alert('Please enter a valid hex color code');
            colorInput.focus();
            return;
        }

        if (!icon) {
            e.preventDefault();
            alert('Category icon is required');
            iconInput.focus();
            return;
        }
    });
});
</script>
@endpush 