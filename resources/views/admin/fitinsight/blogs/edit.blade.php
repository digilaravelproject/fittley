@extends('layouts.admin')

@section('title', 'Edit Blog Post')

@section('content')
<style>
    /* Custom styling for edit blog page */
    .content-wrapper {
        background-color: #191919 !important;
        color: white !important;
    }
    
    .card {
        background-color: #191919 !important;
        border: 1px solid #333 !important;
        color: white !important;
    }
    
    .card-header {
        background-color: #191919 !important;
        border-bottom: 1px solid #333 !important;
        color: white !important;
    }
    
    .form-control {
        background-color: #2a2a2a !important;
        border: 1px solid #444 !important;
        color: white !important;
    }
    
    .form-control:focus {
        background-color: #2a2a2a !important;
        border-color: #f8a721 !important;
        box-shadow: 0 0 0 0.2rem rgba(248, 167, 33, 0.25) !important;
        color: white !important;
    }
    
    .form-control::placeholder {
        color: #aaa !important;
    }
    
    .btn-primary {
        background-color: #f8a721 !important;
        border-color: #f8a721 !important;
        color: #191919 !important;
        font-weight: 600;
    }
    
    .btn-primary:hover {
        background-color: #e6961e !important;
        border-color: #e6961e !important;
        color: #191919 !important;
    }
    
    .btn-secondary {
        background-color: #444 !important;
        border-color: #444 !important;
        color: white !important;
    }
    
    .btn-secondary:hover {
        background-color: #555 !important;
        border-color: #555 !important;
        color: white !important;
    }
    
    .btn-outline-secondary {
        background-color: transparent !important;
        border-color: #444 !important;
        color: white !important;
    }
    
    .btn-outline-secondary:hover {
        background-color: #444 !important;
        border-color: #444 !important;
        color: white !important;
    }
    
    .form-label {
        color: white !important;
        font-weight: 500;
    }
    
    .form-check-label {
        color: white !important;
    }
    
    .form-check-input:checked {
        background-color: #f8a721 !important;
        border-color: #f8a721 !important;
    }
    
    .form-select {
        background-color: #2a2a2a !important;
        border: 1px solid #444 !important;
        color: white !important;
    }
    
    .form-select:focus {
        background-color: #2a2a2a !important;
        border-color: #f8a721 !important;
        box-shadow: 0 0 0 0.2rem rgba(248, 167, 33, 0.25) !important;
        color: white !important;
    }
    
    .input-group-text {
        background-color: #2a2a2a !important;
        border: 1px solid #444 !important;
        color: #f8a721 !important;
    }
    
    .alert-info {
        background-color: rgba(248, 167, 33, 0.1) !important;
        border-color: #f8a721 !important;
        color: #f8a721 !important;
    }
    
    .collapse {
        background-color: #191919 !important;
    }
    
    .form-text {
        color: #aaa !important;
    }
    
    .character-count {
        font-size: 0.875rem;
        color: #aaa !important;
    }
    .character-count.warning {
        color: #f0ad4e !important;
    }
    .character-count.danger {
        color: #d9534f !important;
    }
    
    /* Quill Editor Styling */
    .ql-toolbar {
        background-color: #2a2a2a !important;
        border: 1px solid #444 !important;
        color: white !important;
    }
    
    .ql-container {
        background-color: #2a2a2a !important;
        border: 1px solid #444 !important;
        color: white !important;
    }
    
    .ql-editor {
        color: white !important;
        min-height: 300px;
    }
    
    .ql-editor.ql-blank::before {
        color: #aaa !important;
    }
    
    .ql-snow .ql-picker {
        color: white !important;
    }
    
    .ql-snow .ql-stroke {
        stroke: white !important;
    }
    
    .ql-snow .ql-fill {
        fill: white !important;
    }
    
    .ql-snow .ql-picker-options {
        background-color: #2a2a2a !important;
        border: 1px solid #444 !important;
    }
    
    .ql-snow .ql-picker-item:hover {
        background-color: #f8a721 !important;
        color: #191919 !important;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i> Edit Blog Post
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.fitinsight.blogs.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Blogs
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.fitinsight.blogs.update', $fiBlog) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <!-- Main Content Column -->
                            <div class="col-md-8">
                                <!-- Title -->
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">Title *</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title', $fiBlog->title) }}" 
                                           placeholder="Enter blog post title" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Slug -->
                                <div class="form-group mb-3">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                           id="slug" name="slug" value="{{ old('slug', $fiBlog->slug) }}" 
                                           placeholder="auto-generated-from-title">
                                    <div class="form-text">Leave empty to auto-generate from title</div>
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Excerpt -->
                                <div class="form-group mb-3">
                                    <label for="excerpt" class="form-label">Excerpt</label>
                                    <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                              id="excerpt" name="excerpt" rows="3" 
                                              placeholder="Brief description of the blog post">{{ old('excerpt', $fiBlog->excerpt) }}</textarea>
                                    <div class="form-text">Optional: A brief summary that appears in blog listings</div>
                                    @error('excerpt')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Content -->
                                <div class="form-group mb-4">
                                    <label for="content" class="form-label">Content *</label>
                                    <div id="quill-editor"></div>
                                    <textarea name="content" id="content" style="display: none;">{{ old('content', $fiBlog->content) }}</textarea>
                                    @error('content')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- SEO Settings -->
                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">SEO Settings</h5>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" 
                                                data-bs-toggle="collapse" data-bs-target="#seoSettings">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </div>
                                    <div class="collapse" id="seoSettings">
                                        <div class="card-body">
                                            <!-- Meta Title -->
                                            <div class="form-group mb-3">
                                                <label for="meta_title" class="form-label">Meta Title</label>
                                                <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                                       id="meta_title" name="meta_title" value="{{ old('meta_title', $fiBlog->meta_title) }}" 
                                                       maxlength="60" placeholder="SEO title for search engines">
                                                <div class="form-text">
                                                    <span id="meta-title-count">{{ strlen(old('meta_title', $fiBlog->meta_title ?? '')) }}</span>/60 characters
                                                </div>
                                                @error('meta_title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <!-- Meta Description -->
                                            <div class="form-group mb-3">
                                                <label for="meta_description" class="form-label">Meta Description</label>
                                                <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                                          id="meta_description" name="meta_description" rows="3" 
                                                          maxlength="160" placeholder="SEO description for search engines">{{ old('meta_description', $fiBlog->meta_description) }}</textarea>
                                                <div class="form-text">
                                                    <span id="meta-desc-count">{{ strlen(old('meta_description', $fiBlog->meta_description ?? '')) }}</span>/160 characters
                                                </div>
                                                @error('meta_description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Meta Keywords -->
                                            <div class="form-group mb-3">
                                                <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                                <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" 
                                                       id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $fiBlog->meta_keywords) }}" 
                                                       placeholder="keyword1, keyword2, keyword3">
                                                <div class="form-text">Separate keywords with commas</div>
                                                @error('meta_keywords')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Canonical URL -->
                                            <div class="form-group mb-3">
                                                <label for="canonical_url" class="form-label">Canonical URL</label>
                                                <input type="url" class="form-control @error('canonical_url') is-invalid @enderror" 
                                                       id="canonical_url" name="canonical_url" value="{{ old('canonical_url', $fiBlog->canonical_url) }}" 
                                                       placeholder="https://example.com/canonical-url">
                                                <div class="form-text">Leave empty to use default URL</div>
                                                @error('canonical_url')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Social Media Settings -->
                                            <hr class="my-4">
                                            <h6 class="mb-3">Social Media Settings</h6>
                                            
                                            <!-- Current Social Image -->
                                            @if($fiBlog->social_image_path)
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Current Social Media Image</label>
                                                    <div>
                                                        <img src="{{ asset('storage/app/public/' . $fiBlog->social_image_path) }}" 
                                                             alt="Current social media image" class="img-fluid rounded mb-2" style="max-height: 200px;">
                                                        <p class="text-muted small">Current social media image</p>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            <!-- Social Image -->
                                            <div class="form-group mb-3">
                                                <label for="social_image" class="form-label">Social Media Image</label>
                                                <input type="file" class="form-control @error('social_image') is-invalid @enderror" 
                                                       id="social_image" name="social_image" accept="image/*">
                                                <div class="form-text">Recommended: 1200x630px for Facebook/Twitter sharing. Leave empty to keep current image.</div>
                                                @error('social_image')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Social Title -->
                                            <div class="form-group mb-3">
                                                <label for="social_title" class="form-label">Social Media Title</label>
                                                <input type="text" class="form-control @error('social_title') is-invalid @enderror" 
                                                       id="social_title" name="social_title" value="{{ old('social_title', $fiBlog->social_title) }}" 
                                                       placeholder="Title for social media sharing">
                                                <div class="form-text">Leave empty to use main title</div>
                                                @error('social_title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Social Description -->
                                            <div class="form-group">
                                                <label for="social_description" class="form-label">Social Media Description</label>
                                                <textarea class="form-control @error('social_description') is-invalid @enderror" 
                                                          id="social_description" name="social_description" rows="2" 
                                                          placeholder="Description for social media sharing">{{ old('social_description', $fiBlog->social_description) }}</textarea>
                                                <div class="form-text">Leave empty to use excerpt or meta description</div>
                                                @error('social_description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sidebar Column -->
                            <div class="col-md-4">
                                <!-- Publishing Options -->
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Publishing</h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Status -->
                                        <div class="form-group mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select @error('status') is-invalid @enderror" 
                                                    id="status" name="status">
                                                <option value="draft" {{ old('status', $fiBlog->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="published" {{ old('status', $fiBlog->status) == 'published' ? 'selected' : '' }}>Published</option>
                                                <option value="scheduled" {{ old('status', $fiBlog->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                                <option value="archived" {{ old('status', $fiBlog->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Scheduled Date (shown when status is scheduled) -->
                                        <div class="form-group mb-3" id="scheduled-date-group" style="{{ old('status', $fiBlog->status) == 'scheduled' ? '' : 'display: none;' }}">
                                            <label for="scheduled_at" class="form-label">Scheduled Date & Time</label>
                                            <input type="datetime-local" class="form-control @error('scheduled_at') is-invalid @enderror" 
                                                   id="scheduled_at" name="scheduled_at" 
                                                   value="{{ old('scheduled_at', $fiBlog->scheduled_at ? $fiBlog->scheduled_at->format('Y-m-d\TH:i') : '') }}">
                                            @error('scheduled_at')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Category -->
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Category</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <select class="form-select @error('fi_category_id') is-invalid @enderror" 
                                                    id="fi_category_id" name="fi_category_id" required>
                                                <option value="">Select Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" 
                                                            {{ old('fi_category_id', $fiBlog->fi_category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('fi_category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Featured Image -->
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Featured Image</h5>
                                    </div>
                                    <div class="card-body">
                                        @if($fiBlog->featured_image_path)
                                            <div class="mb-3">
                                                <img src="{{ asset('storage/app/public/' . $fiBlog->featured_image_path) }}" 
                                                     alt="Current featured image" class="img-fluid rounded mb-2">
                                                <p class="text-muted small">Current featured image</p>
                                            </div>
                                        @endif
                                        
                                        <div class="form-group mb-3">
                                            <input type="file" class="form-control @error('featured_image') is-invalid @enderror" 
                                                   id="featured_image" name="featured_image" accept="image/*">
                                            <div class="form-text">Recommended: 1200x630px, max 5MB. Leave empty to keep current image.</div>
                                            @error('featured_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="featured_image_alt" class="form-label">Alt Text</label>
                                            <input type="text" class="form-control @error('featured_image_alt') is-invalid @enderror" 
                                                   id="featured_image_alt" name="featured_image_alt" 
                                                   value="{{ old('featured_image_alt', $fiBlog->featured_image_alt) }}" 
                                                   placeholder="Describe the image for accessibility">
                                            @error('featured_image_alt')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Tags -->
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Tags</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <input type="text" class="form-control @error('tags') is-invalid @enderror" 
                                                   id="tags" name="tags" 
                                                   value="{{ old('tags', is_array($fiBlog->tags) ? implode(', ', $fiBlog->tags) : '') }}" 
                                                   placeholder="Enter tags separated by commas">
                                            <small class="text-muted">Separate tags with commas</small>
                                            @error('tags')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Content Settings -->
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Settings</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="is_featured" 
                                                   name="is_featured" value="1" {{ old('is_featured', $fiBlog->is_featured) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_featured">
                                                Featured Post
                                            </label>
                                        </div>
                                        
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="is_trending" 
                                                   name="is_trending" value="1" {{ old('is_trending', $fiBlog->is_trending) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_trending">
                                                Trending Post
                                            </label>
                                        </div>
                                        
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="allow_comments" 
                                                   name="allow_comments" value="1" {{ old('allow_comments', $fiBlog->allow_comments) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="allow_comments">
                                                Allow Comments
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.fitinsight.blogs.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <div>
                                <button type="submit" name="action" value="save" class="btn btn-secondary me-2">
                                    <i class="fas fa-save"></i> Save Changes
                                </button>
                                <button type="submit" name="action" value="publish" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Update & Publish
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Quill.js CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<!-- Quill.js JavaScript -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill editor
    var quill = new Quill('#quill-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'font': [] }],
                [{ 'align': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['blockquote', 'code-block'],
                [{ 'script': 'sub'}, { 'script': 'super' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                ['link', 'image', 'video'],
                ['clean']
            ]
        },
        placeholder: 'Write your blog content here...'
    });

    // Sync Quill content with hidden textarea
    var contentTextarea = document.getElementById('content');
    
    // Set initial content
    if (contentTextarea.value) {
        quill.root.innerHTML = contentTextarea.value;
    }
    
    // Update textarea on text change
    quill.on('text-change', function() {
        contentTextarea.value = quill.root.innerHTML;
    });

    // Auto-generate slug from title (only if slug is empty)
    document.getElementById('title').addEventListener('input', function() {
        const slugField = document.getElementById('slug');
        if (!slugField.value || slugField.value === slugField.defaultValue) {
            const title = this.value;
            const slug = title.toLowerCase()
                .replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            slugField.value = slug;
        }
    });

    // Character counters
    document.getElementById('meta_title').addEventListener('input', function() {
        const count = this.value.length;
        const counter = document.getElementById('meta-title-count');
        counter.textContent = count;
        counter.className = count > 50 ? (count > 60 ? 'character-count danger' : 'character-count warning') : 'character-count';
    });

    document.getElementById('meta_description').addEventListener('input', function() {
        const count = this.value.length;
        const counter = document.getElementById('meta-desc-count');
        counter.textContent = count;
        counter.className = count > 140 ? (count > 160 ? 'character-count danger' : 'character-count warning') : 'character-count';
    });

    // Handle image uploads
    quill.getModule('toolbar').addHandler('image', function() {
        const input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        input.click();

        input.onchange = function() {
            const file = input.files[0];
            if (file) {
                const formData = new FormData();
                formData.append('image', file);
                formData.append('_token', '{{ csrf_token() }}');

                // Show loading
                const range = quill.getSelection();
                quill.insertText(range.index, 'Uploading image...');

                fetch('{{ route("admin.fitinsight.blogs.upload-image") }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    // Remove loading text
                    quill.deleteText(range.index, 'Uploading image...'.length);
                    
                    if (data.success) {
                        // Insert image
                        quill.insertEmbed(range.index, 'image', data.url);
                    } else {
                        alert('Failed to upload image: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    // Remove loading text
                    quill.deleteText(range.index, 'Uploading image...'.length);
                    alert('Failed to upload image: ' + error.message);
                });
            }
        };
    });

    // Handle status change
    const statusSelect = document.getElementById('status');
    const scheduledDateGroup = document.getElementById('scheduled-date-group');
    
    function toggleScheduledDate() {
        if (statusSelect.value === 'scheduled') {
            scheduledDateGroup.style.display = 'block';
            document.getElementById('scheduled_at').required = true;
        } else {
            scheduledDateGroup.style.display = 'none';
            document.getElementById('scheduled_at').required = false;
        }
    }
    
    statusSelect.addEventListener('change', toggleScheduledDate);
    toggleScheduledDate(); // Initial check

    // Form submission handling
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        // Ensure content is synced
        contentTextarea.value = quill.root.innerHTML;
        
        // Check if content is empty
        if (quill.getText().trim().length === 0) {
            e.preventDefault();
            alert('Please add some content to your blog post.');
            return false;
        }
    });
});
</script>
@endsection 