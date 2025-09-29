@extends('layouts.public')

@section('title', 'FitInsight - Fitness Blog')

@section('content')
<div class="container-fluid bg-dark text-white">
    <!-- Hero Section -->
    <div class="hero-section py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">FitInsight</h1>
                    <p class="lead mb-4">Discover expert fitness tips, nutrition guides, and wellness insights to transform your health journey.</p>
                    
                    <!-- Search Bar -->
                    <form method="GET" class="d-flex mb-4">
                        <input type="text" name="search" class="form-control form-control-lg me-2" 
                               placeholder="Search articles..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fas fa-blog fa-8x text-primary opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    @if($categories->count() > 0)
    <div class="categories-section py-4 bg-secondary">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="mb-3">Browse by Category</h5>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('fitinsight.index') }}" 
                           class="btn {{ !request('category') ? 'btn-primary' : 'btn-outline-light' }} btn-sm">
                            All Articles
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('fitinsight.category', $category) }}" 
                               class="btn {{ request('category') == $category->id ? 'btn-primary' : 'btn-outline-light' }} btn-sm">
                                @if($category->icon)
                                    <i class="{{ $category->icon }} me-1"></i>
                                @endif
                                {{ $category->name }}
                                <span class="badge bg-light text-dark ms-1">{{ $category->published_blogs_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <div class="main-content py-5">
        <div class="container">
            <div class="row">
                <!-- Articles -->
                <div class="col-lg-8">
                    @if(request('search'))
                        <div class="mb-4">
                            <h4>Search Results for "{{ request('search') }}"</h4>
                            <p class="text-muted">{{ $blogs->total() }} articles found</p>
                        </div>
                    @endif

                    @if($blogs->count() > 0)
                        <div class="row">
                            @foreach($blogs as $blog)
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card bg-secondary border-0 h-100">
                                        @if($blog->featured_image_path)
                                            <img src="{{ $blog->featured_image_url }}" class="card-img-top" 
                                                 alt="{{ $blog->featured_image_alt ?: $blog->title }}"
                                                 style="height: 200px; object-fit: cover;">
                                        @endif
                                        
                                        <div class="card-body d-flex flex-column">
                                            <div class="mb-2">
                                                <span class="badge bg-primary">{{ $blog->category->name }}</span>
                                                @if($blog->is_featured)
                                                    <span class="badge bg-warning">Featured</span>
                                                @endif
                                                @if($blog->is_trending)
                                                    <span class="badge bg-danger">Trending</span>
                                                @endif
                                            </div>
                                            
                                            <h5 class="card-title">
                                                <a href="{{ route('fitinsight.show', $blog) }}" class="text-white text-decoration-none">
                                                    {{ $blog->title }}
                                                </a>
                                            </h5>
                                            
                                            <p class="card-text text-muted flex-grow-1">
                                                {{ $blog->excerpt_or_content }}
                                            </p>
                                            
                                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $blog->author->avatar ?? 'https://via.placeholder.com/32' }}" 
                                                         alt="{{ $blog->author->name }}" class="rounded-circle me-2" 
                                                         style="width: 32px; height: 32px;">
                                                    <small class="text-muted">{{ $blog->author->name }}</small>
                                                </div>
                                                <div class="text-end">
                                                    <small class="text-muted d-block">{{ $blog->published_at_formatted }}</small>
                                                    @if($blog->reading_time_formatted)
                                                        <small class="text-muted">{{ $blog->reading_time_formatted }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <div class="d-flex gap-3">
                                                    <small class="text-muted">
                                                        <i class="fas fa-eye me-1"></i>{{ number_format($blog->views_count) }}
                                                    </small>
                                                    <small class="text-muted">
                                                        <i class="fas fa-heart me-1"></i>{{ number_format($blog->likes_count) }}
                                                    </small>
                                                    <small class="text-muted">
                                                        <i class="fas fa-share me-1"></i>{{ number_format($blog->shares_count) }}
                                                    </small>
                                                </div>
                                                <a href="{{ route('fitinsight.show', $blog) }}" class="btn btn-outline-primary btn-sm">
                                                    Read More
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $blogs->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No articles found</h4>
                            <p class="text-muted">
                                @if(request('search'))
                                    Try adjusting your search terms or browse our categories.
                                @else
                                    Check back soon for new fitness insights and tips.
                                @endif
                            </p>
                            @if(request('search'))
                                <a href="{{ route('fitinsight.index') }}" class="btn btn-primary">
                                    View All Articles
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Featured Articles -->
                    @if($featuredBlogs->count() > 0)
                        <div class="card bg-secondary border-0 mb-4">
                            <div class="card-header bg-primary">
                                <h6 class="mb-0 text-white">
                                    <i class="fas fa-star me-2"></i>Featured Articles
                                </h6>
                            </div>
                            <div class="card-body">
                                @foreach($featuredBlogs as $featured)
                                    <div class="d-flex mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                                        @if($featured->featured_image_path)
                                            <img src="{{ $featured->featured_image_url }}" alt="{{ $featured->title }}" 
                                                 class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                        @endif
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">
                                                <a href="{{ route('fitinsight.show', $featured) }}" class="text-white text-decoration-none">
                                                    {{ Str::limit($featured->title, 50) }}
                                                </a>
                                            </h6>
                                            <small class="text-muted">{{ $featured->published_at_formatted }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Trending Articles -->
                    @if($trendingBlogs->count() > 0)
                        <div class="card bg-secondary border-0 mb-4">
                            <div class="card-header bg-danger">
                                <h6 class="mb-0 text-white">
                                    <i class="fas fa-fire me-2"></i>Trending Now
                                </h6>
                            </div>
                            <div class="card-body">
                                @foreach($trendingBlogs as $trending)
                                    <div class="d-flex mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                                        @if($trending->featured_image_path)
                                            <img src="{{ $trending->featured_image_url }}" alt="{{ $trending->title }}" 
                                                 class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                        @endif
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">
                                                <a href="{{ route('fitinsight.show', $trending) }}" class="text-white text-decoration-none">
                                                    {{ Str::limit($trending->title, 50) }}
                                                </a>
                                            </h6>
                                            <div class="d-flex justify-content-between">
                                                <small class="text-muted">{{ $trending->published_at_formatted }}</small>
                                                <small class="text-muted">
                                                    <i class="fas fa-eye me-1"></i>{{ number_format($trending->views_count) }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Newsletter Signup -->
                    <div class="card bg-primary border-0 mb-4">
                        <div class="card-body text-center">
                            <i class="fas fa-envelope fa-2x mb-3"></i>
                            <h6 class="text-white mb-3">Stay Updated</h6>
                            <p class="text-white-50 mb-3">Get the latest fitness insights delivered to your inbox.</p>
                            <form>
                                <div class="mb-3">
                                    <input type="email" class="form-control" placeholder="Your email address">
                                </div>
                                <button type="submit" class="btn btn-light btn-sm w-100">Subscribe</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hero-section {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
}

.categories-section {
    border-top: 1px solid #444;
    border-bottom: 1px solid #444;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-5px);
}

.badge {
    font-size: 0.75rem;
}

.pagination {
    --bs-pagination-bg: #2d2d2d;
    --bs-pagination-border-color: #444;
    --bs-pagination-color: #fff;
    --bs-pagination-hover-bg: #444;
    --bs-pagination-hover-color: #fff;
    --bs-pagination-active-bg: #f7a31a;
    --bs-pagination-active-border-color: #f7a31a;
}
</style>
@endsection 