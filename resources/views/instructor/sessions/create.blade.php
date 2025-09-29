@extends('layouts.app')

@section('title', 'Create New Session')

@section('content')
<div class="session-create fade-in-up">
    <!-- Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-plus-circle me-3"></i>
                    Create New Session
                </h1>
                <p class="page-subtitle">Create a new live fitness session for your audience</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('instructor.sessions') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Sessions
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="content-card">
                <div class="content-card-header">
                    <h3 class="content-card-title">
                        <i class="fas fa-edit me-2"></i>
                        Session Details
                    </h3>
                    <p class="content-card-subtitle">Fill in the details for your new live session</p>
                </div>
                <div class="content-card-body">
                    <form action="{{ route('instructor.sessions.store') }}" method="POST" id="session-form">
                        @csrf

                        <!-- Title -->
                        <div class="mb-4">
                            <label for="title" class="form-label">Session Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" 
                                   placeholder="Enter an engaging session title" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="5" 
                                      placeholder="Describe what participants can expect from this session..." required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Category and Subcategory -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="category_id" class="form-label">Category *</label>
                                    <select class="form-select @error('category_id') is-invalid @enderror" 
                                            id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        <!-- Categories will be loaded via JavaScript -->
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="sub_category_id" class="form-label">Subcategory</label>
                                    <select class="form-select @error('sub_category_id') is-invalid @enderror" 
                                            id="sub_category_id" name="sub_category_id" disabled>
                                        <option value="">Select Subcategory</option>
                                    </select>
                                    @error('sub_category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Scheduled Date and Time -->
                        <div class="mb-4">
                            <label for="scheduled_at" class="form-label">Scheduled Date & Time *</label>
                            <input type="datetime-local" class="form-control @error('scheduled_at') is-invalid @enderror" 
                                   id="scheduled_at" name="scheduled_at" 
                                   value="{{ old('scheduled_at', now()->addHour()->format('Y-m-d\TH:i')) }}" required>
                            @error('scheduled_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Schedule your session at least 1 hour from now
                            </div>
                        </div>

                        <!-- Session Settings -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="chat_mode" class="form-label">Chat Mode *</label>
                                    <select class="form-select @error('chat_mode') is-invalid @enderror" 
                                            id="chat_mode" name="chat_mode" required>
                                        <option value="during" {{ old('chat_mode', 'during') == 'during' ? 'selected' : '' }}>
                                            During Session Only
                                        </option>
                                        <option value="after" {{ old('chat_mode') == 'after' ? 'selected' : '' }}>
                                            During & After Session
                                        </option>
                                        <option value="off" {{ old('chat_mode') == 'off' ? 'selected' : '' }}>
                                            Chat Disabled
                                        </option>
                                    </select>
                                    @error('chat_mode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="visibility" class="form-label">Visibility *</label>
                                    <select class="form-select @error('visibility') is-invalid @enderror" 
                                            id="visibility" name="visibility" required>
                                        <option value="public" {{ old('visibility', 'public') == 'public' ? 'selected' : '' }}>
                                            Public (Everyone can see)
                                        </option>
                                        <option value="private" {{ old('visibility') == 'private' ? 'selected' : '' }}>
                                            Private (Invite only)
                                        </option>
                                    </select>
                                    @error('visibility')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Banner Image URL -->
                        <div class="mb-4">
                            <label for="banner_image" class="form-label">Banner Image URL</label>
                            <input type="url" class="form-control @error('banner_image') is-invalid @enderror" 
                                   id="banner_image" name="banner_image" value="{{ old('banner_image') }}" 
                                   placeholder="https://example.com/image.jpg">
                            @error('banner_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Optional: Add a banner image URL for your session
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between pt-3 border-top">
                            <a href="{{ route('instructor.sessions') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Create Session
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Preview Section -->
        <div class="col-lg-4">
            <div class="content-card">
                <div class="content-card-header">
                    <h3 class="content-card-title">
                        <i class="fas fa-eye me-2"></i>
                        Session Preview
                    </h3>
                </div>
                <div class="content-card-body">
                    <div class="session-card">
                        <div class="session-card-image">
                            <i class="fas fa-video fa-3x text-muted" id="preview-banner"></i>
                        </div>
                        <div class="session-card-body">
                            <h5 id="preview-title" class="session-title text-muted">Your session title will appear here</h5>
                            <p id="preview-description" class="session-description text-muted">Your session description will appear here</p>
                            
                            <div class="session-details">
                                <div class="d-flex gap-2 mb-2">
                                    <span class="role-badge role-user" id="preview-category" style="display: none;">Category</span>
                                    <span class="role-badge role-instructor" id="preview-subcategory" style="display: none;">Subcategory</span>
                                </div>
                                <div class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    <span id="preview-date">Scheduled date will appear here</span>
                                </div>
                                <div class="text-muted mt-1">
                                    <i class="fas fa-user me-1"></i>
                                    Instructor: {{ auth()->user()->name }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tips Card -->
            <div class="content-card">
                <div class="content-card-header">
                    <h3 class="content-card-title">
                        <i class="fas fa-lightbulb me-2"></i>
                        Tips for Success
                    </h3>
                </div>
                <div class="content-card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Use clear, descriptive titles
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Include session difficulty level
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Schedule during peak hours
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Enable chat for engagement
                        </li>
                        <li class="mb-0">
                            <i class="fas fa-check text-success me-2"></i>
                            Add an eye-catching banner
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load categories
    loadCategories();
    
    // Set up event listeners
    setupEventListeners();
    
    // Initialize preview
    updatePreview();
});

function loadCategories() {
    fetch('/api/instructor/categories', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        },
        credentials: 'include'
    })
    .then(response => response.json())
    .then(categories => {
        const categorySelect = document.getElementById('category_id');
        categorySelect.innerHTML = '<option value="">Select Category</option>';
        
        categories.forEach(category => {
            const option = document.createElement('option');
            option.value = category.id;
            option.textContent = category.name;
            if ('{{ old("category_id") }}' == category.id) {
                option.selected = true;
            }
            categorySelect.appendChild(option);
        });
        
        // Load subcategories if category is pre-selected
        if (categorySelect.value) {
            loadSubcategories(categorySelect.value);
        }
    })
    .catch(error => {
        console.error('Error loading categories:', error);
    });
}

function loadSubcategories(categoryId) {
    const subCategorySelect = document.getElementById('sub_category_id');
    
    if (!categoryId) {
        subCategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
        subCategorySelect.disabled = true;
        return;
    }
    
    fetch(`/api/instructor/categories/${categoryId}/subcategories`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        },
        credentials: 'include'
    })
    .then(response => response.json())
    .then(subcategories => {
        subCategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
        
        subcategories.forEach(subcategory => {
            const option = document.createElement('option');
            option.value = subcategory.id;
            option.textContent = subcategory.name;
            if ('{{ old("sub_category_id") }}' == subcategory.id) {
                option.selected = true;
            }
            subCategorySelect.appendChild(option);
        });
        
        subCategorySelect.disabled = false;
    })
    .catch(error => {
        console.error('Error loading subcategories:', error);
        subCategorySelect.disabled = true;
    });
}

