@extends('layouts.admin')

@section('title', $fiBlog->title)

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.fitinsight.blogs.index') }}">Blogs</a></li>
                    <li class="breadcrumb-item active">{{ Str::limit($fiBlog->title, 50) }}</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0">{{ $fiBlog->title }}</h1>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.fitinsight.blogs.edit', $fiBlog) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>Edit Blog
            </a>
            <a href="{{ route('fitinsight.show', $fiBlog->slug) }}" target="_blank" class="btn btn-outline-primary">
                <i class="fas fa-external-link-alt me-2"></i>View on Site
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <!-- Featured Image -->
                    @if($fiBlog->featured_image_url)
                        <div class="mb-4">
                            <img src="{{ $fiBlog->featured_image_url }}" 
                                 alt="{{ $fiBlog->featured_image_alt ?? $fiBlog->title }}"
                                 class="img-fluid rounded">
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="blog-content">
                        {!! $fiBlog->content !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Blog Status</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-center">
                                <div class="h3 mb-1">
                                    @switch($fiBlog->status)
                                        @case('published')
                                            <span class="badge bg-success">Published</span>
                                            @break
                                        @case('draft')
                                            <span class="badge bg-secondary">Draft</span>
                                            @break
                                        @case('scheduled')
                                            <span class="badge bg-info">Scheduled</span>
                                            @break
                                        @case('archived')
                                            <span class="badge bg-dark">Archived</span>
                                            @break
                                    @endswitch
                                </div>
                                <small class="text-muted">Status</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <div class="h3 mb-1 text-primary">{{ number_format($fiBlog->views_count) }}</div>
                                <small class="text-muted">Views</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Details</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td><strong>Category:</strong></td>
                            <td>{{ $fiBlog->category->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Author:</strong></td>
                            <td>{{ $fiBlog->author->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Created:</strong></td>
                            <td>{{ $fiBlog->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                        @if($fiBlog->published_at)
                            <tr>
                                <td><strong>Published:</strong></td>
                                <td>{{ $fiBlog->published_at->format('M d, Y H:i') }}</td>
                            </tr>
                        @endif
                        @if($fiBlog->scheduled_at)
                            <tr>
                                <td><strong>Scheduled:</strong></td>
                                <td>{{ $fiBlog->scheduled_at->format('M d, Y H:i') }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td><strong>Reading Time:</strong></td>
                            <td>{{ $fiBlog->reading_time }} min</td>
                        </tr>
                        <tr>
                            <td><strong>Likes:</strong></td>
                            <td>{{ number_format($fiBlog->likes_count) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Shares:</strong></td>
                            <td>{{ number_format($fiBlog->shares_count) }}</td>
                        </tr>
                    </table>

                    <!-- Flags -->
                    <div class="mt-3">
                        @if($fiBlog->is_featured)
                            <span class="badge bg-warning text-dark me-1">Featured</span>
                        @endif
                        @if($fiBlog->is_trending)
                            <span class="badge bg-danger me-1">Trending</span>
                        @endif
                        @if($fiBlog->allow_comments)
                            <span class="badge bg-info me-1">Comments Enabled</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- SEO Card -->
            @if($fiBlog->meta_title || $fiBlog->meta_description)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">SEO Information</h5>
                    </div>
                    <div class="card-body">
                        @if($fiBlog->meta_title)
                            <div class="mb-3">
                                <strong>Meta Title:</strong>
                                <p class="mb-0 text-muted">{{ $fiBlog->meta_title }}</p>
                            </div>
                        @endif
                        @if($fiBlog->meta_description)
                            <div class="mb-3">
                                <strong>Meta Description:</strong>
                                <p class="mb-0 text-muted">{{ $fiBlog->meta_description }}</p>
                            </div>
                        @endif
                        @if($fiBlog->meta_keywords)
                            <div class="mb-3">
                                <strong>Keywords:</strong>
                                <p class="mb-0 text-muted">{{ $fiBlog->meta_keywords }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Tags -->
            @if($fiBlog->tags && count($fiBlog->tags) > 0)
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Tags</h5>
                    </div>
                    <div class="card-body">
                        @foreach($fiBlog->tags as $tag)
                            <span class="badge bg-secondary me-1 mb-1">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.blog-content {
    font-size: 1.1rem;
    line-height: 1.7;
}

.blog-content h2, .blog-content h3, .blog-content h4 {
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.blog-content p {
    margin-bottom: 1.5rem;
}

.blog-content img {
    max-width: 100%;
    height: auto;
    border-radius: 0.375rem;
    margin: 1rem 0;
}

.blog-content blockquote {
    border-left: 4px solid #0d6efd;
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.375rem;
}

.blog-content ul, .blog-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.blog-content li {
    margin-bottom: 0.5rem;
}
</style>
@endpush 