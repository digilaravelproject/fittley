@extends('layouts.public')

@section('title', 'FitLive - Live Fitness Sessions')

@push('styles')
    <link rel="stylesheet" href="{{ asset('public/assets/home/css/fitdoc.index.css') }}?v={{ time() }}">
@endpush

@section('content')
    <div class="fitdoc-container">
        {{-- HERO SECTION --}}
        <section class="hero-section">
            <div class="container-fluid">
                <div class="hero-content">
                    <h1>FitLive</h1>
                    <p>Join live fitness sessions with expert instructors</p>

                    @if ($liveSession)
                        <div class="live-now-alert">

                            <strong>{{ $liveSession->title }}</strong> is live now!
                            <a href="{{ route('fitlive.session', $liveSession) }}" class="btn btn-light btn-sm ms-2">Join
                                Now</a>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <div class="container px-3 mt-1 mb-5">

            {{-- LIVE NOW --}}
            @if ($liveSessions->count() > 0)
                <section class="content-section" data-type="live">
                    <h2 class="section-title">
                        Live Now
                    </h2>
                    <div class="media-grid-wrapper">
                        @foreach ($liveSessions as $session)
                            <x-home.media-grid :title="$session->title" :image="$session->banner_image ? asset('storage/app/public/'.$session->banner_image) : null" :url="route('fitlive.session', $session)" :type="'live'"
                                :duration="null" :year="null" :rating="$session->viewer_peak" :description="'By ' . $session->instructor->name"
                                badgeClass="live-badge" />
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- CATEGORIES: UPCOMING + RECENT --}}
            @foreach ($categories as $category)
                @php
                    $categoryUpcoming = $upcomingSessions->where('category_id', $category->id);
                    $categoryRecent = $recentSessions->where('category_id', $category->id);
                @endphp

                @if ($categoryUpcoming->count() > 0 || $categoryRecent->count() > 0)
                    <section class="content-section">
                        <h3 class="section-title">
                            {{ $category->name }}
                        </h3>

                        {{-- Upcoming --}}
                        @if ($categoryUpcoming->count() > 0)
                            <h5 class="text-warning mb-3">Upcoming Sessions</h5>
                            <div class="media-grid-wrapper mb-4">
                                @foreach ($categoryUpcoming as $session)
                                    <x-home.media-grid :title="$session->title" :image="$session->banner_image ? asset('storage/app/public/'.$session->banner_image) : null" :url="route('fitlive.session', $session)"
                                        :type="'upcoming'" :duration="null" :year="$session->scheduled_at->format('Y')" :rating="null"
                                        badgeClass="upcoming-badge" :description="'By ' .
                                            $session->instructor->name .
                                            ' | ' .
                                            $session->scheduled_at->format('M d, g:i A')" />
                                @endforeach
                            </div>
                        @endif

                        {{-- Recently Ended --}}
                        @if ($categoryRecent->count() > 0)
                            <h5 class="text-secondary mb-3">Recently Ended</h5>
                            <div class="media-grid-wrapper">
                                @foreach ($categoryRecent as $session)
                                    <x-home.media-grid :title="$session->title" :image="$session->banner_image ? asset('storage/app/public/'.$session->banner_image) : null" :url="route('fitlive.session', $session)"
                                        :type="'ended'" :duration="null" :year="$session->updated_at->format('Y')" :rating="null"
                                        badgeClass="ended-badge" :description="'By ' .
                                            $session->instructor->name .
                                            ' | Ended on ' .
                                            $session->updated_at->format('M d')" />
                                @endforeach
                            </div>
                        @endif
                    </section>
                @endif
            @endforeach

        </div>
    </div>
@endsection
