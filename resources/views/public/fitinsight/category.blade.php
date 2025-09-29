@extends('layouts.public')

@section('title', $category->name . ' - FitInsight')

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

    /* Category Header */
    .category-header {
        background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8)), 
                    url('{{ $category->banner_image_url ?: "https://images.unsplash.com/photo-1571019613914-85f342c75c29?ixlib=rb-4.0.3" }}') center/cover;
        min-height: 50vh;
        display: flex;
        align-items: center;
        position: relative;
    }

    .category-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(247, 163, 26, 0.1), rgba(0,0,0,0.8));
    }

    .category-header-content {
        position: relative;
        z-index: 2;
    }

    .category-title {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .category-description {
        font-size: 1.2rem;
        color: var(--netflix-light-gray);
        line-height: 1.6;
        max-width: 600px;
        margin-bottom: 1rem;
    }

    .category-stats {
        display: flex;
        align-items: center;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--netflix-light-gray);
        font-size: 0.95rem;
    }

    .stat-item i {
        color: var(--fittelly-orange);
    }

    /* Content Section */
    .content-section {
        padding: 4rem 0;
    }

    /* Article Cards */
    .content-card {
        background: var(--netflix-dark-gray);
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        height: 400px;
        margin-bottom: 2rem;
        border: 1px solid #333;
    }

    .content-card:hover {
        transform: scale(1.05);
        z-index: 10;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.8);
    }

    .card-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .content-card:hover .card-image {
        transform: scale(1.1);
    }

    .card-content {
        padding: 1.5rem;
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(20, 20, 20, 0.95));
    }

    .card-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--netflix-white);
        margin-bottom: 0.5rem;
    }

    .card-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        color: var(--netflix-light-gray);
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .card-description {
        color: var(--netflix-light-gray);
        font-size: 0.85rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .type-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: var(--fittelly-orange);
        color: var(--netflix-black);
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
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

    /* Filter and Sort */
    .filter-section {
        background: var(--netflix-dark-gray);
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 3rem;
        border: 1px solid #333;
    }

    .filter-row {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filter-group label {
        color: var(--netflix-white);
        font-weight: 500;
        font-size: 0.9rem;
    }

    .filter-group select,
    .filter-group input {
        background: var(--netflix-gray);
        border: 1px solid #333;
        color: var(--netflix-white);
        border-radius: 8px;
        padding: 0.5rem 1rem;
        min-width: 150px;
    }

    .filter-group select:focus,
    .filter-group input:focus {
        outline: none;
        border-color: var(--fittelly-orange);
        box-shadow: 0 0 0 2px rgba(247, 163, 26, 0.2);
    }

    /* Pagination */
    .pagination {
        --bs-pagination-bg: var(--netflix-dark-gray);
        --bs-pagination-border-color: #333;
        --bs-pagination-color: var(--netflix-white);
        --bs-pagination-hover-bg: #333;
        --bs-pagination-hover-color: #fff;
        --bs-pagination-active-bg: var(--fittelly-orange);
        --bs-pagination-active-border-color: var(--fittelly-orange);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--netflix-dark-gray);
        border-radius: 12px;
        border: 1px solid #333;
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--netflix-light-gray);
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        color: var(--netflix-white);
        margin-bottom: 1rem;
    }

    .empty-state p {
        color: var(--netflix-light-gray);
        margin-bottom: 2rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .category-title {
            font-size: 2.5rem;
        }
        
        .category-stats {
            gap: 1rem;
        }
        
        .filter-row {
            flex-direction: column;
            align-items: stretch;
        }
        
        .filter-group {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<!-- Category Header -->
<section class="category-header">
    <div class="container">
        <div class="category-header-content">
            <h1 class="category-title">{{ $category->name }}</h1>
            
            @if($category->description)
                <p class="category-description">{{ $category->description }}</p>
            @endif
            
            <div class="category-stats">
                <div class="stat-item">
                    <i class="fas fa-newspaper"></i>
                    <span>{{ $blogs->total() }} articles</span>
                </div>
                <div class="stat-item">
                    <i class="fas fa-eye"></i>
                    <span>{{ number_format($blogs->sum('views_count')) }} total views</span>
                </div>
                <div class="stat-item">
                    <i class="fas fa-heart"></i>
                    <span>{{ number_format($blogs->sum('likes_count')) }} total likes</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="content-section">
    <div class="container">
        <div class="row">
            <!-- Articles -->
            <div class="col-lg-8">
                <!-- Filter and Sort -->
                <div class="filter-section">
                    <form method="GET" class="filter-row">
                        <div class="filter-group">
                            <label for="search">Search</label>
                            <input type="text" name="search" id="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Search articles...">
                        </div>
                        
                        <div class="filter-group">
                            <label for="sort">Sort by</label>
                            <select name="sort" id="sort">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary" style="background: var(--fittelly-orange); border: none; color: var(--netflix-black);">
                                <i class="fas fa-search"></i> Filter
                            </button>
                        </div>
                        
                        @if(request()->hasAny(['search', 'sort']))
                            <div class="filter-group">
                                <label>&nbsp;</label>
                                <a href="{{ route('fitinsight.category', $category) }}" class="btn btn-outline-secondary" style="border-color: #333; color: var(--netflix-white);">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            </div>
                        @endif
                    </form>
                </div>

                <!-- Articles Grid -->
                @if($blogs->count() > 0)
                    <div class="row">
                        @foreach($blogs as $blog)
                            <div class="col-lg-6 mb-4">
                                <div class="content-card" onclick="window.location.href='{{ route('fitinsight.show', $blog) }}'">
                                    @if($blog->featured_image_path)
                                        <img src="{{ $blog->featured_image_url }}" class="card-image" 
                                             alt="{{ $blog->featured_image_alt ?: $blog->title }}">
                                    @else
                                        <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3" class="card-image" 
                                             alt="{{ $blog->title }}">
                                    @endif
                                    <div class="type-badge">{{ $category->name }}</div>
                                    <div class="card-content">
                                        <h3 class="card-title">{{ $blog->title }}</h3>
                                        <div class="card-meta">
                                            <span><i class="fas fa-eye"></i> {{ number_format($blog->views_count) }}</span>
                                            <span><i class="fas fa-heart"></i> {{ number_format($blog->likes_count) }}</span>
                                            <span><i class="fas fa-share"></i> {{ number_format($blog->shares_count) }}</span>
                                        </div>
                                        <p class="card-description">{{ $blog->excerpt_or_content }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $blogs->appends(request()->query())->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="empty-state">
                        <i class="fas fa-newspaper"></i>
                        <h3>No articles found</h3>
                        <p>There are no articles in this category yet, or no articles match your search criteria.</p>
                        <a href="{{ route('fitinsight.index') }}" class="btn btn-primary" style="background: var(--fittelly-orange); border: none; color: var(--netflix-black);">
                            <i class="fas fa-arrow-left"></i> Back to All Articles
                        </a>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Featured Articles from this Category -->
                @if($featuredBlogs->count() > 0)
                <div class="sidebar-card">
                    <div class="card-header">
                        <i class="fas fa-star me-2"></i>Featured in {{ $category->name }}
                    </div>
                    <div class="card-body">
                        @foreach($featuredBlogs as $featured)
                            <div class="sidebar-item" onclick="window.location.href='{{ route('fitinsight.show', $featured) }}'">
                                @if($featured->featured_image_path)
                                    <img src="{{ $featured->featured_image_url }}" alt="{{ $featured->title }}">
                                @else
                                    <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3" alt="{{ $featured->title }}">
                                @endif
                                <div class="sidebar-item-content">
                                    <h6>{{ Str::limit($featured->title, 50) }}</h6>
                                    <small>{{ $featured->published_at_formatted }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- All Categories -->
                @if($categories->count() > 0)
                <div class="sidebar-card">
                    <div class="card-header">
                        <i class="fas fa-folder me-2"></i>All Categories
                    </div>
                    <div class="card-body">
                        @foreach($categories as $cat)
                            <a href="{{ route('fitinsight.category', $cat) }}" 
                               class="d-block text-decoration-none mb-2 {{ $cat->id == $category->id ? 'text-warning' : 'text-light' }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>{{ $cat->name }}</span>
                                    <span class="badge bg-secondary">{{ $cat->published_blogs_count }}</span>
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
                        <p class="text-light mb-3">Get the latest {{ $category->name }} articles delivered to your inbox.</p>
                        <form>
                            <div class="mb-3">
                                <input type="email" class="form-control" placeholder="Your email address" 
                                       style="background: var(--netflix-gray); border: 1px solid #333; color: var(--netflix-white);">
                            </div>
                            <button type="submit" class="btn btn-primary w-100" 
                                    style="background: var(--fittelly-orange); border: none; color: var(--netflix-black);">
                                Subscribe
                            </button>
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
// Auto-submit form on sort change
document.getElementById('sort').addEventListener('change', function() {
    this.form.submit();
});

// Search form enhancement
document.getElementById('search').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        this.form.submit();
    }
});
</script>
@endpush
