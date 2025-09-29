@extends('layouts.admin')

@section('title', 'Edit Session')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card bg-dark border-secondary">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title text-white mb-0">
                        <i class="fas fa-edit me-2"></i>Edit Session: {{ Str::limit($session->title, 40) }}
                    </h3>
                    <a href="{{ route('admin.fitlive.sessions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back to Sessions
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.fitlive.sessions.update', ['fitLiveSession' => $session->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-8">
                                <div class="card bg-secondary border-info mb-4">
                                    <div class="card-header">
                                        <h5 class="text-white mb-0">Basic Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="title" class="form-label text-white">Session Title *</label>
                                            <input type="text" 
                                                   class="form-control bg-dark border-secondary text-white @error('title') is-invalid @enderror" 
                                                   id="title" 
                                                   name="title" 
                                                   value="{{ old('title', $session->title) }}" 
                                                   required>
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label text-white">Description</label>
                                            <textarea class="form-control bg-dark border-secondary text-white @error('description') is-invalid @enderror" 
                                                      id="description" 
                                                      name="description" 
                                                      rows="4">{{ old('description', $session->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="category_id" class="form-label text-white">Category *</label>
                                                    <select class="form-select bg-dark border-secondary text-white @error('category_id') is-invalid @enderror" 
                                                            id="category_id" 
                                                            name="category_id" 
                                                            required>
                                                        <option value="">Select Category</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" 
                                                                    {{ old('category_id', $session->category_id) == $category->id ? 'selected' : '' }}>
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="sub_category_id" class="form-label text-white">Sub Category</label>
                                                    <select class="form-select bg-dark border-secondary text-white @error('sub_category_id') is-invalid @enderror" 
                                                            id="sub_category_id" 
                                                            name="sub_category_id">
                                                        <option value="">Select Sub Category</option>
                                                        @foreach($subCategories as $subCategory)
                                                            <option value="{{ $subCategory->id }}" 
                                                                    data-category="{{ $subCategory->category_id }}"
                                                                    {{ old('sub_category_id', $session->sub_category_id) == $subCategory->id ? 'selected' : '' }}>
                                                                {{ $subCategory->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('sub_category_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="instructor_id" class="form-label text-white">Instructor *</label>
                                            <select class="form-select bg-dark border-secondary text-white @error('instructor_id') is-invalid @enderror" 
                                                    id="instructor_id" 
                                                    name="instructor_id" 
                                                    required>
                                                <option value="">Select Instructor</option>
                                                @foreach($instructors as $instructor)
                                                    <option value="{{ $instructor->id }}" 
                                                            {{ old('instructor_id', $session->instructor_id) == $instructor->id ? 'selected' : '' }}>
                                                        {{ $instructor->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('instructor_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Session Settings -->
                            <div class="col-md-4">
                                <div class="card bg-secondary border-warning mb-4">
                                    <div class="card-header">
                                        <h5 class="text-white mb-0">Session Settings</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="scheduled_at" class="form-label text-white">Scheduled Date & Time</label>
                                            <input type="datetime-local" 
                                                   class="form-control bg-dark border-secondary text-white @error('scheduled_at') is-invalid @enderror" 
                                                   id="scheduled_at" 
                                                   name="scheduled_at" 
                                                   value="{{ old('scheduled_at', $session->scheduled_at ? $session->scheduled_at->format('Y-m-d\TH:i') : '') }}">
                                            @error('scheduled_at')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="chat_mode" class="form-label text-white">Chat Mode *</label>
                                            <select class="form-select bg-dark border-secondary text-white @error('chat_mode') is-invalid @enderror" 
                                                    id="chat_mode" 
                                                    name="chat_mode" 
                                                    required>
                                                <option value="">Select Chat Mode</option>
                                                <option value="during" {{ old('chat_mode', $session->chat_mode) == 'during' ? 'selected' : '' }}>
                                                    During Live
                                                </option>
                                                <option value="after" {{ old('chat_mode', $session->chat_mode) == 'after' ? 'selected' : '' }}>
                                                    After Live
                                                </option>
                                                <option value="off" {{ old('chat_mode', $session->chat_mode) == 'off' ? 'selected' : '' }}>
                                                    Disabled
                                                </option>
                                            </select>
                                            @error('chat_mode')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="session_type" class="form-label text-white">Session Type *</label>
                                            <select class="form-select bg-dark border-secondary text-white @error('session_type') is-invalid @enderror" 
                                                    id="session_type" 
                                                    name="session_type" 
                                                    required>
                                                <option value="">Select Session Type</option>
                                                <option value="daily" {{ old('session_type', $session->session_type) == 'daily' ? 'selected' : '' }}>
                                                    Daily
                                                </option>
                                                <option value="one_time" {{ old('session_type', $session->session_type) == 'one_time' ? 'selected' : '' }}>
                                                    One Time
                                                </option>
                                            </select>
                                            @error('session_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="mb-3">
                                            <label for="visibility" class="form-label text-white">Visibility *</label>
                                            <select class="form-select bg-dark border-secondary text-white @error('visibility') is-invalid @enderror" 
                                                    id="visibility" 
                                                    name="visibility" 
                                                    required>
                                                <option value="public" {{ old('visibility', $session->visibility) == 'public' ? 'selected' : '' }}>
                                                    Public
                                                </option>
                                                <option value="private" {{ old('visibility', $session->visibility) == 'private' ? 'selected' : '' }}>
                                                    Private
                                                </option>
                                            </select>
                                            @error('visibility')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="banner_image" class="form-label text-white">Banner Image</label>
                                            @if($session->banner_image)
                                                <div class="mb-2">
                                                    <img src="{{ Storage::url($session->banner_image) }}" 
                                                         alt="Current banner" 
                                                         class="img-thumbnail" 
                                                         style="max-width: 100px;">
                                                    <div class="form-text text-muted">Current banner image</div>
                                                </div>
                                            @endif
                                            <input type="file" 
                                                   class="form-control bg-dark border-secondary text-white @error('banner_image') is-invalid @enderror" 
                                                   id="banner_image" 
                                                   name="banner_image" 
                                                   accept="image/*">
                                            @error('banner_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text text-muted">Max size: 2MB. Formats: JPG, PNG, GIF</div>
                                        </div>

                                        <!-- Session Status (read-only) -->
                                        <div class="mb-3">
                                            <label class="form-label text-white">Current Status</label>
                                            <div>
                                                @switch($session->status)
                                                    @case('scheduled')
                                                        <span class="badge bg-warning fs-6">Scheduled</span>
                                                        @break
                                                    @case('live')
                                                        <span class="badge bg-success fs-6">Live</span>
                                                        @break
                                                    @case('ended')
                                                        <span class="badge bg-secondary fs-6">Ended</span>
                                                        @break
                                                @endswitch
                                            </div>
                                        </div>

                                        @if($session->viewer_peak)
                                            <div class="mb-3">
                                                <label class="form-label text-white">Peak Viewers</label>
                                                <div>
                                                    <span class="badge bg-info fs-6">{{ $session->viewer_peak }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card bg-secondary">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('admin.fitlive.sessions.index') }}" class="btn btn-secondary">
                                                Cancel
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save me-1"></i>Update Session
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('category_id');
    const subCategorySelect = document.getElementById('sub_category_id');
    
    // Filter subcategories based on selected category
    categorySelect.addEventListener('change', function() {
        const selectedCategoryId = this.value;
        const subCategoryOptions = subCategorySelect.querySelectorAll('option');
        
        // Show/hide subcategory options based on selected category
        subCategoryOptions.forEach(option => {
            if (option.value === '') {
                option.style.display = 'block';
            } else {
                const optionCategoryId = option.getAttribute('data-category');
                option.style.display = optionCategoryId === selectedCategoryId ? 'block' : 'none';
            }
        });
        
        // Reset subcategory if it doesn't belong to selected category
        const currentSubCategoryId = subCategorySelect.value;
        if (currentSubCategoryId) {
            const currentOption = subCategorySelect.querySelector(`option[value="${currentSubCategoryId}"]`);
            if (currentOption && currentOption.getAttribute('data-category') !== selectedCategoryId) {
                subCategorySelect.value = '';
            }
        }
    });
    
    // Trigger initial filtering
    categorySelect.dispatchEvent(new Event('change'));
});
</script>
@endsection 