function setupEventListeners() {
    // Category change
    document.getElementById('category_id').addEventListener('change', function() {
        loadSubcategories(this.value);
        updatePreview();
    });
    
    // Form field changes for preview
    ['title', 'description', 'sub_category_id', 'scheduled_at', 'banner_image'].forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('input', updatePreview);
            field.addEventListener('change', updatePreview);
        }
    });
}

function updatePreview() {
    // Update title
    const title = document.getElementById('title').value || 'Your session title will appear here';
    document.getElementById('preview-title').textContent = title;
    
    // Update description
    const description = document.getElementById('description').value || 'Your session description will appear here';
    document.getElementById('preview-description').textContent = description;
    
    // Update category
    const categorySelect = document.getElementById('category_id');
    const categoryPreview = document.getElementById('preview-category');
    if (categorySelect.value && categorySelect.selectedOptions[0]) {
        categoryPreview.textContent = categorySelect.selectedOptions[0].textContent;
        categoryPreview.style.display = 'inline-flex';
    } else {
        categoryPreview.style.display = 'none';
    }
    
    // Update subcategory
    const subCategorySelect = document.getElementById('sub_category_id');
    const subCategoryPreview = document.getElementById('preview-subcategory');
    if (subCategorySelect.value && subCategorySelect.selectedOptions[0]) {
        subCategoryPreview.textContent = subCategorySelect.selectedOptions[0].textContent;
        subCategoryPreview.style.display = 'inline-flex';
    } else {
        subCategoryPreview.style.display = 'none';
    }
    
    // Update date
    const scheduledAt = document.getElementById('scheduled_at').value;
    const datePreview = document.getElementById('preview-date');
    if (scheduledAt) {
        const date = new Date(scheduledAt);
        datePreview.textContent = date.toLocaleString();
    } else {
        datePreview.textContent = 'Scheduled date will appear here';
    }
    
    // Update banner
    const bannerUrl = document.getElementById('banner_image').value;
    const bannerPreview = document.getElementById('preview-banner');
    if (bannerUrl) {
        bannerPreview.innerHTML = `<img src="${bannerUrl}" alt="Session Banner" style="width: 100%; height: 100%; object-fit: cover;">`;
    } else {
        bannerPreview.innerHTML = '<i class="fas fa-video fa-3x text-muted"></i>';
    }
}
</script>
@endpush 