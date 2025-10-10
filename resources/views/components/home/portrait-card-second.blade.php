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
    $path = $video->banner_image_path;

    // Check if the path already contains '/storage/app/public/'
    if (strpos($path, '/storage/app/public/') === false) {
        $path = '/storage/app/public/' . ltrim($path, '/');
    }

    $finalImage = !empty($path)
        ? asset($path)
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
