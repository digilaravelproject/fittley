@extends('layouts.public')

@section('title', 'FitDoc - Fitness Documentaries & Series')

@push('styles')
    <link rel="stylesheet" href="{{ asset('public/assets/home/css/fitdoc.index.css') }}?v={{ time() }} ">
@endpush

@section('content')
    <div class="fitdoc-container">
        <section class="hero-section">
            <div class="container-fluid">
                <div class="hero-content">
                    <h1>FitDoc</h1>
                    <p>Discover inspiring fitness documentaries, training series, and educational content...</p>
                </div>
            </div>
        </section>

        <div class="container px-3 mt-1 mb-5">
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">All Content</button>
                <button class="filter-btn" data-filter="movie">Movies</button>
                <button class="filter-btn" data-filter="series">Series</button>
            </div>

            @if ($featuredSingles && $featuredSingles->count() > 0)
                <section class="content-section" data-type="movie">
                    <h2 class="section-title">Featured Movies</h2>
                    <div class="media-grid-wrapper">
                        @foreach ($featuredSingles as $single)
                            <x-home.media-grid :title="$single->title" :image="$single->banner_image_url" :type="'movie'" :url="route('fitdoc.single.show', $single->slug)"
                                :duration="$single->duration_minutes" badgeClass="movie-badge" :year="$single->release_date?->format('Y')" :rating="$single->feedback"
                                :description="$single->description" />
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($featuredSeries && $featuredSeries->count() > 0)
                <section class="content-section" data-type="series">
                    <h2 class="section-title">Featured Series</h2>
                    <div class="media-grid-wrapper">
                        @foreach ($featuredSeries as $series)
                            <x-home.media-grid :title="$series->title" :image="$series->banner_image_url" :type="'series'" :url="route('fitdoc.series.show', $series->slug)"
                                :duration="$series->total_episodes" badgeClass="series-badge" :year="$series->release_date?->format('Y')" :rating="$series->feedback"
                                :description="$series->description" />
                        @endforeach
                    </div>
                </section>
            @endif

            @if ((!$featuredSingles || $featuredSingles->count() === 0) && (!$featuredSeries || $featuredSeries->count() === 0))
                <section class="content-section">
                    <div class="text-center py-5">
                        <i class="fas fa-film"
                            style="font-size: 4rem; color: var(--fittelly-orange); margin-bottom: 2rem;"></i>
                        <h2 style="color: var(--netflix-white); margin-bottom: 1rem;">Coming Soon</h2>
                        <p style="color: var(--netflix-light-gray); font-size: 1.1rem;">
                            Amazing fitness documentaries and series are on their way. Stay tuned!
                        </p>
                    </div>
                </section>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const contentSections = document.querySelectorAll('.content-section[data-type]');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    const filter = this.getAttribute('data-filter');

                    contentSections.forEach(section => {
                        if (filter === 'all' || section.getAttribute('data-type') ===
                            filter) {
                            section.style.display = '';
                        } else {
                            section.style.display = 'none';
                        }
                    });
                });
            });

            // clickable card
            document.querySelectorAll('.content-card').forEach(card => {
                card.addEventListener('click', function() {
                    const onclickAttr = card.getAttribute('onclick');
                    if (onclickAttr) {
                        const match = onclickAttr.match(/window\.location\.href='([^']+)'/);
                        if (match && match[1]) {
                            window.location.href = match[1];
                        }
                    }
                });
            });
        });
    </script>
@endpush
