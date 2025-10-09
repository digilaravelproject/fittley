@extends('layouts.public')

@section('title', 'FitCast Live - Podcasts & Talks')

@push('styles')
    <link rel="stylesheet" href="{{ asset('public/assets/home/css/fitdoc.index.css') }}?v={{ time() }}">
@endpush
@section('content')
    <div class="fitdoc-container">
        <section class="hero-section">
            <div class="container-fluid">
                <h1>FitCast Live</h1>
                <p>Explore expert-led fitness podcasts, health talks, and lifestyle series — all in one place.</p>
            </div>
        </section>
        <div class="container px-2 mt-1 mb-5">
            @if ($fitcast->count() > 0)
                <section class="content-section">
                    {{-- <h5 class="section-title">Latest FitCast Episodes</h5> --}}
                    <div class="media-grid-wrapper">
                        @foreach ($fitcast->sortByDesc('id') as $episode)
                            <x-home.media-grid :title="$episode->title" :image="$episode->banner_image_url ?? 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3'"
                                :url="route('fitguide.single.show', $episode->slug)"
                                :year="optional($episode->created_at)->format('Y')" :rating="null"
                                :description="Str::limit($episode->description ?? 'Podcast episode', 100)" />
                        @endforeach
                    </div>
                </section>
            @else
                <div class="text-center py-5">
                    <h3 style="color: #fff;">No FitCast content available</h3>
                    <p style="color: #aaa;">We’re working on bringing you exciting new episodes soon!</p>
                </div>
            @endif
        </div>
    </div>
@endsection
