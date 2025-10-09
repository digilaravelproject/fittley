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
    $fallbackImage = asset('storage/app/public/fitlive/banners/default-banner.jpg');

    // Smartly decide final image path
    if (!empty($video->banner_image_path)) {
        $finalImage = asset('storage/app/public/' . $video->banner_image_path);
    } elseif (!empty($video->banner_image)) {
        $finalImage = asset('storage/app/public/' . $video->banner_image);
    } else {
        $finalImage = $fallbackImage;
    }

    // Determine route parameters
    $finalRouteParams = $routeParams ?? ($categorySlug ? ['category' => $categorySlug] : $video);

    // Generate final URL
    $finalUrl = route($url, $finalRouteParams);
@endphp

<div class="content-card-wrapper ccw-portrait">
    <div class="content-card content-card-portrait" onclick="window.location.href='{{ $finalUrl }}'">
        @if ($badge)
            <div class="status-badge {{ $badgeClass }}">
                {{ $badge }}
            </div>
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
