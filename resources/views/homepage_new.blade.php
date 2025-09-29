@extends('layouts.public')

@section('title', 'FITTELLY - Your Ultimate Fitness Destination')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/swiper@10/swiper-bundle.min.css">
<style>
    /* Override main content padding for homepage */
    .main-content {
        padding-top: 0;
    }
    
    /* Netflix-style Dark Theme */
    :root {
        --netflix-red: #e50914;
        --netflix-black: #000000;
        --netflix-dark-gray: #141414;
        --netflix-gray: #2f2f2f;
        --netflix-light-gray: #8c8c8c;
        --netflix-white: #ffffff;
        --fittelly-orange: #f7a31a;
        --fittelly-orange-hover: #e8941a;
    }

    body {
        background-color: var(--netflix-black);
        color: var(--netflix-white);
    }

    /* Hero Section */
    .hero-section {
        height: 100vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
    }

    .hero-section.has-video {
        background: none;
    }

    .hero-section.no-video {
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.4)), 
                    url('https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3') center/cover;
    }

    .hero-video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: -2;
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 50%, rgba(0,0,0,0.6) 100%);
        z-index: -1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        padding-left: 5%;
        max-width: 600px;
    }

    .hero-category {
        font-size: 4rem;
        font-weight: 800;
        margin-bottom: 1rem;
        background: linear-gradient(45deg, var(--fittelly-orange), var(--netflix-white));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-meta {
        display: flex;
        align-items: center;
        gap: 2rem;
        margin-bottom: 2rem;
        color: var(--netflix-light-gray);
    }

    .hero-description {
        font-size: 1.2rem;
        line-height: 1.6;
        margin-bottom: 3rem;
        max-width: 600px;
        color: var(--netflix-white);
    }

    .hero-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-play, .btn-trailer {
        padding: 1rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1.1rem;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
    }

    .btn-play {
        background: var(--fittelly-orange);
        color: var(--netflix-black);
    }

    .btn-play:hover {
        background: var(--fittelly-orange-hover);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(247, 163, 26, 0.3);
    }

    .btn-trailer {
        background: rgba(255, 255, 255, 0.2);
        color: var(--netflix-white);
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .btn-trailer:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.6);
        transform: translateY(-2px);
    }

    /* Content Sections */
    .content-section {
        padding: 4rem 0;
        background: var(--netflix-black);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--netflix-white);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title i {
        color: var(--fittelly-orange);
    }

    /* Netflix-style Content Cards */
    .content-card {
        background: var(--netflix-dark-gray);
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        height: 300px;
        margin-bottom: 2rem;
    }

    .content-card:hover {
        transform: scale(1.05);
        z-index: 10;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8);
    }

    .card-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .content-card:hover .card-image {
        transform: scale(1.1);
    }

    .card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.8));
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .content-card:hover .card-overlay {
        opacity: 1;
    }

    .play-icon {
        width: 60px;
        height: 60px;
        background: var(--fittelly-orange);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--netflix-black);
        transform: scale(0.8);
        transition: transform 0.3s ease;
    }

    .content-card:hover .play-icon {
        transform: scale(1);
    }

    .card-content {
        padding: 1rem;
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.9));
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--netflix-white);
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .card-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        color: var(--netflix-light-gray);
        font-size: 0.85rem;
    }

    .card-meta span {
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .card-status {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 0.3rem 0.6rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-live {
        background: var(--netflix-red);
        color: var(--netflix-white);
        animation: pulse 2s infinite;
    }

    .status-upcoming {
        background: var(--fittelly-orange);
        color: var(--netflix-black);
    }

    .status-scheduled {
        background: #4CAF50;
        color: var(--netflix-white);
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(229, 9, 20, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(229, 9, 20, 0); }
        100% { box-shadow: 0 0 0 0 rgba(229, 9, 20, 0); }
    }

    /* Button Styles */
    .btn-outline-primary {
        background: transparent;
        border: 2px solid var(--fittelly-orange);
        color: var(--fittelly-orange);
        padding: 0.6rem 1.5rem;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .btn-outline-primary:hover {
        background: var(--fittelly-orange);
        color: var(--netflix-black);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(247, 163, 26, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-category {
            font-size: 2.5rem;
        }
        
        .hero-description {
            font-size: 1rem;
        }
        
        .hero-buttons {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .btn-play, .btn-trailer {
            width: 100%;
            justify-content: center;
        }
        
        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .content-card {
            height: 250px;
        }
    }
</style>
@endpush

@section('content')
<div class="homepage-container">
    <!-- Hero Section -->
    @if($hero)
    <section class="hero-section {{ $hero->youtube_video_id ? 'has-video' : 'no-video' }}">
        @if($hero->youtube_video_id)
            <iframe class="hero-video" 
                    src="{{ $hero->youtube_embed_url }}" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
            </iframe>
        @endif
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-category">{{ $hero->title ?? 'FITTELLY' }}</h1>
                <div class="hero-meta">
                    <span><i class="fas fa-star"></i> Premium Content</span>
                    <span><i class="fas fa-users"></i> 10K+ Members</span>
                </div>
                <p class="hero-description">
                    {{ $hero->description ?? 'Transform your fitness journey with our premium live sessions, expert guidance, and comprehensive wellness content. Join thousands of fitness enthusiasts in achieving their goals.' }}
                </p>
                <div class="hero-buttons">
                    <a href="{{ route('fitlive.index') }}" class="btn-play">
                        <i class="fas fa-play"></i> Start Training
                    </a>
                    @if($hero->youtube_video_id)
                        <button class="btn-trailer">
                            <i class="fas fa-info-circle"></i> More Info
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </section>
    @endif

    <div class="content-wrapper">
        <!-- FitLive Live Sessions -->
        @if($liveSessions && $liveSessions->count() > 0)
        <section class="content-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-broadcast-tower"></i>Live Now
                    </h2>
                    <a href="{{ route('fitlive.index') }}" class="btn-outline-primary">View All</a>
                </div>
                <div class="row">
                    @foreach($liveSessions->take(6) as $session)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="content-card" onclick="window.location.href='{{ route('fitlive.index') }}'">
                                <img src="{{ $session->banner_image ? asset('storage/app/public/' . $session->banner_image) : 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3' }}" 
                                     alt="{{ $session->title }}" class="card-image">
                                <div class="card-overlay">
                                    <div class="play-icon">
                                        <i class="fas fa-play"></i>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <span class="card-status status-live">LIVE</span>
                                    <h3 class="card-title">{{ $session->title }}</h3>
                                    <div class="card-meta">
                                        <span><i class="fas fa-user"></i> {{ $session->instructor ? $session->instructor->name : 'Instructor' }}</span>
                                        <span><i class="fas fa-users"></i> {{ $session->viewer_peak ?? 0 }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- FitLive Upcoming Sessions -->
        @if($upcomingSessions && $upcomingSessions->count() > 0)
        <section class="content-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-calendar"></i>Coming Soon
                    </h2>
                    <a href="{{ route('fitlive.index') }}" class="btn-outline-primary">View All</a>
                </div>
                <div class="row">
                    @foreach($upcomingSessions->take(6) as $upcoming)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="content-card" onclick="window.location.href='{{ route('fitlive.index') }}'">
                                <img src="{{ $upcoming->banner_image ? asset('storage/app/public/' . $upcoming->banner_image) : 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3' }}" 
                                     alt="{{ $upcoming->title }}" class="card-image">
                                <div class="card-overlay">
                                    <div class="play-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <span class="card-status status-upcoming">UPCOMING</span>
                                    <h3 class="card-title">{{ $upcoming->title }}</h3>
                                    <div class="card-meta">
                                        <span><i class="fas fa-user"></i> {{ $upcoming->instructor ? $upcoming->instructor->name : 'Instructor' }}</span>
                                        <span><i class="fas fa-calendar"></i> {{ $upcoming->scheduled_at ? $upcoming->scheduled_at->format('M d, g:i A') : 'TBD' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- FitDoc Section -->
        @if($fitDocs && $fitDocs->count() > 0)
        <section class="content-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-film"></i>FitDoc
                    </h2>
                    <a href="{{ route('fitdoc.index') }}" class="btn-outline-primary">View All</a>
                </div>
                <div class="row">
                    @foreach($fitDocs->take(6) as $doc)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="content-card" onclick="window.location.href='{{ route('fitdoc.index') }}'">
                                <img src="{{ $doc->banner_image_url ?? 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3' }}" 
                                     alt="{{ $doc->title }}" class="card-image">
                                <div class="card-overlay">
                                    <div class="play-icon">
                                        <i class="fas fa-play"></i>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <h3 class="card-title">{{ $doc->title }}</h3>
                                    <div class="card-meta">
                                        <span><i class="fas fa-video"></i> {{ $doc->type === 'series' ? 'Series' : 'Movie' }}</span>
                                        <span><i class="fas fa-clock"></i> {{ $doc->duration_minutes ?? '90' }} min</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- FitGuide Section -->
        @if($fitGuides && $fitGuides->count() > 0)
        <section class="content-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-dumbbell"></i>FitGuide
                    </h2>
                    <a href="{{ route('fitguide.index') }}" class="btn-outline-primary">View All</a>
                </div>
                <div class="row">
                    @foreach($fitGuides->take(6) as $guide)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="content-card" onclick="window.location.href='{{ route('fitguide.index') }}'">
                                <img src="{{ $guide->banner_image_url ?? 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3' }}" 
                                     alt="{{ $guide->title }}" class="card-image">
                                <div class="card-overlay">
                                    <div class="play-icon">
                                        <i class="fas fa-play"></i>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <h3 class="card-title">{{ $guide->title }}</h3>
                                    <div class="card-meta">
                                        <span><i class="fas fa-dumbbell"></i> Training</span>
                                        <span><i class="fas fa-clock"></i> {{ $guide->duration_minutes ?? '30' }} min</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- FitNews Section -->
        @if($fitNews && $fitNews->count() > 0)
        <section class="content-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-newspaper"></i>FitNews
                    </h2>
                    <a href="{{ route('fitnews.index') }}" class="btn-outline-primary">View All</a>
                </div>
                <div class="row">
                    @foreach($fitNews->take(6) as $news)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="content-card" onclick="window.location.href='{{ route('fitnews.show', $news) }}'">
                                <img src="{{ $news->thumbnail ? asset('storage/app/public/' . $news->thumbnail) : 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3' }}" 
                                     alt="{{ $news->title }}" class="card-image">
                                <div class="card-overlay">
                                    <div class="play-icon">
                                        <i class="fas fa-play"></i>
                                    </div>
                                </div>
                                <div class="card-content">
                                    @if($news->status === 'scheduled')
                                        <span class="card-status status-scheduled">SCHEDULED</span>
                                    @endif
                                    <h3 class="card-title">{{ $news->title }}</h3>
                                    <div class="card-meta">
                                        <span><i class="fas fa-user"></i> {{ $news->creator ? $news->creator->name : 'Admin' }}</span>
                                        <span><i class="fas fa-calendar"></i> {{ $news->scheduled_at ? $news->scheduled_at->format('M d') : 'TBD' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- FitInsights Section -->
        @if($fitInsights && $fitInsights->count() > 0)
        <section class="content-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-blog"></i>FitInsights
                    </h2>
                    <a href="{{ route('fitinsight.index') }}" class="btn-outline-primary">View All</a>
                </div>
                <div class="row">
                    @foreach($fitInsights->take(6) as $insight)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="content-card" onclick="window.location.href='{{ route('fitinsight.show', $insight) }}'">
                                <img src="{{ $insight->featured_image_url ?? 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3' }}" 
                                     alt="{{ $insight->title }}" class="card-image">
                                <div class="card-overlay">
                                    <div class="play-icon">
                                        <i class="fas fa-book-open"></i>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <h3 class="card-title">{{ $insight->title }}</h3>
                                    <div class="card-meta">
                                        <span><i class="fas fa-user"></i> {{ $insight->author ? $insight->author->name : 'Admin' }}</span>
                                        <span><i class="fas fa-eye"></i> {{ $insight->views_count ?? 0 }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Card click functionality
    document.querySelectorAll('.content-card').forEach(card => {
        card.addEventListener('click', function() {
            const href = this.getAttribute('onclick');
            if (href) {
                const url = href.match(/window\.location\.href='([^']+)'/);
                if (url && url[1]) {
                    window.location.href = url[1];
                }
            }
        });
    });
});
</script>
@endpush 