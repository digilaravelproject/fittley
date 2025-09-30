@extends('layouts.public')

@section('title', 'FitGuide - Fitness Training Guides & Programs')

@push('styles')
    <link rel="stylesheet" href="{{ asset('public/assets/home/css/fitdoc.index.css') }}?v={{ time() }}">
@endpush

@section('content')
    {{-- @php
        $liveStreams = $liveStreams ?? collect();
        $upcomingStreams = $upcomingStreams ?? collect();
        $pastStreams = $pastStreams ?? collect();
        $heroStream = $latestStream ?? ($liveStreams->first() ?? null);
    @endphp --}}

    <div class="fitdoc-container">

        {{-- HERO --}}
        <section class="hero-section">
            <div class="container-fluid">
                <div class="hero-content text-white">
                    <h1>FitGuide</h1>
                    <p>Master your fitness journey with comprehensive training guides, workout programs, and expert-led
                        series.</p>
                    {{-- @if ($heroStream)
                        <div class="live-now-alert">

                            <strong>{{ $heroStream->title }}</strong>
                            <a href="{{ route('fitnews.show', $heroStream) }}" class="btn btn-light btn-sm ms-2">
                                Watch Now
                            </a>
                        </div>
                    @endif --}}
                </div>
            </div>
        </section>

        <div class="container px-3 mt-1 mb-5">
            <!-- Error Message if there's an error -->
            @if (isset($error))
                <div class="content-section">
                    <div class="text-center">
                        <h3 style="color: #e50914;">Error: {{ $error }}</h3>
                    </div>
                </div>
            @endif
            {{-- <!-- Categories Section -->
            @if (isset($categories) && $categories->count() > 0)
                <section class="content-section">
                    <h2 class="section-title">
                         Training Categories
                    </h2>
                    <div class="row">
                        @foreach ($categories as $category)
                            <div class="col-md-6 col-lg-3 mb-4">
                                <a href="{{ route('fitguide.category', $category->slug) }}" style="text-decoration: none;">
                                    <div class="category-card">
                                        <div class="category-icon">
                                          <i class="fas fa-dumbbell"></i>
                                        </div>
                                        <h3 class="category-title">{{ $category->name }}</h3>
                                        <p style="color: #8c8c8c;">Available Programs</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif --}}
            <!-- Featured Singles -->
            @if (isset($featuredSingles) && $featuredSingles->count() > 0)

                <section class="content-section" data-type="live">
                    <h2 class="section-title">
                        Featured Quick Guides
                    </h2>
                    <div class="media-grid-wrapper">
                        @foreach ($featuredSingles as $single)
                            <x-home.media-grid :title="$single->title" :image="$single->banner_image_url
                                ? $single->banner_image_url
                                : 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3'" :url="route('fitguide.single.show', $single->slug)" :type="'quick-guide'"
                                badgeClass="type-badge" :year="optional($single->created_at)->format('Y')" :rating="null" :description="Str::limit($single->description ?? 'Training guide description', 100)" />
                        @endforeach
                    </div>
                </section>
            @endif


            <!-- Featured Series -->
            @if (isset($featuredSeries) && $featuredSeries->count() > 0)
                <section class="content-section" data-type="series">
                    <h2 class="section-title">
                        Featured Training Series
                    </h2>
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
                <section class="content-section" data-type="quick-guides">
                    <h2 class="section-title">
                        All Quick Guides
                    </h2>
                    <div class="media-grid-wrapper">
                        @foreach ($allSingles as $single)
                            <x-home.media-grid :title="$single->title" :image="$single->banner_image_url ??
                                'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3'" :url="route('fitguide.single.show', $single->slug)" :type="'quick-guide'"
                                badgeClass="type-badge" :year="optional($single->created_at)->format('Y')" :rating="null" :description="Str::limit($single->description ?? 'Training guide description', 100)" />
                        @endforeach
                    </div>
                </section>
            @endif
            <!-- All Training Series -->
            @if (isset($allSeries) && $allSeries->count() > 0)
                <section class="content-section" data-type="training-series">
                    <h2 class="section-title">
                        All Training Series
                    </h2>
                    <div class="media-grid-wrapper">
                        @foreach ($allSeries as $series)
                            <x-home.media-grid :title="$series->title" :image="$series->banner_image_url ??
                                'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3'" :url="route('fitguide.series.show', $series->slug)" :type="'series'"
                                badgeClass="series-badge" :year="optional($series->created_at)->format('Y')" :rating="null" :description="Str::limit($series->description ?? 'Training series description', 100)" />
                        @endforeach
                    </div>
                </section>
            @endif


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
