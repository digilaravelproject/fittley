@extends('layouts.admin')

@section('title', 'Show Community Post')

@section('content')
<style>
  .fitarena_status{
    color: #000;
  }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="page-header mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="page-title">
                            <i class="fas fa-plus text-primary me-2"></i>
                            Show Community Post
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

                                <!-- Title -->
                                <div class="mb-3">
                                    <label for="title" class="form-label fitarena_status">Title <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title', $post->content) }}"
                                           placeholder="Enter post title"
                                           required>
                                </div>

                                <!-- Category -->
                                <div class="mb-3">
                                    <label for="community_category_id" class="form-label fitarena_status">Category <span class="text-danger">*</span></label>
                                    <select class="form-select @error('community_category_id') is-invalid @enderror" 
                                            id="community_category_id" 
                                            name="community_category_id" 
                                            >
                                        <option value="">Select a category</option>
                                        @if(isset($categories))
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" 
                                                 {{ old('community_category_id', $post->community_category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <!-- Content -->
                                <div class="mb-3">
                                    <label for="content" class="form-label fitarena_status">Content <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('content') is-invalid @enderror" 
                                              id="content" 
                                              name="content" 
                                              rows="8" 
                                              placeholder="Write your post content here..."
                                              >{{ $post->content }}</textarea>
                                </div>

                                <!-- Submit Buttons -->
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.community.posts.index') }}" class="btn btn-outline-secondary fitarena_status">
                                        <i class="fas fa-times me-1"></i> Cancel
                                    </a>
                                </div>
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
                                    <input class="form-check-input" type="radio" name="status" id="status_draft" value="draft"
                                        {{ old('status', $post->is_published ? 'published' : 'draft') == 'draft' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_draft">
                                        <i class="fas fa-edit text-warning me-1"></i> Draft
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status_published" value="published"
                                        {{ old('status', $post->is_published ? 'published' : 'draft') == 'published' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_published">
                                        <i class="fas fa-eye text-success me-1"></i> Published
                                    </label>
                                </div>
                            </div>

                            <!-- Featured -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1"
                                        {{ old('is_featured', $post->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        <i class="fas fa-star text-warning me-1"></i> Featured Post
                                    </label>
                                </div>
                                <div class="form-text">Featured posts appear prominently in the community</div>
                            </div>

                            <!-- Allow Comments -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="allow_comments" name="allow_comments" value="1"
                                        {{ old('allow_comments', $post->comments_count >= 0 ? 1 : 0) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="allow_comments">
                                        <i class="fas fa-comments text-info me-1"></i> Allow Comments
                                    </label>
                                </div>
                            </div>

                            <!-- Pinned -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_pinned" name="is_pinned" value="1"
                                        {{ old('is_pinned', $post->is_pinned ?? 0) ? 'checked' : '' }}>
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

