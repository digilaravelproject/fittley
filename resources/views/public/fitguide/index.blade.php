@extends('layouts.public')

@section('title', 'FitGuide - Fitness Training Guides & Programs')

@push('styles')
    <link rel="stylesheet" href="{{ asset('public/assets/home/css/fitdoc.index.css') }}?v={{ time() }}">
@endpush

@section('content')
    <div class="fitdoc-container">

        {{-- HERO --}}
        <section class="hero-section">
            <div class="container-fluid">
                <div class="hero-content text-white">
                    <h1>FitGuide</h1>
                    <p>Master your fitness journey with comprehensive training guides, workout programs, and expert-led
                        series.</p>
                </div>
            </div>
        </section>

        <div class="container px-3 mt-1 mb-5">
            <!-- Filter Buttons for Categories -->
            <div class="filter-buttons">
                <button class="filter-btn {{ request('category') == null ? 'active' : '' }}" data-filter="all"
                    onclick="window.location.href='{{ route('fitguide.index') }}'">All Content</button>

                @foreach ($categories as $category)
                    <button class="filter-btn {{ request('category') == $category->slug ? 'active' : '' }}"
                        data-filter="{{ $category->slug }}"
                        onclick="window.location.href='{{ route('fitguide.index', ['category' => $category->slug]) }}'">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>


            <!-- Content Based on Category Selection -->
            <div class="filterable-content">
                <!-- Featured Quick Guides -->
                @if (isset($featuredSingles) && $featuredSingles->count() > 0)
                    <section class="content-section" data-category="quick-guides">
                        <h2 class="section-title">Featured Quick Guides</h2>
                        <div class="media-grid-wrapper">
                            @foreach ($featuredSingles as $single)
                                <x-home.media-grid :title="$single->title" :image="$single->banner_image_url ??
                                    'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3'" :url="route('fitguide.single.show', $single->slug)" :type="'quick-guide'"
                                    badgeClass="type-badge" :year="optional($single->created_at)->format('Y')" :rating="null" :description="Str::limit($single->description ?? 'Training guide description', 100)" />
                            @endforeach
                        </div>
                    </section>
                @endif

                <!-- Featured Training Series -->
                @if (isset($featuredSeries) && $featuredSeries->count() > 0)
                    <section class="content-section" data-category="training-series">
                        <h2 class="section-title">Featured Training Series</h2>
                        <div class="media-grid-wrapper">
                            @foreach ($featuredSeries as $series)
                                <x-home.media-grid :title="$series->title" :image="$series->banner_image_url ??
                                    'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3'" :url="route('fitguide.series.show', $series->slug)" :type="'series'"
                                    badgeClass="series-badge" :year="optional($series->created_at)->format('Y')" :rating="null" :description="Str::limit($series->description ?? 'Training series description', 100)" />
                            @endforeach
                        </div>
                    </section>
                @endif

                <!-- All Quick Guides -->
                @if (isset($allSingles) && $allSingles->count() > 0)
                    <section class="content-section" data-category="quick-guides">
                        <h2 class="section-title">All Quick Guides</h2>
                        <div class="media-grid-wrapper">
                            @foreach ($allSingles as $single)
                                <x-home.media-grid :title="$single->title" :image="$single->banner_image_url ??
                                    'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3'" :url="route('fitguide.single.show', $single->slug)"
                                    :type="'quick-guide'" badgeClass="type-badge" :year="optional($single->created_at)->format('Y')" :rating="null"
                                    :description="Str::limit($single->description ?? 'Training guide description', 100)" />
                            @endforeach
                        </div>
                    </section>
                @endif

                <!-- All Training Series -->
                @if (isset($allSeries) && $allSeries->count() > 0)
                    <section class="content-section" data-category="training-series">
                        <h2 class="section-title">All Training Series</h2>
                        <div class="media-grid-wrapper">
                            @foreach ($allSeries as $series)
                                <x-home.media-grid :title="$series->title" :image="$series->banner_image_url ??
                                    'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3'" :url="route('fitguide.series.show', $series->slug)"
                                    :type="'series'" badgeClass="series-badge" :year="optional($series->created_at)->format('Y')" :rating="null"
                                    :description="Str::limit($series->description ?? 'Training series description', 100)" />
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>

            <!-- Coming Soon Message if no content -->
            @if (
                !isset($error) &&
                    ((!isset($featuredSingles) || $featuredSingles->count() === 0) &&
                        (!isset($featuredSeries) || $featuredSeries->count() === 0) &&
                        (!isset($categories) || $categories->count() === 0)))
                <section class="content-section">
                    <div class="text-center py-5">
                        <h2 style="color: #fff; margin-bottom: 1rem;">Coming Soon</h2>
                        <p style="color: #aaa; font-size: 1.1rem;">
                            Comprehensive training guides and workout programs are being prepared. Get ready to transform
                            your fitness journey!
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
            const contentSections = document.querySelectorAll('.content-section[data-category]');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    const filter = this.getAttribute('data-filter');

                    contentSections.forEach(section => {
                        // Check if the category matches the filter
                        if (filter === 'all' || section.getAttribute('data-category') ===
                            filter) {
                            section.style.display = '';
                        } else {
                            section.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
@endpush
