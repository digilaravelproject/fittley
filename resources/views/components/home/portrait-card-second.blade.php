@props([
    'video',
    'badge' => null,
    'badgeClass' => null,
    'categorySlug' => null,
    'landscapeCard' => null,
    'routeParams' => null,
    'url'
])

@php
    // Fallback image path
    $fallbackImage = asset('storage/app/public/fitlive/banners/default-banner.jpg');

    // Final image logic
    $finalImage = !empty($video->banner_image_path)
        ? asset($video->banner_image_path)
        : $fallbackImage;

    // Route parameter logic
    $finalRouteParams = $routeParams ?? $video;

    // Generate route
    $finalUrl = route($url, $finalRouteParams);
@endphp

<div class="content-card-wrapper ccw-portrait">
    <div class="content-card content-card-portrait" onclick="window.location.href='{{ $finalUrl }}'">
        @if ($badge)
            <div class="status-badge {{ $badgeClass }}">{{ $badge }}</div>
        @endif

        <img src="{{ $finalImage }}" alt="{{ $video->title }}" class="card-image" loading="lazy">

        <div class="card-overlay">
            <div class="play-icon">
                <i class="fas fa-play"></i>
            </div>
        </div>
    </div>

    <div class="card-caption">
        <h3 class="card-title">{{ $video->title }}</h3>
    </div>
</div>
