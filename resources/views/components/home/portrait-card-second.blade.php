{{-- Portrait Card with Title Below --}}
@props(['video', 'badge' => null, 'badgeClass' => null, 'url'])

@php
    $fallbackImage = asset('storage/app/public/fitlive/banners/default-banner.jpg');
    $finalImage = !empty($video->banner_image_path) ? $video->banner_image_path : $fallbackImage;
@endphp


<div class="content-card-wrapper ccw-portrait">
    {{-- Main Card --}}
    <div class="content-card content-card-portrait" onclick="window.location.href='{{ route($url, $video) }}'">
        @if ($badge)
            <div class="status-badge {{ $badgeClass }}">{{ $badge }}</div>
        @endif

        <img src="{{ $finalImage }}" alt="{{ $video->title }}" class="card-image" loading="lazy">

        {{-- Optional: Overlay icon --}}
        <div class="card-overlay">
            <div class="play-icon">
                <i class="fas fa-play"></i>
            </div>
        </div>
    </div>

    {{-- Title below image --}}
    <div class="card-caption">
        <h3 class="card-title">{{ $video->title }}</h3>
    </div>
</div>
