@extends('layouts.public')

@section('title', 'FitNews - Live Streams')

@push('styles')
    <link rel="stylesheet" href="{{ asset('public/assets/home/css/fitdoc.index.css') }}?v={{ time() }}">
@endpush

@section('content')
    @php
        $liveStreams = $liveStreams ?? collect();
        $upcomingStreams = $upcomingStreams ?? collect();
        $pastStreams = $pastStreams ?? collect();
        $heroStream = $latestStream ?? ($liveStreams->first() ?? null);
    @endphp

    <div class="fitdoc-container">

        {{-- HERO --}}
        <section class="hero-section"
            style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8)),
         url('{{ $heroStream && $heroStream->banner_image ? Storage::url($heroStream->banner_image) : 'https://images.unsplash.com/photo-1558611848-73f7eb4001a1?ixlib=rb-4.0.3' }}') center/cover no-repeat;">
            <div class="container-fluid">
                <div class="hero-content text-white">
                    <h1>FitNews Live</h1>
                    <p>Stay updated with live fitness news and insights</p>
                    @if ($heroStream)
                        <div class="live-now-alert">

                            <strong>{{ $heroStream->title }}</strong>
                            <a href="{{ route('fitnews.show', $heroStream) }}" class="btn btn-light btn-sm ms-2">
                                Watch Now
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <div class="container px-3 mt-1 mb-5">

            {{-- LIVE NOW --}}
            @if ($liveStreams->count())
                <section class="content-section" data-type="live">
                    <h2 class="section-title">
                        Live Now
                    </h2>
                    <div class="media-grid-wrapper">
                        @foreach ($liveStreams as $stream)
                            <x-home.media-grid :title="$stream->title" :image="$stream->thumbnail ? asset('storage/app/public/' . $stream->thumbnail) : null" :url="route('fitnews.show', $stream)" :type="'live'"
                                badgeClass="live-badge" :year="optional($stream->started_at)->format('Y')" :rating="$stream->viewer_count" :description="'By ' . optional($stream->creator)->name" />
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- UPCOMING --}}
            @if ($upcomingStreams->count())
                <section class="content-section" data-type="upcoming">
                    <h2 class="section-title">
                        Upcoming Streams
                    </h2>
                    <div class="media-grid-wrapper">
                        @foreach ($upcomingStreams as $stream)
                            <x-home.media-grid :title="$stream->title" :image="$stream->thumbnail ? asset('storage/app/public/' . $stream->thumbnail) : null" :url="route('fitnews.show', $stream)" :type="'upcoming'"
                                badgeClass="upcoming-badge" :year="optional($stream->scheduled_at)->format('Y')" :description="'By ' .
                                    optional($stream->creator)->name .
                                    ' | ' .
                                    optional($stream->scheduled_at)->format('M d, g:i A')" />
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- RECENT --}}
            @if ($pastStreams->count())
                <section class="content-section" data-type="ended">
                    <h2 class="section-title">
                        Recent Streams
                    </h2>
                    <div class="media-grid-wrapper">
                        @foreach ($pastStreams as $stream)
                            <x-home.media-grid :title="$stream->title" :image="$stream->thumbnail ? asset('storage/app/public/' . $stream->thumbnail) : null" :url="route('fitnews.show', $stream)" :type="'ended'"
                                badgeClass="ended-badge" :year="optional($stream->ended_at)->format('Y')" :description="'By ' .
                                    optional($stream->creator)->name .
                                    ' | ' .
                                    optional($stream->ended_at)->format('M d')" />
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- EMPTY STATE --}}
            @if ($liveStreams->isEmpty() && $upcomingStreams->isEmpty() && $pastStreams->isEmpty())
                <section class="content-section">
                    <div class="text-center py-5">

                        <h2 style="color: #fff; margin-bottom: 1rem;">No Streams Available</h2>
                        <p style="color: #aaa; font-size: 1.1rem;">Stay tuned for upcoming fitness news and live streams!
                        </p>
                    </div>
                </section>
            @endif

        </div>
    </div>
@endsection
