@extends('layouts.public')

@section('title', $category->name . ' - FitInsight')

@push('styles')
<style>
    :root {
        --primary-color: #f7a31a;
        --dark-bg: #121212;
        --dark-card-bg: #1e1e1e;
        --light-text: #e0e0e0;
        --muted-text: #a0a0a0;
        --hover-shadow: 0 10px 30px rgba(247, 163, 26, 0.3);
    }

    body {
        background-color: var(--dark-bg);
        color: var(--light-text);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    a {
        color: var(--primary-color);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    a:hover {
        color: #e8941a;
        text-decoration: underline;
    }

    /* Hero Section */
    .hero {
        background: linear-gradient(rgba(18, 18, 18, 0.7), rgba(18, 18, 18, 0.9)),
        url('{{ $category->banner_image_url ?: "https://images.unsplash.com/photo-1571019613914-85f342c75c29?ixlib=rb-4.0.3" }}') center center/cover no-repeat;
        min-height: 40vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        text-align: center;
        border-radius: 12px;
        margin-bottom: 3rem;
    }

    .hero h1 {
        font-size: 2.8rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        color: #fff;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
    }

    .hero p {
        font-size: 1.2rem;
        max-width: 700px;
        margin: 0 auto;
        color: #ddd;
        line-height: 1.6;
        text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.6);
    }

    /* Stats */
    .stats {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin-top: 1rem;
        color: var(--muted-text);
        font-weight: 600;
    }

    .stats i {
        color: var(--primary-color);
        margin-right: 0.5rem;
    }

    /* Articles Grid */
    .articles {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
    }

    .card-article {
        background: var(--dark-card-bg);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.6);
        display: flex;
        flex-direction: column;
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-article:hover {
        transform: translateY(-6px);
        box-shadow: var(--hover-shadow);
    }

    .card-img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-bottom: 3px solid var(--primary-color);
    }

    .card-body {
        padding: 1.2rem 1rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #fff;
    }

    .card-meta {
        display: flex;
        gap: 1.2rem;
        font-size: 0.9rem;
        color: var(--muted-text);
        margin-bottom: 0.8rem;
    }

    .card-description {
        flex-grow: 1;
        font-size: 0.95rem;
        color: #ccc;
        line-height: 1.4;
        overflow: hidden;
        display: -webkit-box;
        line-clamp: 2;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    /* Sidebar */
    .sidebar {
        background: var(--dark-card-bg);
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        margin-top: 3rem;
    }

    .sidebar h3 {
        color: #fff;
        font-weight: 700;
        margin-bottom: 1rem;
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 0.5rem;
    }

    .sidebar-item {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        cursor: pointer;
        transition: background-color 0.25s ease;
        padding: 0.5rem;
        border-radius: 8px;
    }

    .sidebar-item:hover {
        background-color: rgba(247, 163, 26, 0.15);
    }

    .sidebar-item img {
        width: 64px;
        height: 64px;
        object-fit: cover;
        border-radius: 8px;
        flex-shrink: 0;
    }

    .sidebar-item-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .sidebar-item-title {
        color: #fff;
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 0.25rem;
    }

    .sidebar-item-date {
        font-size: 0.85rem;
        color: var(--muted-text);
    }

    /* Search + Sort */
    .filter-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 2rem;
        justify-content: space-between;
        align-items: center;
    }

    .filter-bar input[type="text"],
    .filter-bar select {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        border: none;
        background-color: var(--dark-card-bg);
        color: var(--light-text);
        font-size: 1rem;
        min-width: 180px;
        transition: box-shadow 0.3s ease;
    }

    .filter-bar input[type="text"]:focus,
    .filter-bar select:focus {
        outline: none;
        box-shadow: 0 0 8px var(--primary-color);
    }

    /* Pagination */
    .pagination {
        justify-content: center;
    }

    .pagination .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: #121212;
        font-weight: 700;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero h1 {
            font-size: 2rem;
        }

        .articles {
            grid-template-columns: 1fr;
        }

        .filter-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-bar input[type="text"],
        .filter-bar select {
            width: 100%;
            min-width: unset;
        }

        .sidebar {
            margin-top: 2rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div>
        <h1>{{ $category->name }}</h1>
        @if($category->description)
        <p>{{ $category->description }}</p>
        @endif
        <div class="stats" aria-label="Category statistics">
            <div><i class="fas fa-newspaper"></i> {{ $blogs->total() }} Articles</div>
            <div><i class="fas fa-eye"></i> {{ number_format($blogs->sum('views_count')) }} Views</div>
            <div><i class="fas fa-heart"></i> {{ number_format($blogs->sum('likes_count')) }} Likes</div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="container">
    <div class="row">
        <!-- Articles Column -->
        <div class="col-lg-8">
            <!-- Filter Bar -->
            <form method="GET" class="filter-bar" role="search" aria-label="Search and sort articles">
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                    placeholder="Search articles..." aria-label="Search articles" autocomplete="off">

                <select name="sort" id="sort" aria-label="Sort articles">
                    <option value="latest" {{ request('sort')=='latest' ? 'selected' : '' }}>Latest</option>
                    <option value="popular" {{ request('sort')=='popular' ? 'selected' : '' }}>Most Popular</option>
                    <option value="oldest" {{ request('sort')=='oldest' ? 'selected' : '' }}>Oldest</option>
                </select>
            </form>

            @if($blogs->count() > 0)
            <div class="articles" role="list">
                @foreach($blogs as $blog)
                <article role="listitem" tabindex="0" class="card-article"
                    onclick="window.location.href='{{ route('fitinsight.show', $blog) }}'"
                    onkeypress="if(event.key === 'Enter') window.location.href='{{ route('fitinsight.show', $blog) }}'">
                    @if($blog->featured_image_path)
                    <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->featured_image_alt ?: $blog->title }}"
                        class="card-img" loading="lazy">
                    @else
                    <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3"
                        alt="Placeholder Image" class="card-img" loading="lazy">
                    @endif
                    <div class="card-body">
                        <h2 class="card-title">{{ Str::limit($blog->title, 60) }}</h2>
                        <div class="card-meta">
                            <span><i class="fas fa-user"></i> {{ $blog->author->name }}</span>
                            <span><i class="fas fa-calendar-alt"></i> {{ $blog->published_at->format('M d, Y') }}</span>
                            <span><i class="fas fa-eye"></i> {{ number_format($blog->views_count) }}</span>
                        </div>
                        <p class="card-description">{{ Str::limit(strip_tags($blog->content), 150) }}</p>
                    </div>
                </article>
                @endforeach
            </div>

            <nav aria-label="Page navigation" class="mt-4">
                {{ $blogs->links() }}
            </nav>

            @else
            <p class="text-muted mt-4">No articles found for your search.</p>
            @endif
        </div>

        <!-- Sidebar Column -->
        <aside class="col-lg-4 sidebar" aria-label="Sidebar with latest and popular posts">
            <section>
                <h3>Latest Posts</h3>
                @foreach($latestBlogs as $latest)
                <a href="{{ route('fitinsight.show', $latest) }}" class="sidebar-item">
                    <img src="{{ $latest->featured_image_url ?: 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3' }}"
                        alt="{{ $latest->featured_image_alt ?: $latest->title }}" loading="lazy">
                    <div class="sidebar-item-content">
                        <div class="sidebar-item-title">{{ Str::limit($latest->title, 50) }}</div>
                        <div class="sidebar-item-date">{{ $latest->published_at->format('M d, Y') }}</div>
                    </div>
                </a>
                @endforeach
            </section>

            <section class="mt-4">
                <h3>Popular Posts</h3>
                @foreach($popularBlogs as $popular)
                <a href="{{ route('fitinsight.show', $popular) }}" class="sidebar-item">
                    <img src="{{ $popular->featured_image_url ?: 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3' }}"
                        alt="{{ $popular->featured_image_alt ?: $popular->title }}" loading="lazy">
                    <div class="sidebar-item-content">
                        <div class="sidebar-item-title">{{ Str::limit($popular->title, 50) }}</div>
                        <div class="sidebar-item-date">{{ $popular->published_at->format('M d, Y') }}</div>
                    </div>
                </a>
                @endforeach
            </section>
        </aside>
    </div>
</section>

@endsection

@push('scripts')
<!-- FontAwesome for icons -->
<script src="https://kit.fontawesome.com/a2d4d76d9a.js" crossorigin="anonymous"></script>
@endpush