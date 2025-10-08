@extends('layouts.public')

@section('title', 'FitExpertLive - Live Fitness Sessions')

@push('styles')
    <link rel="stylesheet" href="{{ asset('public/assets/home/css/fitdoc.index.css') }}?v={{ time() }}">
@endpush

@section('content')
    <div class="fitdoc-container">
        {{-- HERO SECTION --}}
        <section class="hero-section">
            <div class="container-fluid">
                <div class="hero-content">
                    <h1>Fit Expert live</h1>
                    <p>Join live fitness sessions with expert instructors</p>

                </div>
            </div>
        </section>

        <div class="container px-3 mt-1 mb-5">

             {{-- All --}}
                    @if ($fitexpert->count() > 0)
                        <div class="media-grid-wrapper">
                            @foreach ($fitexpert as $session)
                                <x-home.media-grid :title="$session->title" :image="$session->banner_image
                                    ? asset('storage/app/public/' . $session->banner_image)
                                    : null" :url="route('fitlive.session', $session)"
                                    :type="'live'" :duration="null" :year="$session->updated_at->format('Y')" :rating="null"
                                    badgeClass="live-badge" :description="'By ' .
                                        $session->instructor->name .
                                        ' | Ended on ' .
                                        $session->updated_at->format('M d')" />
                            @endforeach
                        </div>
                    @endif



        </div>
    </div>
@endsection
