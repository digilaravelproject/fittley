@extends('layouts.public')

@section('title', 'Daily Live Classes - Live Fitness Sessions')

@push('styles')
    <link rel="stylesheet" href="{{ asset('public/assets/home/css/fitdoc.index.css') }}?v={{ time() }}">
@endpush

@section('content')
    <div class="fitdoc-container">
        {{-- HERO SECTION --}}
        <section class="hero-section">
            <div class="container-fluid">
                <div class="hero-content">
                    <h1>Daily Live Classes</h1>
                    <p>Join live fitness sessions with expert instructors</p>

                </div>
            </div>
        </section>

        <div class="container px-3 mt-1 mb-5">

            {{-- All --}}
            @if ($subCategories->count() > 0)
                <div class="media-grid-wrapper landscape">
                    @foreach ($subCategories as $subCategory)

                        @php
                            $now = \Carbon\Carbon::now();
                            $sessions = $subCategory->fitLiveSessions ?? collect();
                            $sessions = $sessions->sortBy('scheduled_at')->values();

                            $liveSession = null;
                            $nextSession = null;
                            $status = 'upcoming';
                            $badgeLabel = 'Upcoming';
                            $badgeClass = 'upcoming-badge';

                            foreach ($sessions as $session) {
                                $start = \Carbon\Carbon::parse($session->scheduled_at);
                                $end = $start->copy()->addMinutes(60);

                                if ($now->between($start, $end)) {
                                    $liveSession = $session;
                                    $status = 'live';
                                    $badgeLabel = 'Live';
                                    $badgeClass = 'live-badge';
                                    break;
                                }

                                if ($start->gt($now)) {
                                    $nextSession = $session;
                                    break;
                                }
                            }

                            if (!$liveSession && $nextSession) {
                                $status = 'upcoming';
                                $badgeLabel = 'Upcoming';
                                $badgeClass = 'upcoming-badge';
                            } elseif (!$liveSession && !$nextSession && $sessions->count()) {
                                $status = 'ended';
                                $badgeLabel = 'Ended';
                                $badgeClass = 'ended-badge';
                            }

                        @endphp

                        {{-- Use media-grid to display the subcategory --}}
                        <x-home.media-grid :title="$subCategory->name" :image="$subCategory->banner_image ? asset('storage/app/public/' . $subCategory->banner_image) : null"
                            :url="route('fitlive.daily-classes.show', $subCategory->id)" :type="$badgeLabel" :duration="null"
                            :year="$subCategory->updated_at->format('Y')" :rating="null" :badgeClass="$badgeClass"
                            :class="'landscape'" />
                    @endforeach


                </div>
            @endif




        </div>
    </div>
@endsection