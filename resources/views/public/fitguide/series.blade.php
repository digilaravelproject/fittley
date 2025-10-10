@extends('layouts.public')

@section('title', $fgSeries->title . ' - FitGuide Series')

@section('content')
    <div class="fg-series-page">

        {{-- Hero Section --}}
        <div class="hero-section position-relative d-flex align-items-center">
            <div class="hero-overlay"></div>
            <div class="hero-bg" style="
                        background: url('{{ $fgSeries->banner_image_url ? getImagePath($fgSeries->banner_image_url) : 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3' }}') center/cover no-repeat;
                    "></div>
            <div class="container hero-content text-white">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h1 class="series-title mb-3">{{ $fgSeries->title }}</h1>
                        <p class="series-desc mb-4">{{ $fgSeries->description ?? 'No description available' }}</p>
                        <div class="d-flex flex-wrap mb-4 series-badges">
                            @if($fgSeries->category)
                                <span class="badge badge-cat me-3">{{ $fgSeries->category->name }}</span>
                            @endif
                            @if($fgSeries->subCategory)
                                <span class="badge badge-subcat">{{ $fgSeries->subCategory->name }}</span>
                            @endif
                        </div>
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            @if($episodes->count() > 0)
                                <button class="btn btn-primary btn-lg btn-start" onclick="playEpisode(1)">
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
                    <div class="col-lg-4 text-center mt-4 mt-lg-0">
                        <div class="poster-container">
                            <img src="{{ $fgSeries->banner_image_url ? getImagePath($fgSeries->banner_image_url) : 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3' }}"
                                alt="{{ $fgSeries->title }}" class="img-fluid rounded poster-img">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Episodes Section --}}
        <div class="episodes-section py-5">
            <div class="container">
                <h2 class="section-title text-white mb-4">Episodes</h2>
                @if($episodes->count() > 0)
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        @foreach($episodes as $episode)
                            <div class="col">
                                <div class="episode-card" onclick="playEpisode({{ $episode->episode_number }})">
                                    <div class="episode-thumbnail position-relative">
                                        <img src="{{ $episode->thumbnail_path ? getImagePath($episode->thumbnail_path) : ($fgSeries->banner_image_url ? getImagePath($fgSeries->banner_image_url) : '') }}"
                                            alt="Episode {{ $episode->episode_number }}" class="img-fluid rounded">
                                        <div class="play-overlay">
                                            <i class="fas fa-play"></i>
                                        </div>
                                        <div class="episode-number">
                                            {{ $episode->episode_number }}
                                        </div>
                                    </div>
                                    <div class="episode-info p-3">
                                        <h5 class="episode-title">{{ $episode->title }}</h5>
                                        <p class="text-muted">{{ Str::limit($episode->description, 100) }}</p>
                                        <div class="episode-meta d-flex flex-wrap gap-3 mt-2">
                                            @if($episode->duration_minutes)
                                                <span class="meta-item"><i
                                                        class="fas fa-clock me-1"></i>{{ $episode->duration_minutes }} min</span>
                                            @endif
                                            @if($episode->release_date)
                                                <span class="meta-item"><i
                                                        class="fas fa-calendar me-1"></i>{{ $episode->release_date->format('M d, Y') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5 no-episodes">
                        <i class="fas fa-video fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No Episodes Available</h4>
                        <p class="text-muted">Episodes will be available soon.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Similar / More Like This Section --}}
        <div class="more-like-this-section py-5">
            <div class="container">
                <h2 class="section-title text-white mb-4">
                    <i class="fas fa-thumbs-up me-3"></i>More Like This
                </h2>
                {{-- Add recommended series here as cards, same style as episodes or custom --}}
            </div>
        </div>

    </div>

    <style>
        :root {
            --series-bg-dark: #121212;
            --series-bg-light: #f5f5f5;
            --accent-gradient: linear-gradient(90deg, #ff6f61, #f4a261);
            --btn-primary-color: #ff6f61;
            --btn-primary-hover: #e55b50;
            --text-light: #f0f0f0;
            --text-muted-light: #b0b0b0;
            --card-bg-glass: rgba(255, 255, 255, 0.08);
            --card-backdrop-blur: blur(12px);
        }

        .fg-series-page {
            background-color: var(--series-bg-dark);
        }

        /* Hero */
        .hero-section {
            position: relative;
            min-height: 60vh;
            display: flex;
            align-items: center;
            overflow: hidden;
            border-radius: 12px;
            margin-top: 2rem;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            background-size: cover;
            background-position: center;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 2;
        }

        .hero-content {
            position: relative;
            z-index: 3;
            padding: 2rem 1rem;
        }

        .series-title {
            font-family: 'Jost', sans-serif;
            font-size: 2.8rem;
            font-weight: 700;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 1rem;
        }

        .series-desc {
            font-size: 1.1rem;
            color: var(--text-light);
            max-width: 600px;
        }

        .series-badges .badge {
            font-size: 0.9rem;
            padding: 0.4rem 0.8rem;
            border-radius: 0.5rem;
            background-color: rgba(255, 255, 255, 0.15);
            color: var(--text-light);
        }

        .btn-start {
            background: var(--btn-primary-color);
            border: none;
            color: #fff;
            transition: background 0.3s;
        }

        .btn-start:hover {
            background: var(--btn-primary-hover);
        }

        .btn-outline-light {
            border: 1px solid #fff;
            color: #fff;
            background: transparent;
            transition: background 0.3s, color 0.3s;
        }

        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .poster-container .poster-img {
            max-height: 400px;
            width: auto;
            border-radius: 0.75rem;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
        }

        /* Episodes Section */
        .episodes-section {
            background-color: var(--series-bg-dark);
            padding-top: 4rem;
        }

        .episodes-section .section-title {
            font-size: 2.4rem;
            color: #fff;
            margin-bottom: 2rem;
        }

        .episode-card {
            background: var(--card-bg-glass);
            backdrop-filter: var(--card-backdrop-blur);
            border-radius: 1rem;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .episode-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.5);
        }

        .episode-thumbnail {
            position: relative;
            height: 180px;
            overflow: hidden;
            border-bottom-left-radius: 1rem;
            border-bottom-right-radius: 1rem;
        }

        .episode-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .episode-card:hover .episode-thumbnail img {
            transform: scale(1.05);
        }

        .play-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
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
            top: 12px;
            left: 12px;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 4px 8px;
            border-radius: 0.4rem;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .episode-info {
            color: var(--text-light);
        }

        .episode-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #fff;
            margin-bottom: 0.5rem;
        }

        .episode-meta .meta-item {
            font-size: 0.9rem;
            color: var(--text-muted-light);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* No episodes fallback */
        .no-episodes {
            color: var(--text-muted-light);
        }

        /* More Like This section */
        .more-like-this-section {
            background-color: var(--series-bg-dark);
        }

        /* Responsiveness */
        @media (max-width: 992px) {
            .series-title {
                font-size: 2.2rem;
            }

            .series-desc {
                font-size: 1rem;
            }
        }

        @media (max-width: 768px) {
            .hero-section {
                min-height: 50vh;
            }

            .poster-container .poster-img {
                max-height: 300px;
            }

            .episode-thumbnail {
                height: 160px;
            }

            .episodes-section .section-title {
                font-size: 2rem;
            }
        }

        @media (max-width: 576px) {
            .series-badges {
                justify-content: start;
            }

            .btn-lg {
                width: 100%;
            }
        }
    </style>

    <script>
        function playEpisode(episodeNumber) {
            // Replace placeholder with actual route
            const urlTemplate = `{{ route('fitguide.series.episode', ['fgSeries' => $fgSeries->slug, 'episode' => '__EP__']) }}`;
            const final = urlTemplate.replace('__EP__', episodeNumber);
            window.location.href = final;
        }

        function playTrailer() {
            @if($fgSeries->trailer_url)
                window.open('{{ $fgSeries->trailer_url }}', '_blank');
            @endif
                }
    </script>
@endsection