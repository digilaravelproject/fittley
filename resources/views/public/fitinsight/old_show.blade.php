@extends('layouts.public')

@section('title', $blog->title . ' - FitInsight')

@push('styles')
<style>
    :root {
        --fittelly-orange: #f7a31a;
        --fittelly-orange-hover: #e8941a;
        --netflix-black: #000;
        --netflix-dark-gray: #141414;
        --netflix-gray: #2f2f2f;
        --netflix-light-gray: #8c8c8c;
        --netflix-white: #ffffff;
    }

    body {
        background-color: var(--netflix-black);
        color: var(--netflix-white);
    }

    /* Article Header */
    .article-header {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.8)),
        url('{{ $blog->featured_image_url ?: "https://images.unsplash.com/photo-1571019613914-85f342c75c29?ixlib=rb-4.0.3" }}') center/cover;
        min-height: 60vh;
        display: flex;
        align-items: center;
        position: relative;
    }

    .article-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(247, 163, 26, 0.1), rgba(0, 0, 0, 0.8));
    }

    .article-header-content {
        position: relative;
        z-index: 2;
    }

    .article-title {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .article-meta {
        display: flex;
        align-items: center;
        gap: 2rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--netflix-light-gray);
        font-size: 0.95rem;
    }

    .meta-item i {
        color: var(--fittelly-orange);
    }

    .article-excerpt {
        font-size: 1.2rem;
        color: var(--netflix-light-gray);
        line-height: 1.6;
        max-width: 800px;
    }

    /* Article Content */
    .article-content {
        padding: 4rem 0;
    }

    .article-body {
        background: var(--netflix-dark-gray);
        border-radius: 16px;
        padding: 3rem;
        margin-bottom: 3rem;
        border: 1px solid #333;
    }

    .article-body h1,
    .article-body h2,
    .article-body h3,
    .article-body h4,
    .article-body h5,
    .article-body h6 {
        color: var(--netflix-white);
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .article-body h1 {
        font-size: 2.5rem;
    }

    .article-body h2 {
        font-size: 2rem;
    }

    .article-body h3 {
        font-size: 1.75rem;
    }

    .article-body h4 {
        font-size: 1.5rem;
    }

    .article-body h5 {
        font-size: 1.25rem;
    }

    .article-body h6 {
        font-size: 1.1rem;
    }

    .article-body p {
        color: var(--netflix-light-gray);
        line-height: 1.8;
        margin-bottom: 1.5rem;
        font-size: 1.1rem;
    }

    .article-body ul,
    .article-body ol {
        color: var(--netflix-light-gray);
        margin-bottom: 1.5rem;
        padding-left: 2rem;
    }

    .article-body li {
        margin-bottom: 0.5rem;
        line-height: 1.6;
    }

    .article-body blockquote {
        border-left: 4px solid var(--fittelly-orange);
        padding-left: 2rem;
        margin: 2rem 0;
        font-style: italic;
        color: var(--netflix-light-gray);
        background: rgba(247, 163, 26, 0.05);
        padding: 1.5rem 2rem;
        border-radius: 8px;
    }

    .article-body img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        margin: 2rem 0;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    .article-body a {
        color: var(--fittelly-orange);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .article-body a:hover {
        color: var(--fittelly-orange-hover);
        text-decoration: underline;
    }

    /* Article Actions */
    .article-actions {
        display: flex;
        gap: 1rem;
        margin-bottom: 3rem;
        flex-wrap: wrap;
    }

    .action-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .action-btn-like {
        background: var(--netflix-gray);
        color: var(--netflix-white);
    }

    .action-btn-like:hover {
        background: #e74c3c;
        color: white;
        transform: translateY(-2px);
    }

    .action-btn-share {
        background: var(--fittelly-orange);
        color: var(--netflix-black);
    }

    .action-btn-share:hover {
        background: var(--fittelly-orange-hover);
        color: var(--netflix-black);
        transform: translateY(-2px);
    }

    /* Related Articles */
    .related-section {
        margin-bottom: 3rem;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 2rem;
        color: var(--netflix-white);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .section-title i {
        color: var(--fittelly-orange);
    }

    .related-card {
        background: var(--netflix-dark-gray);
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        cursor: pointer;
        height: 100%;
        border: 1px solid #333;
    }

    .related-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.8);
    }

    .related-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .related-card-content {
        padding: 1.5rem;
    }

    .related-card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--netflix-white);
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .related-card-meta {
        color: var(--netflix-light-gray);
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    /* Author Section */
    .author-section {
        background: var(--netflix-dark-gray);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 3rem;
        border: 1px solid #333;
    }

    .author-info {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .author-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--fittelly-orange), var(--fittelly-orange-hover));
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--netflix-black);
        font-size: 2rem;
        font-weight: 700;
    }

    .author-details h4 {
        color: var(--netflix-white);
        margin-bottom: 0.5rem;
        font-size: 1.3rem;
    }

    .author-details p {
        color: var(--netflix-light-gray);
        margin: 0;
        line-height: 1.5;
    }

    /* Sidebar */
    .sidebar-card {
        background: var(--netflix-dark-gray);
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 2rem;
        border: 1px solid #333;
    }

    .sidebar-card .card-header {
        background: var(--fittelly-orange);
        color: var(--netflix-black);
        font-weight: 600;
        padding: 1rem 1.5rem;
    }

    .sidebar-card .card-body {
        padding: 1.5rem;
    }

    .sidebar-item {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #333;
    }

    .sidebar-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .sidebar-item img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
    }

    .sidebar-item-content h6 {
        color: var(--netflix-white);
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
        line-height: 1.3;
    }

    .sidebar-item-content small {
        color: var(--netflix-light-gray);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .article-title {
            font-size: 2.5rem;
        }

        .article-meta {
            gap: 1rem;
        }

        .article-body {
            padding: 2rem;
        }

        .author-info {
            flex-direction: column;
            text-align: center;
        }

        .article-actions {
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<!-- Article Header -->
<section class="article-header">
    <div class="container">
        <div class="article-header-content">
            <h1 class="article-title">{{ $blog->title }}</h1>

            <div class="article-meta">
                <div class="meta-item">
                    <i class="fas fa-user"></i>
                    <span>{{ $blog->author ? $blog->author->name : 'Admin' }}</span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-calendar"></i>
                    <span>{{ $blog->published_at_formatted }}</span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-eye"></i>
                    <span>{{ number_format($blog->views_count) }} views</span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-clock"></i>
                    <span>{{ $blog->reading_time ?? 5 }} min read</span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-tag"></i>
                    <span>{{ $blog->category ? $blog->category->name : 'General' }}</span>
                </div>
            </div>

            @if($blog->excerpt)
            <p class="article-excerpt">{{ $blog->excerpt }}</p>
            @endif
        </div>
    </div>
</section>

<!-- Article Content -->
<section class="article-content">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Article Body -->
                <div class="article-body">
                    {!! $blog->content !!}
                </div>

                <!-- Article Actions -->
                <div class="article-actions">
                    <button class="action-btn action-btn-like" onclick="likeBlog({{ $blog->id }})">
                        <i class="fas fa-heart"></i>
                        <span>Like ({{ $blog->likes_count }})</span>
                    </button>
                    <button class="action-btn action-btn-share" onclick="shareBlog({{ $blog->id }})">
                        <i class="fas fa-share"></i>
                        <span>Share ({{ $blog->shares_count }})</span>
                    </button>
                </div>

                <!-- Author Section -->
                @if($blog->author)
                <div class="author-section">
                    <h3 class="section-title">
                        <i class="fas fa-user"></i>
                        About the Author
                    </h3>
                    <div class="author-info">
                        <div class="author-avatar">
                            {{ substr($blog->author->name, 0, 1) }}
                        </div>
                        <div class="author-details">
                            <h4>{{ $blog->author->name }}</h4>
                            <p>Fitness expert and wellness advocate with years of experience in helping people achieve
                                their health goals.</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Related Articles -->
                @if($relatedBlogs->count() > 0)
                <div class="related-section">
                    <h3 class="section-title">
                        <i class="fas fa-newspaper"></i>
                        Related Articles
                    </h3>
                    <div class="row">
                        @foreach($relatedBlogs as $related)
                        <div class="col-md-6 mb-4">
                            <div class="related-card"
                                onclick="window.location.href='{{ route('fitinsight.show', $related) }}'">
                                @if($related->featured_image_path)
                                <img src="{{ $related->featured_image_url }}" alt="{{ $related->title }}">
                                @else
                                <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3"
                                    alt="{{ $related->title }}">
                                @endif
                                <div class="related-card-content">
                                    <h5 class="related-card-title">{{ $related->title }}</h5>
                                    <div class="related-card-meta">
                                        <span><i class="fas fa-eye"></i> {{ number_format($related->views_count)
                                            }}</span>
                                        <span><i class="fas fa-calendar"></i> {{ $related->published_at_formatted
                                            }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Author's Other Articles -->
                @if($authorBlogs->count() > 0)
                <div class="sidebar-card">
                    <div class="card-header">
                        <i class="fas fa-user-edit me-2"></i>More from {{ $blog->author ? $blog->author->name : 'Author'
                        }}
                    </div>
                    <div class="card-body">
                        @foreach($authorBlogs as $authorBlog)
                        <div class="sidebar-item"
                            onclick="window.location.href='{{ route('fitinsight.show', $authorBlog) }}'">
                            @if($authorBlog->featured_image_path)
                            <img src="{{ $authorBlog->featured_image_url }}" alt="{{ $authorBlog->title }}">
                            @else
                            <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3"
                                alt="{{ $authorBlog->title }}">
                            @endif
                            <div class="sidebar-item-content">
                                <h6>{{ Str::limit($authorBlog->title, 60) }}</h6>
                                <small>{{ $authorBlog->published_at_formatted }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Categories -->
                @if($categories->count() > 0)
                <div class="sidebar-card">
                    <div class="card-header">
                        <i class="fas fa-folder me-2"></i>Categories
                    </div>
                    <div class="card-body">
                        @foreach($categories as $category)
                        <a href="{{ route('fitinsight.category', $category) }}"
                            class="d-block text-decoration-none mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-light">{{ $category->name }}</span>
                                <span class="badge bg-secondary">{{ $category->published_blogs_count }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Newsletter -->
                <div class="sidebar-card">
                    <div class="card-header">
                        <i class="fas fa-envelope me-2"></i>Stay Updated
                    </div>
                    <div class="card-body">
                        <p class="text-light mb-3">Get the latest fitness insights delivered to your inbox.</p>
                        <form>
                            <div class="mb-3">
                                <input type="email" class="form-control" placeholder="Your email address"
                                    style="background: var(--netflix-gray); border: 1px solid #333; color: var(--netflix-white);">
                            </div>
                            <button type="submit" class="btn btn-primary w-100"
                                style="background: var(--fittelly-orange); border: none; color: var(--netflix-black);">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    function likeBlog(blogId) {
    fetch(`/fitinsight/${blogId}/like`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update like count
            const likeBtn = document.querySelector('.action-btn-like span');
            likeBtn.textContent = `Like (${data.likes_count})`;

            // Show success message
            showNotification('Blog liked successfully!', 'success');
        } else {
            showNotification(data.message || 'Failed to like blog', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
}

function shareBlog(blogId) {
    if (navigator.share) {
        navigator.share({
            title: document.title,
            url: window.location.href
        }).then(() => {
            // Increment share count
            fetch(`/fitinsight/${blogId}/share`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            });
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(window.location.href).then(() => {
            showNotification('Link copied to clipboard!', 'success');

            // Increment share count
            fetch(`/fitinsight/${blogId}/share`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            });
        });
    }
}

function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.textContent = message;

    document.body.appendChild(notification);

    // Remove after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>
@endpush