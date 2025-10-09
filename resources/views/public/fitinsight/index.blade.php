@extends('layouts.public')

@section('title', 'FitInsight - Fitness Blog')

@push('styles')
<link rel="stylesheet" href="{{ asset('public/assets/home/css/fitinsight.css') }}?v={{ time() }}">
@endpush

@section('content')
<div class="fitinsight-page">

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>FitInsight</h1>
            <p>Get the latest articles on health, fitness, nutrition, workouts, and wellness.</p>
            <div class="hero-search">
                <input type="text" id="search-input" placeholder="Search articles..." value="{{ request('search') }}">
                <i class="fas fa-search search-icon"></i>
            </div>
        </div>
    </section>

    <!-- Categories -->
    @if ($categories->count() > 0)
    <section class="categories-section">
        <div class="categories-wrapper">
            <a href="{{ route('fitinsight.index') }}" class="cat-btn {{ !request('category') ? 'active' : '' }}">All</a>
            @foreach ($categories as $category)
            <a href="{{ route('fitinsight.category', $category) }}"
                class="cat-btn {{ request('category') == $category->id ? 'active' : '' }}">
                @if ($category->icon) <i class="{{ $category->icon }} me-1"></i> @endif
                {{ $category->name }}
            </a>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Main Content -->
    <section class="content-section">
        <div class="container">
            <div class="row">
                <!-- Articles Column -->
                <div class="col-lg-8 col-md-12" id="articles-wrapper">
                    @if ($blogs->count() > 0)
                    <div class="row">
                        @foreach ($blogs as $blog)
                        <div class="col-md-6 mb-4">
                            <div class="content-card" onclick="window.location='{{ route('fitinsight.show', $blog) }}'">
                                <img src="{{ $blog->featured_image_url ?? 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b' }}"
                                    alt="{{ $blog->title }}" class="card-image">
                                <div class="type-badge">{{ $blog->category->name }}</div>
                                <div class="card-content">
                                    <h3 class="card-title">{{ $blog->title }}</h3>
                                    <div class="card-meta">
                                        <span><i class="fas fa-eye"></i> {{ number_format($blog->views_count) }}</span>
                                        <span><i class="fas fa-heart"></i> {{ number_format($blog->likes_count)
                                            }}</span>
                                    </div>
                                    <p class="card-description">{{ $blog->excerpt_or_content }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="pagination-wrapper mt-4">
                        {{ $blogs->links() }}
                    </div>
                    @else
                    <div class="no-articles">
                        <h4>No articles found</h4>
                        <p>Try searching with different keywords or check back later.</p>
                    </div>
                    @endif
                </div>

                <!-- Sidebar Column -->
                <div class="col-lg-4 col-md-12">
                    @if ($featuredBlogs->count() > 0)
                    <div class="sidebar-card">
                        <div class="card-header">Featured Articles</div>
                        <div class="card-body">
                            @foreach ($featuredBlogs as $feat)
                            <div class="sidebar-item">
                                <img src="{{ $feat->featured_image_url }}" alt="{{ $feat->title }}"
                                    class="sidebar-thumb">
                                <div>
                                    <a href="{{ route('fitinsight.show', $feat) }}">{{ Str::limit($feat->title, 50)
                                        }}</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if ($trendingBlogs->count() > 0)
                    <div class="sidebar-card">
                        <div class="card-header">Trending Now</div>
                        <div class="card-body">
                            @foreach ($trendingBlogs as $trend)
                            <div class="sidebar-item">
                                <img src="{{ $trend->featured_image_url }}" alt="{{ $trend->title }}"
                                    class="sidebar-thumb">
                                <div>
                                    <a href="{{ route('fitinsight.show', $trend) }}">{{ Str::limit($trend->title, 50)
                                        }}</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="newsletter-card">
                        <h5>Subscribe</h5>
                        <p>Stay updated with new articles delivered to your inbox.</p>
                        <form id="newsletter-form">
                            <input type="email" placeholder="Your email address" required>
                            <button type="submit">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');

        searchInput.addEventListener('input', function(e) {
            const q = e.target.value.trim();
            // If you want debounce so not every keystroke triggers heavy load
            clearTimeout(this._timeout);
            this._timeout = setTimeout(() => {
                const url = new URL(window.location.href);
                if (q) url.searchParams.set('search', q);
                else url.searchParams.delete('search');
                // optionally also reset page number
                url.searchParams.delete('page');
                window.history.replaceState({}, '', url.toString());
                // fetch via AJAX
                fetch(url.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.text())
                .then(html => {
                    // parse returned HTML and replace articles part
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newArticles = doc.getElementById('articles-wrapper');
                    if (newArticles) {
                        document.getElementById('articles-wrapper').innerHTML = newArticles.innerHTML;
                    }
                })
                .catch(err => console.error(err));
            }, 500); // wait 500ms after user stops typing
        });
    });
</script>
@endpush