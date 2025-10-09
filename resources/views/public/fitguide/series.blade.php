@extends('layouts.public')

@section('title', $fgSeries->title . ' - FitGuide Series')

@section('content')
<div class="container min-vh-100 ">

    <!-- Hero Section -->
    <div class="hero-section py-5"
        style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.8)), url('{{ $fgSeries->banner_image_url ?? 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3' }}') center/cover;">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-8 text-white">
                    <!-- Series Header -->
                    <h1 class="display-4 fw-bold mb-4"
                        style="font-family: 'Jost', sans-serif; background: linear-gradient(90deg, #ff6f61, #f4a261); -webkit-background-clip: text; background-clip: text;">
                        {{ $fgSeries->title }}
                    </h1>
                    <p class="lead mb-4">{{ $fgSeries->description ?? 'No description available' }}</p>

                    <!-- Genre and Info -->
                    <div class="d-flex flex-wrap mb-4">
                        @if($fgSeries->category)
                        <span class="badge bg-netflix-dark-gray me-3">{{ $fgSeries->category->name }}</span>
                        @endif
                        @if($fgSeries->subCategory)
                        <span class="badge bg-outline-light">{{ $fgSeries->subCategory->name }}</span>
                        @endif
                    </div>

                    <!-- Buttons: Start Series & Watch Trailer -->
                    <div class="d-flex align-items-center">
                        @if($episodes->count() > 0)
                        <button class="btn btn-lg btn-netflix-orange me-3" onclick="playEpisode(1)">
                            <i class="fas fa-play me-2"></i>Start Series
                        </button>
                        @endif
                        @if($fgSeries->trailer_url)
                        <button class="btn btn-outline-light btn-lg" onclick="playTrailer()">
                            <i class="fas fa-video me-2"></i>Watch Trailer
                        </button>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="series-poster">
                        <img src="{{ $fgSeries->banner_image_url ?? 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3' }}"
                            alt="{{ $fgSeries->title }}" class="img-fluid rounded shadow-lg" style="max-height: 400px;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Episodes Section -->
    <div class="container py-5">
        <h2 class="section-title mb-4 text-white">
            Episodes
        </h2>

        @if($episodes->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($episodes as $episode)
            <div class="col">
                <div class="episode-card" onclick="playEpisode({{ $episode->episode_number }})">
                    <div class="episode-thumbnail">
                        <img src="{{ $episode->thumbnail_path ? asset('storage/app/public/' . $episode->thumbnail_path) : $fgSeries->banner_image_url }}"
                            alt="Episode {{ $episode->episode_number }}" class="img-fluid rounded">
                        <div class="play-overlay">
                            <i class="fas fa-play"></i>
                        </div>
                        <div class="episode-number">{{ $episode->episode_number }}</div>
                    </div>
                    <div class="episode-info p-3">
                        <h5 class="episode-title">{{ $episode->title }}</h5>
                        <p class="text-muted">{{ Str::limit($episode->description, 100) }}</p>
                        <div class="episode-meta">
                            @if($episode->duration_minutes)
                            <span><i class="fas fa-clock me-1"></i>{{ $episode->duration_minutes }} min</span>
                            @endif
                            @if($episode->release_date)
                            <span><i class="fas fa-calendar me-1"></i>{{ $episode->release_date->format('M d, Y')
                                }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-video fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">No Episodes Available</h4>
            <p class="text-muted">Episodes for this series will be available soon.</p>
        </div>
        @endif
    </div>

    <!-- Similar Series Section -->
    <div class="container py-5">
        <h2 class="section-title mb-4 text-white">
            <i class="fas fa-thumbs-up me-3"></i>More Like This
        </h2>
        <!-- You can add similar series recommendations here -->
    </div>
</div>

<!-- CSS Style -->
<style>
    :root {
        --netflix-red: #e50914;
        --netflix-black: #000000;
        --netflix-dark-gray: #141414;
        --netflix-gray: #2f2f2f;
        --netflix-light-gray: #8c8c8c;
        --netflix-white: #ffffff;
        --fittelly-orange: #f7a31a;
        --fittelly-orange-hover: #e8941a;
        --body-fonts: "Roboto", sans-serif;
        --title-fonts: "Jost", sans-serif;
    }

    /* General Styling */
    body {
        background-color: var(--netflix-dark-gray);
        color: var(--netflix-white);
        font-family: var(--body-fonts);
    }

    .hero-section {
        min-height: 60vh;
        background-size: cover;
        background-position: center;
        position: relative;
        padding: 20px;
        border-radius: 16px;
    }

    .hero-section h1 {
        font-family: var(--title-fonts);
        font-size: 4rem;
        font-weight: bold;
        color: #fff;
        background: linear-gradient(90deg, #ff6f61, #f4a261);
        -webkit-background-clip: text;
        background-clip: text;
        margin-bottom: 20px;
        text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.8);
    }

    .btn-netflix-orange {
        background-color: var(--fittelly-orange);
        border: 1px solid var(--fittelly-orange);
    }

    .btn-outline-light {
        border: 1px solid var(--netflix-white);
    }

    .section-title {
        font-size: 2.5rem;
        color: var(--netflix-white);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 20px;
    }

    .episode-card {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.2);
    }

    .episode-card:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .episode-thumbnail {
        position: relative;
        height: 180px;
        overflow: hidden;
        border-radius: 8px;
    }

    .episode-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .play-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(0, 0, 0, 0.6);
        color: white;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .episode-card:hover .play-overlay {
        opacity: 1;
    }

    .episode-number {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .episode-title {
        font-weight: bold;
        font-size: 1.3rem;
    }

    .episode-meta span {
        font-size: 0.9rem;
        color: var(--netflix-light-gray);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-section {
            min-height: 50vh;
        }

        .episode-card .row {
            flex-direction: column;
        }

        .episode-thumbnail {
            height: 200px;
        }

        .section-title {
            font-size: 2rem;
        }
    }
</style>
<script>
    function playEpisode(episodeNumber) {
        const episodeUrl = `{{ route('fitguide.series.episode', ['fgSeries' => $fgSeries->slug, 'episode' => '__EPISODE__']) }}`.replace('__EPISODE__', episodeNumber);
        window.location.href = episodeUrl;
    }

    function playTrailer() {
        @if($fgSeries->trailer_url)
            window.open('{{ $fgSeries->trailer_url }}', '_blank');
        @endif
    }
</script>
@endsection
